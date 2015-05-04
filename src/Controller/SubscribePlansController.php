<?php

namespace GintonicCMS\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Core\Plugin;
use Cake\Core\Configure;
use Cake\Routing\Router;
use Stripe;

class SubscribePlansController extends AppController {

    var $name = "SubscribePlans";
    //public $uses = array('GintonicCMS.Transaction', 'GintonicCMS.SubscribePlan', 'GintonicCMS.UserCustomer', 'GintonicCMS.SubscribePlanUser');

    function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        if (Plugin::loaded('GintonicCMS')) {
            //$this->layout = 'GintonicCMS.users';
        }
        $this->__setStripe();
    }

    public function isAuthorized($user = null) {   
        return true;
    }
    
    public function index()
    {
        $plans = $this->SubscribePlans->find()
                ->all();
        $this->set('plans', $plans);
    }

    public function delete($planId = null)
    {
        if (!empty($planId)) {
            $plan = $this->SubscribePlans->get($planId);
            if ($this->SubscribePlans->delete($plan)) {
                $this->plan_delete($plan->plan_id);
                $this->Flash->set(__('Plan has been deleted successfully.'), [
                    'element' => 'GintonicCMS.alert',
                    'params' => ['class' => 'alert-success']
                ]);
            } else {
                $this->Flash->set(__('Unable to delete plan.'), [
                    'element' => 'GintonicCMS.alert',
                    'params' => ['class' => 'alert-danger']
                ]);
            }
        }
        $this->redirect($this->referer());
    }

    public function plan_delete($plan_id)
    {
        $plan = Stripe\Plan::retrieve($plan_id);
        $plan->delete();
        return;
    }

    public function create_plans($planId = null)
    {
        $this->__setStripe();
        
        if ($this->request->is(['post', 'put'])) {
            $flag=false;
            $name=$this->request->data['name'];
            
            if (empty($planId)) {
                $plan_id = $this->request->data['plan_id'];
                $amount = $this->request->data['amount'];
                $interval = $this->request->data['plan_interval'];
                $intervalCount = $this->request->data['interval_count'];
                $status = $this->request->data['status'];
                $plans = Stripe\Plan::all();
                $plans = $plans->__toArray();
                
                foreach ($plans['data'] as $key => $plan) {
                    $plan=$plan->__toArray();
                    if(empty($planId) && $plan['id'] == $plan_id){
                        $flag=true;
                        break;
                    }
                    if($plan['id'] == $plan_id && $plan['interval'] == $interval && $plan['interval_count'] == $interval_count && $plan['name'] == $name && $plan['amount'] == $amount){
                        $flag=true;
                        break;
                    }
                }
            }
            
            if($flag){
                $this->Flash->set(__('Plan already exists, Please enter another plan'), [
                    'element' => 'GintonicCMS.alert',
                    'params' => ['class' => 'alert-danger']
                ]);
            }else{
                if(!empty($planId)){
                    $this->request->data['id']=$planId;
                }else{
                    $this->request->data['amount'] = $amount;
                }
                $subscribePlan = $this->SubscribePlans->newEntity($this->request->data);
                if ($this->SubscribePlans->save($subscribePlan)) {
                    if (empty($planId)) {
                        //Create new plan
                        Stripe\Plan::create([
                            'amount' => $amount * 100,
                            'interval' => $interval,
                            'interval_count' => $intervalCount,
                            'name' => $name,
                            'currency' => 'usd',
                            'id' => $plan_id
                        ]);
                        
                    } else {
                        //update plan
                        $oldPlanId = $this->SubscribePlans->find()
                                ->where(['SubscribePlans.id' => $planId])
                                ->first();
                        
                        $p = Stripe\Plan::retrieve($oldPlanId['plan_id']);
                        $p->name = $name;
                        $p->save();
                    }
                    $this->Flash->set(__('Plan has been created successfully.'), [
                        'element' => 'GintonicCMS.alert',
                        'params' => ['class' => 'alert-success']
                    ]);
                    $this->redirect(Router::url(array('controller'=>'subscribe_plans','action'=>'index'),true));
                } else {
                    $this->Flash->set(__('Unable to create plan.'), [
                        'element' => 'GintonicCMS.alert',
                        'params' => ['class' => 'alert-danger']
                    ]);
                }
            }
        }
        if (!empty($planId) && empty($this->request->data)) {
            $plan = $this->SubscribePlans->find()
                    ->where(['SubscribePlans.id' => $planId])
                    ->first();
            $this->request->data = $plan->toArray();
            $this->request->data['amount'] = $this->request->data['amount'] / 100;
            $this->set('title','edit');
        }
    }

    public function user_subscribe() {
        $this->__setStripe();
        $customerId = ClassRegistry::init('GintonicCMS.UserCustomer')->getCustomerStripeId($this->Session->read('Auth.User.id'));
        $subscribePlans = array();
        if ($customerId) {
            $subscribes = Stripe_Customer::retrieve($customerId)->subscriptions->all();
            foreach ($subscribes->data as $key => $subscribe) {
                $subscribePlans[] = array(
                    'plan_id' => $subscribe->plan->id,
                    'plan_name' => $subscribe->plan->name,
                    'created' => date("Y-m-d H:i:s", $subscribe->plan->created),
                    'subscribe_id' => $subscribe->id
                );
            }
        }

        $this->set(compact('subscribePlans'));
        $this->set('subscribes', ClassRegistry::init('Transaction')->find('all', array('conditions' => array('Transaction.user_id' => $this->Session->read('Auth.User.id'), 'Transaction.transaction_type_id' => 2))));
    }

    public function unsubscribe_user($subscribeId = null) {
        $this->__setStripe();
        if (!empty($subscribeId)) {
            $customerId = ClassRegistry::init('GintonicCMS.UserCustomer')->getCustomerStripeId($this->Session->read('Auth.User.id'));
            $subscribeStatus = Stripe_Customer::retrieve($customerId)->subscriptions->retrieve($subscribeId)->cancel();
            if ($subscribeStatus->status == "canceled") {
                $planDetail = $this->SubscribePlan->getPlanDetail($subscribeStatus->plan->id);
                $response = $this->SubscribePlanUser->addToSubscribeList($planDetail['SubscribePlan']['id'], $this->Session->read('Auth.User.id'), 'fail');
                $this->Session->setFlash(__('This Plan has been unsubscribe successfully.'), 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            } else {
                $this->Session->setFlash(__('Unable to unsubscribe this plan.'), 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
            }
        } else {
            $this->Session->setFlash(__('Unable to unsubscribe this plan.'), 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
        }
        $this->redirect($this->referer());
    }

    public function usertransaction($planId = null)
    {
        if (empty($planId)) {
            $this->Flash->set(__('Invalid plan, Please try again.'), [
                'element' => 'GintonicCMS.alert',
                'params' => ['class' => 'alert-danger']
            ]);
            $this->redirect($this->referer());
        }
        
        $planDetail = $this->SubscribePlans->find()
                ->where(['SubscribePlans.plan_id' => $planId])
                ->first();
        
        $this->loadModel('GintonicCMS.Users');
        $userList = $this->Users->find('list', [
                        'keyField' => 'id',
                        'valueField' => ['first','last']
                    ]);
        $userList = $userList->toArray();
        foreach ($userList as $key => $user){
            $userList[$key] = str_replace(';', ' ', $user);
        }
        $backUrl = Router::url(array('controller' => 'subscribe_plans', 'action' => 'index'), true);
        $this->set(compact('backUrl', 'userList', 'planDetail'));
    }

    public function myplantransaction($planId = null, $userId = null, $allTransaction = false)
    {
        $conditions = [
            'Transactions.paid' => 1,
            'Transactions.transaction_type_id' => 2,
        ];
        if ($allTransaction) {
            unset($conditions['Transactions.user_id']);
        }
        if (!empty($planId)) {
            $conditions['Transactions.plan_id'] = $planId;
        }
        if (!empty($userId)) {
            $conditions['Transactions.user_id'] = $this->request->session()->read('Auth.User.id');
        }
        if (empty($planId) && empty($userId) && empty($allTransaction)) {
            $conditions['Transaction.user_id'] = $this->request->session()->read('Auth.User.id');
        }
        
        $this->loadModel('GintonicCMS.Transactions');
        $transactions = $this->Transactions->find()
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
        $this->set('transactions', $this->paginate($transactions));
        
        $all = false;
        if (empty($planId)) {
            $all = true;
        }
        $this->set(compact('all'));
        $this->loadModel('GintonicCMS.SubscribePlans');
        $planDetail = $this->SubscribePlans->find()
                ->where(['SubscribePlans.plan_id' => $planId]);
        
        $title = ' Transactions ' . (empty($planDetail->id) ? '' : ('for ' . $planDetail['plan_id'] . ' plan'));
        if (empty($planId) && empty($userId) && empty($allTransaction)) {
            $title = 'My Transactions';
        }
        $backUrl = Router::url($this->referer(), true);
        $this->set(compact('planDetail', 'title', 'allTransaction', 'backUrl'));
    }

    function subscribeslist()
    {
        $this->loadModel('GintonicCMS.UserCustomers');
        $userId = $this->request->session()->read('Auth.User.id');
        $customerId = $this->UserCustomers->getCustomerStripeId($userId);
        exit;
        //$customerId = ClassRegistry::init('GintonicCMS.UserCustomer')->getCustomerStripeId($this->Session->read('Auth.User.id'));
        $arrSubscribePlans = array();
        if ($customerId) {
            try {
                $customer = Stripe_Customer::retrieve($customerId);
                if (!empty($customer->subscriptions)) {
                    $subscribes = Stripe_Customer::retrieve($customerId)->subscriptions->all();
                    $plans = ClassRegistry::init('GintonicCMS.SubscribePlan')->find('list', array('fields' => array('plan_id', 'plan_id')));
                    foreach ($subscribes->data as $key => $subscribe) {
                        if (in_array($subscribe->plan->id, $plans)) {
                            $arrSubscribePlans[$subscribe->plan->id] = $subscribe->id;
                        }
                    }
                }
            } catch (Exception $ex) {
                
            }
        }
        $this->set(compact('arrSubscribePlans'));
        $this->set('plans', ClassRegistry::init('GintonicCMS.SubscribePlan')->find('all'));
    }

    private function __setStripe()
    {
        Stripe\Stripe::setApiKey(Configure::read('Stripe.secret_key'));
    }
}
