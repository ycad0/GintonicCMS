<?php

namespace GintonicCMS\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Event\Event;
use Stripe;

class PaymentsController extends AppController
{
    /**
     * TODO: write comment
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->__setStripe();

        if (Plugin::loaded('GintonicCMS')) {
            $this->layout = 'GintonicCMS.default';
        }
        $this->loadModel('GintonicCMS.Transactions');
        $this->loadModel('GintonicCMS.SubscribePlan');
        $this->loadModel('GintonicCMS.UserCustomer');
        $this->loadModel('GintonicCMS.SubscribePlanUser');
        $this->Auth->allow('callbackSubscribes', 'oneTimePaymentSetAmount', 'oneTimePayment', 'success', 'fail', 'confirmPayment');
    }

    /**
     * TODO: write comment
     */
    public function isAuthorized($user = null)
    {
        return true;
    }

    /**
     * TODO: write comment
     */
    public function index($planId = null, $userId = null)
    {
        $conditions = [
            'Transactions.paid' => 1
        ];
        if (!empty($planId)) {
            $conditions['Transactions.plan_id'] = $planId;
            $conditions['Transactions.user_id'] = $this->request->session()->read('Auth.User.id');
        }
        if (!empty($userId)) {
            $conditions['Transactions.user_id'] = $userId;
        } elseif (empty($userId)) {
            $conditions['Transactions.user_id'] = $this->request->session()->read('Auth.User.id');
        }

        $transaction = $this->Transactions->getTransaction($conditions);
        $this->set('transactions', $this->paginate($transaction));
    }

    /**
     * TODO: write comment
     */
    public function callbackSubscribes()
    {
        $input = @file_get_contents("php://input");
        $eventJson = json_decode($input);
        $this->Transactions->addTransactionSubscribe($eventJson);
        exit;
    }

    /**
     * TODO: write comment
     */
    public function oneTimePayment()
    {
        if (!empty($this->request->data['stripeToken'])) {
            $amountKey = 'Stripe.' . $this->request->data['key'];

            if ($this->request->session()->check($amountKey)) {
                $userId = $this->request->session()->read('Auth.User.id');
                $amount = $this->request->session()->read($amountKey);
                try {
                    // Create a Customer
                    $customer = $this->__createCustomer($this->request->data['stripeEmail'], $this->request->data['stripeToken']);

                    // Charge the Customer instead of the card
                    $charge = $this->__createCharge($customer->id, $amount);

                    $arrDetail = [
                        'transaction_type_id' => 1,
                        'fixed_price' => 1,
                        'stripe' => $charge
                    ];
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
        return $this->redirect($this->referer());
    }

    /**
     * TODO: write comment
     */
    public function subscribe()
    {
        if (!empty($this->request->data['stripeToken'])) {
            $amountKey = 'Stripe.' . $this->request->data['key'];

            if ($this->request->session()->check($amountKey)) {
                $amount = $this->request->session()->read($amountKey);

                try {
                    // Create a Customer / get customer
                    $userId = $this->request->session()->read('Auth.User.id');
                    $customerId = $this->getCustomerId($this->request->session()->read('Auth.User.id'), $this->request->data['stripeEmail'], $this->request->data['stripeToken']);
                    $customer = Stripe\Customer::retrieve($customerId);
                    $subscribe = $customer->subscriptions->create(array("plan" => $this->request->data['plan_id']));
                    $subscribe->paid = ($subscribe->status == 'active') ? 1 : 0;
                    $subscribe->currency = $subscribe->plan->currency;
                    $card = $this->__getCardInfo($customerId);
                    $subscribe->card = (object)array('name' => $card->name, 'brand' => $card->brand, 'last4' => $card->last4);
                    $subscribe->amount = $subscribe->plan->amount;
                    $arrDetail = [
                        'transaction_type_id' => 2,
                        'fixed_price' => 1,
                        'plan_id' => $this->request->data['plan_id'],
                        'plan_name' => $subscribe->plan->name,
                        'stripe' => $subscribe
                    ];
                    $redirectUrl = $this->referer();

                    if ($subscribe->paid) {
                        $this->loadModel('GintonicCMS.SubscribePlans');
                        $this->loadModel('GintonicCMS.SubscribePlanUsers');
                        $transaction = $this->Transactions->addTransaction($arrDetail, $userId);
                        $planDetail = $this->SubscribePlans->getPlanDetail($arrDetail['plan_id']);
                        $response = $this->SubscribePlanUsers->addToSubscribeList($planDetail['id'], $this->request->session()->read('Auth.User.id'));
                        $this->Flash->set(__('Subscribe has been successfully completed.'), [
                            'element' => 'GintonicCMS.alert',
                            'params' => ['class' => 'alert-success']
                        ]);

                        if (!empty($this->request->data['success_url'])) {
                            $this->loadComponent('GintonicCMS.Transac');
                            $redirectUrl = $this->request->data['success_url'] . '?transaction=' . $this->Transac->setLastTransaction($transaction);
                        }
                    } else {
                        $this->Flash->set(__('Unable to process your subscribe request, Please try again.'), [
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
        $this->Flash->set(__('Unable to process your subscribe request, Please try again.'), [
            'element' => 'GintonicCMS.alert',
            'params' => ['class' => 'alert-danger']
        ]);
        return $this->redirect($this->referer());
    }

    /**
     * TODO: write comment
     */
    public function getCustomerId($userId = null, $stripeEmail = null, $stripeToken = null)
    {
        if (!empty($userId)) {
            $this->loadModel('UserCustomers');
            $userCustomer = $this->UserCustomers->find()
                ->where(['UserCustomers.user_id' => $userId])
                ->first();

            if (!empty($userCustomer)) {
                return $userCustomer->customer_id;
            } else {
                if (!empty($stripeEmail) && !empty($stripeToken)) {
                    $customer = $this->__createCustomer($stripeEmail, $stripeToken);
                    $arrCustomer = [
                        'user_id' => $userId,
                        'customer_id' => $customer->id,
                    ];
                    $userCustomer = $this->UserCustomers->newEntity($arrCustomer);
                    $this->UserCustomers->save($userCustomer);
                    return $customer->id;
                }
            }
        }
        return false;
    }

    /**
     * TODO: write comment
     */
    public function oneTimePaymentSetAmount()
    {
        if ($this->request->is('requested')) {
            $amountKey = md5($this->request->query['amount']);
            $this->request->session()->write('Stripe.' . $amountKey, $this->request->query['amount']);
            $this->response->body($amountKey);
            return $this->response;
        } else {
            $this->FlashMessage->setWarning(__('Invalid Opration'));
            return $this->redirect($this->referer());
        }
    }

    /**
     * TODO: write comment
     */
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
            return $this->redirect($this->referer());
        }
    }

    /**
     * TODO: write comment
     */
    public function fail()
    {
        //Maintain Fail Transaction.
    }

    /**
     * TODO: Write comment.
     */
    public function confirmPayment()
    {
        if (!empty($this->request->data['stripeToken'])) {
            try {
                $userId = $this->request->session()->read('Auth.User.id');

                $customer = $this->__createCustomer($this->request->data['email'], $this->request->data['stripeToken']);

                $charge = $this->__createCharge($customer->id, ((float)$this->request->data['amount']) * 100);

                $arrDetail = [
                    'transaction_type_id' => 1,
                    'fixed_price' => 1,
                    'stripe' => $charge
                ];
                $redirectUrl = $this->referer();

                if ($charge->paid) {
                    $transaction = $this->Transactions->addTransaction($arrDetail, $userId);
                    $this->Flash->set(__('Payment process has been successfully completed.'), [
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
                    if (!empty($this->request->data['fail_url'])) {
                        $redirectUrl = $this->request->data['fail_url'];
                    }
                }
                return $this->redirect($redirectUrl);
            } catch (Exception $e) {
                //debug($e);
            }
        }
    }

    /**
     * TODO: write comment
     */
    private function __setStripe()
    {
        Stripe\Stripe::setApiKey(Configure::read('Stripe.secret_key'));
    }

    /**
     * TODO: write comment.
     */
    private function __getCardInfo($customerId = null)
    {
        if (!empty($customerId)) {
            $card = Stripe\Customer::retrieve($customerId)->sources->all(array(
                "object" => "card"
            ));
            return $card->data[0];
        }
        return false;
    }

    /**
     * TODO: Write Comment
     */
    private function __createCustomer($email, $token)
    {
        return Stripe\Customer::create([
                'email' => $email,
                'card' => $token
        ]);
    }

    /**
     * TODO: Write Comment
     */
    private function __createCharge($customerId, $amount)
    {
        return Stripe\Charge::create([
                'customer' => $customerId,
                'amount' => $amount,
                'currency' => Configure::read('Stripe.currency')
        ]);
    }
}
