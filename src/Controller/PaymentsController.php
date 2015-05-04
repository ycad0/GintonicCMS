<?php

namespace GintonicCMS\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Core\Plugin;
use Cake\Core\Configure;
use Stripe;

class PaymentsController extends AppController
{
    public $name = 'Payments';

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        if (Plugin::loaded('GintonicCMS')) {
            $this->layout = 'GintonicCMS.default';
        }
        $this->loadModel('GintonicCMS.Transactions');
        $this->loadModel('GintonicCMS.SubscribePlan');
        $this->loadModel('GintonicCMS.UserCustomer');
        $this->loadModel('GintonicCMS.SubscribePlanUser');
        $this->Auth->allow('callback_subscribes', 'one_time_payment_set_amount', 'one_time_payment', 'success', 'fail', 'confirm_payment');
    }

    public function isAuthorized($user = null) {
        
        return true;
    }

    public function index($planId = null, $userId = null)
    {
        $conditions = array(
            'Transactions.paid' => 1,
        );
        if (!empty($planId)) {
            $conditions['Transactions.plan_id'] = $planId;
            $conditions['Transactions.user_id'] = $this->request->session()->read('Auth.User.id');
        }
        if (!empty($userId)) {
            $conditions['Transactions.user_id'] = $userId;
        } elseif(empty ($userId)) {
            $conditions['Transactions.user_id'] = $this->request->session()->read('Auth.User.id');
        }
        
        $transaction = $this->Transactions->find()
                        ->where($conditions)
                        ->contain([
                            'Users' => function($query){
                                return $query
                                        ->select(['Users.id', 'Users.first', 'Users.last']);
                            },
                            'TransactionTypes' => function($query){
                                return $query
                                        ->select(['TransactionTypes.name']);
                            }
                        ])
                        ->order(['Transactions.created' => 'desc']);
        $this->set('transactions', $this->paginate($transaction));
    }
    
    public function callback_subscribes()
    {
        $this->__setStripe();
        $input = @file_get_contents("php://input");
        $event_json = json_decode($input);
        /* $fileName="transaction_".$event_json->data->object->customer.".txt";
          $myfile = fopen(TMP.$fileName, "w");
          fwrite($myfile, "datatttt  ");
          fwrite($myfile, print_r($event_json, TRUE));
          fclose($myfile); */
        $this->Transactions->addTransactionSubscribe($event_json);
        exit;
    }

    public function one_time_payment()
    {
        $this->__setStripe();
        
        if (!empty($this->request->data['stripeToken'])) {
            $amountKey = 'Stripe.' . $this->request->data['key'];
            
            if ($this->request->session()->check($amountKey)) {
                $userId = $this->request->session()->read('Auth.User.id');
                $amount = $this->request->session()->read($amountKey);
                try {
                    // Create a Customer
                    $customer = Stripe\Customer::create([
                        'email' => $this->request->data['stripeEmail'],
                        'card' => $this->request->data['stripeToken']
                    ]);
                    
                    // Charge the Customer instead of the card
                    $charge = Stripe\Charge::create([
                        'customer' => $customer->id,
                        'amount' => $amount,
                        'currency' => Configure::read('Stripe.currency')
                    ]);
                    
                    $arrDetail = array(
                        'transaction_type_id' => 1,
                        'fixed_price' => 1,
                        'stripe' => $charge
                    );
                    $redirectUrl = $this->referer();
                    if ($charge->paid) {
                        $transaction = $this->Transactions->addTransaction($arrDetail, $userId);
                        $this->Flash->set(__('Payment process has been successfully completed'), [
                            'element' => 'GintonicCMS.alert',
                            'params' => ['class' => 'alert-success']
                        ]);
                        if (!empty($this->request->data['success_url'])) {
                            $this->loadComponent('GintonicCMS.Transac');
                            $redirectUrl = $this->request->data['success_url'] . '?transaction=' . $this->Transac->setLastTransaction($transaction);
                        }
                    } else {
                        $this->Flash->set(__('Unable to process your payment request, Please try again.'), [
                            'element' => 'GintonicCMS.alert',
                            'params' => ['class' => 'alert-danger']
                        ]);
                        if (!empty($this->request->data['Stripe']['fail_url'])) {
                            $redirectUrl = $this->request->data['Stripe']['fail_url'];
                        }
                    }
                    return $this->redirect($redirectUrl);
                } catch (Exception $e) {
                    //debug($e);
                }
            }
        }
        $this->Flash->set(__('Unable to process your payment request, Please try again.'), [
            'element' => 'GintonicCMS.alert',
            'params' => ['class' => 'alert-danger']
        ]);
        $this->redirect($this->referer());
    }

    public function subscribe()
    {
        $this->__setStripe();
        if (!empty($this->request->data['stripeToken'])) {
            $amountKey = 'Stripe.' . $this->request->data['Stripe']['key'];
            if ($this->request->session()->check($amountKey)) {
                $amount = $this->request->session()->read($amountKey);
                try {
                    // Create a Customer / get customer
                    $customerId = $this->getCustomerId($this->request->session()->read('Auth.User.id'), $this->request->data['stripeEmail'], $this->request->data['stripeToken']);
                    $customer = Stripe_Customer::retrieve($customerId);
                    $subscribe = $customer->subscriptions->create(array("plan" => $this->request->data['Stripe']['plan_id']));
                    $subscribe->paid = ($subscribe->status == 'active') ? 1 : 0;
                    $subscribe->currency = $subscribe->plan->currency;
                    $subscribe->card = (object) array('name' => $customer->cards->data[0]->name, 'brand' => $customer->cards->data[0]->brand, 'last4' => $customer->cards->data[0]->last4);
                    $subscribe->amount = $subscribe->plan->amount;
                    $arrDetail = array(
                        'transaction_type_id' => 2,
                        'fixed_price' => 1,
                        'plan_id' => $this->request->data['Stripe']['plan_id'],
                        'plan_name' => $subscribe->plan->name,
                        'stripe' => $subscribe
                    );
                    $redirectUrl = $this->referer();
                    if ($subscribe->paid) {
                        $transaction = $this->Transaction->addTransaction($arrDetail);
                        $planDetail = $this->SubscribePlan->getPlanDetail($arrDetail['plan_id']);
                        $response = $this->SubscribePlanUser->addToSubscribeList($planDetail['SubscribePlan']['id'], $this->request->session()->read('Auth.User.id'));
                        $this->FlashMessage->setSuccess(__('Subscribe has been successfully completed'));
                        if (!empty($this->request->data['Stripe']['success_url'])) {
                            $this->Transac = $this->Components->load('GintonicCMS.Transac');
                            $redirectUrl = $this->request->data['Stripe']['success_url'] . '/transaction:' . $this->Transac->setLastTransaction($transaction);
                        }
                    } else {
                        $this->FlashMessage->setWarning(__('Unable to process your subscribe request, Please try again.'));
                        if (!empty($this->request->data['Stripe']['fail_url'])) {
                            $redirectUrl = $this->request->data['Stripe']['fail_url'];
                        }
                    }
                    $this->redirect($redirectUrl);
                } catch (Exception $e) {
                    //debug($e);
                }
            }
        }
        $this->FlashMessage->setWarning(__('Unable to process your subscribe request, Please try again.'), $this->referer());
    }

    function getCustomerId($userId = null, $stripeEmail = null, $stripeToken = null)
    {
        if (!empty($userId)) {
            $userCustomer = $this->UserCustomer->find('first', array('conditions' => array('UserCustomer.user_id' => $userId)));
            if (!empty($userCustomer)) {
                return $userCustomer['UserCustomer']['customer_id'];
            } else {
                if (!empty($stripeEmail) && !empty($stripeToken)) {
                    $customer = Stripe_Customer::create(array(
                                'email' => $stripeEmail,
                                'card' => $stripeToken
                    ));
                    $arrCustomer['UserCustomer'] = array(
                        'user_id' => $userId,
                        'customer_id' => $customer->id,
                    );
                    $this->UserCustomer->save($arrCustomer);
                    return $customer->id;
                }
            }
        }
        return false;
    }

    public function one_time_payment_set_amount()
    {
        $this->__setStripe();
        if ($this->request->is('requested')) {
            //$amountKey = md5($this->request->named['amount']);
            $amountKey = md5($this->request->query['amount']);
            $this->request->session()->write('Stripe.' . $amountKey, $this->request->query['amount']);
            $this->response->body($amountKey);
            return $this->response;
            //return $amountKey;
        } else {
            $this->FlashMessage->setWarning(__('Invalid Opration'));
            $this->redirect($this->referer());
        }
    }

    public function success()
    {
        if (isset($this->request->query['transaction'])) {
            $this->loadComponent('GintonicCMS.Transac');
            $transactionDetail = $this->Transac->getLastTransaction($this->request->query['transaction']);
            $this->set('transactionId', $this->request->query['transaction']);
            $this->set('transactionDetail', $transactionDetail);
        } else {
            $this->Flash->set(__('Invalid Opration'), [
                'element' => 'GintonicCMS.alert',
                'params' => ['class' => 'alert-danger']
            ]);
            $this->redirect($this->referer());
        }
    }

    public function fail()
    {
        
    }

    public function confirm_payment()
    {
        $this->__setStripe();

        if (!empty($this->request->data['stripeToken']) && !empty($this->request->data['payment'])) {
            try {
                $customer = Stripe_Customer::create(array(
                            'email' => $this->request->data['payment']['email'],
                            'card' => $this->request->data['stripeToken']
                ));

                $charge = Stripe_Charge::create(array(
                            'customer' => $customer->id,
                            'amount' => ((float) $this->request->data['payment']['amount']) * 100,
                            'currency' => Configure::read('Stripe.currency')
                ));
                $arrDetail = array(
                    'transaction_type_id' => 1,
                    'fixed_price' => 1,
                    'stripe' => $charge
                );
                $redirectUrl = $this->referer();
                if ($charge->paid) {
                    $transaction = $this->Transactions->addTransaction($arrDetail);
                    $this->Session->setFlash(__('Payment process has been successfully completed'), 'alert', array(
                        'plugin' => 'BoostCake',
                        'class' => 'alert-success'
                    ));
                    if (!empty($this->request->data['payment']['success_url'])) {
                        $this->Transac = $this->Components->load('GintonicCMS.Transac');
                        $redirectUrl = $this->request->data['payment']['success_url'] . '/transaction:' . $this->Transac->setLastTransaction($transaction);
                    }
                } else {
                    $this->Session->setFlash(__('Unable to process your payment request, Please try again.'), 'alert', array(
                        'plugin' => 'BoostCake',
                        'class' => 'alert-danger'
                    ));
                    if (!empty($this->request->data['payment']['fail_url'])) {
                        $redirectUrl = $this->request->data['payment']['fail_url'];
                    }
                }
                $this->redirect($redirectUrl);
            } catch (Exception $e) {
                //debug($e);
            }
        }
    }

    private function __setStripe()
    {
        Stripe\Stripe::setApiKey(Configure::read('Stripe.secret_key'));
    }

}