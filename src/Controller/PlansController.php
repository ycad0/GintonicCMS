<?php

namespace GintonicCMS\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Routing\Router;
use Stripe;

class PlansController extends AppController
{
    /**
     * TODO: Write Comments.
     */
    public function beforeFilter(Event $event)
    {
        $this->__setStripe();
    }

    /**
     * TODO: Write Comments.
     */
    public function isAuthorized($user = null)
    {
        return true;
    }

    /**
     * TODO: Write Comments.
     */
    public function index()
    {
        $plans = $this->Plans->find()
                ->all();
        $this->set('plans', $plans);
    }

    /**
     * TODO: Write Comments.
     */
    public function delete($planId = null)
    {
        if (!empty($planId)) {
            $plan = $this->Plans->get($planId);
            if ($this->Plans->delete($plan)) {
                $this->planDelete($plan->plan_id);
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
        return $this->redirect($this->referer());
    }

    /**
     * TODO: Write Comments.
     */
    public function planDelete($planId)
    {
        $plan = Stripe\Plan::retrieve($planId);
        $plan->delete();
        return;
    }

    /**
     * TODO: Write Comments.
     */
    public function createPlans($planId = null)
    {
        $this->__setStripe();

        if ($this->request->is(['post', 'put'])) {
            $flag = false;
            $name = $this->request->data['name'];

            if (empty($planId)) {
                $newPlanId = $this->request->data['plan_id'];
                $amount = $this->request->data['amount'];
                $interval = $this->request->data['plan_interval'];
                $intervalCount = $this->request->data['interval_count'];
                $status = $this->request->data['status'];
                $plans = Stripe\Plan::all();
                $plans = $plans->__toArray();

                foreach ($plans['data'] as $key => $plan) {
                    $plan = $plan->__toArray();
                    if (empty($planId) && $plan['id'] == $newPlanId) {
                        $flag = true;
                        break;
                    }
                    if ($plan['id'] == $newPlanId && $plan['interval'] == $interval && $plan['interval_count'] == $intervalCount && $plan['name'] == $name && $plan['amount'] == $amount) {
                        $flag = true;
                        break;
                    }
                }
            }

            if ($flag) {
                $this->Flash->set(__('Plan already exists, Please enter another plan'), [
                    'element' => 'GintonicCMS.alert',
                    'params' => ['class' => 'alert-danger']
                ]);
            } else {
                if (!empty($planId)) {
                    $this->request->data['id'] = $planId;
                } else {
                    $this->request->data['amount'] = $amount;
                }
                $subscribePlan = $this->Plans->newEntity($this->request->data);
                if ($this->Plans->save($subscribePlan)) {
                    if (empty($planId)) {
                        //Create new plan
                        Stripe\Plan::create([
                            'amount' => $amount * 100,
                            'interval' => $interval,
                            'interval_count' => $intervalCount,
                            'name' => $name,
                            'currency' => 'usd',
                            'id' => $newPlanId
                        ]);
                    } else {
                        //update plan
                        $oldPlanId = $this->Plans->find()
                                ->where(['Plans.id' => $planId])
                                ->first();

                        $p = Stripe\Plan::retrieve($oldPlanId['plan_id']);
                        $p->name = $name;
                        $p->save();
                    }
                    $this->Flash->set(__('Plan has been created successfully.'), [
                        'element' => 'GintonicCMS.alert',
                        'params' => ['class' => 'alert-success']
                    ]);
                    return $this->redirect(Router::url(array('controller' => 'plans', 'action' => 'index'), true));
                } else {
                    $this->Flash->set(__('Unable to create plan.'), [
                        'element' => 'GintonicCMS.alert',
                        'params' => ['class' => 'alert-danger']
                    ]);
                }
            }
        }
        if (!empty($planId) && empty($this->request->data)) {
            $plan = $this->Plans->find()
                    ->where(['Plans.id' => $planId])
                    ->first();
            $this->request->data = $plan->toArray();
            $this->request->data['amount'] = $this->request->data['amount'] / 100;
            $this->set('title', 'edit');
        }
    }

    /**
     * TODO: Write Comments.
     */
    public function userSubscribe()
    {
        $this->loadModel('GintonicCMS.CustomersUsers');
        $this->loadModel('GintonicCMS.Transactions');
        $userId = $this->request->session()->read('Auth.User.id');
        
        $customerId = $this->CustomersUsers->find('customerStripeId', ['userId' => $userId]);
        $plans = [];
        if ($customerId) {
            $subscribes = Stripe\Customer::retrieve($customerId)->subscriptions->all();
            foreach ($subscribes->data as $key => $subscribe) {
                $plans[] = array(
                    'plan_id' => $subscribe->plan->id,
                    'plan_name' => $subscribe->plan->name,
                    'created' => date("Y-m-d H:i:s", $subscribe->plan->created),
                    'subscribe_id' => $subscribe->id
                );
            }
        }
        $transactions = $this->Transactions->find()
                ->where(['Transactions.user_id' => $userId, 'Transactions.transaction_type_id' => 2])
                ->all();
        $this->set(compact('plans'));
        $this->set('subscribes', $transactions);
    }

    /**
     * TODO: Write Comments.
     */
    public function unsubscribeUser($subscribeId = null)
    {
        if (!empty($subscribeId)) {
            $userId = $this->request->session()->read('Auth.User.id');
            $this->loadModel('GintonicCMS.CustomersUsers');
            $this->loadModel('GintonicCMS.Plans');
            $this->loadModel('GintonicCMS.PlansUsers');
            
            $customerId = $this->CustomersUsers->find('customerStripeId', ['userId' => $userId]);
            $subscribeStatus = Stripe\Customer::retrieve($customerId)->subscriptions->retrieve($subscribeId)->cancel();
            if ($subscribeStatus->status == "canceled") {
                $planDetail = $this->Plans->find('planDetails', ['planId' => $subscribeStatus->plan->id]);
                $response = $this->PlansUsers->addToSubscribeList($planDetail['id'], $userId, 'fail');
                $this->Flash->set(__('Plan has been unsubscribe successfully.'), [
                    'element' => 'GintonicCMS.alert',
                    'params' => ['class' => 'alert-success']
                ]);
            } else {
                $this->Flash->set(__('Unable to unsubscribe this plan.'), [
                    'element' => 'GintonicCMS.alert',
                    'params' => ['class' => 'alert-danger']
                ]);
            }
        } else {
            $this->Flash->set(__('Unable to unsubscribe this plan.'), [
                'element' => 'GintonicCMS.alert',
                'params' => ['class' => 'alert-danger']
            ]);
        }
        return $this->redirect($this->referer());
    }

    /**
     * TODO: Write Comments.
     */
    public function usertransaction($planId = null)
    {
        if (empty($planId)) {
            $this->Flash->set(__('Invalid plan, Please try again.'), [
                'element' => 'GintonicCMS.alert',
                'params' => ['class' => 'alert-danger']
            ]);
            return $this->redirect($this->referer());
        }
        $this->loadModel('GintonicCMS.Plans');

        $planUsers = $this->Plans->find('planDetails', ['planId' => $planId]);
                
        $this->loadModel('GintonicCMS.Users');
        $userList = $this->Users->find('list', [
            'keyField' => 'id',
            'valueField' => ['first', 'last']
        ]);

        $userList = $userList->toArray();
        foreach ($userList as $key => $user) {
            $userList[$key] = str_replace(';', ' ', $user);
        }
        $title = $planUsers->plan_id . ' plan (' . $planUsers->name . ') users';
        $backUrl = Router::url(array('controller' => 'plans', 'action' => 'index'), true);
        $this->set(compact('title', 'backUrl', 'planUsers', 'userList'));
    }

    /**
     * TODO: Write Comments.
     */
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
        $transactions = $this->Transactions->find('transactions', $conditions);
        $this->set('transactions', $this->paginate($transactions));

        $all = false;
        if (empty($planId)) {
            $all = true;
        }
        $this->set(compact('all'));
        $this->loadModel('GintonicCMS.Plans');
        $planDetail = $this->Plans->find()
                ->where(['Plans.plan_id' => $planId]);

        $title = ' Transactions ' . (empty($planDetail->id) ? '' : ('for ' . $planDetail['plan_id'] . ' plan'));
        if (empty($planId) && empty($userId) && empty($allTransaction)) {
            $title = 'My Transactions';
        }
        $backUrl = Router::url($this->referer(), true);
        $this->set(compact('planDetail', 'title', 'allTransaction', 'backUrl'));
    }

    /**
     * TODO: Write Comments.
     */
    public function subscribeslist()
    {
        $this->loadModel('GintonicCMS.CustomersUsers');
        $this->loadModel('GintonicCMS.Plans');
        $userId = $this->request->session()->read('Auth.User.id');
        $customerId = $this->CustomersUsers->find('customerStripeId', ['userId' => $userId]);
        $arrPlans = array();
        if ($customerId) {
            try {
                $customer = Stripe\Customer::retrieve($customerId);
                if (!empty($customer->subscriptions)) {
                    $subscribes = Stripe\Customer::retrieve($customerId)->subscriptions->all();
                    $plans = $this->Plans->find('list', [
                        'keyField' => 'plan_id',
                        'valueField' => 'plan_id'
                    ]);

                    foreach ($subscribes->data as $key => $subscribe) {
                        if (in_array($subscribe->plan->id, $plans->toArray())) {
                            $arrPlans[$subscribe->plan->id] = $subscribe->id;
                        }
                    }
                }
            } catch (Exception $ex) {
                //debug($ex);
            }
        }
        $this->set(compact('arrPlans'));
        $this->set('plans', $this->Plans->find());
    }

    /**
     * TODO: Write Comments.
     */
    private function __setStripe()
    {
        Stripe\Stripe::setApiKey(Configure::read('Stripe.secret_key'));
    }
}
