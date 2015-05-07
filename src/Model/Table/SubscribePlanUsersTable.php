<?php

namespace GintonicCMS\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

class SubscribePlanUsersTable extends Table
{
    /**
     * TODO: write comment
     */
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'modified' => 'always'
                ]
            ]
        ]);
        
        $this->addBehavior('CounterCache', [
            'SubscribePlans' => ['plan_user_count']
        ]);
        $this->addAssociations([
            'belongsTo' => [
                'SubscribePlans' => [
                    'className' => 'SubscribePlans',
                    'foreignKey' => 'plan_id',
                    'counterCache' => true
                ],
                'Users' => [
                    'className' => 'Users',
                    'foreignKey' => 'user_id',
                    'propertyName' => 'Users'
                ]
            ]
        ]);
        parent::initialize($config);
    }

    /**
     * TODO: write comment
     */
    public function addToSubscribeList($planId = null, $userId = null, $status = 'active', $lastCharged = '')
    {
        //planId is integer
        $subscriptionData = [
            'user_id' => $userId,
            'plan_id' => $planId,
        ];
        
        $oldPlan = $this->find()
                    ->where(['SubscribePlanUsers.user_id' => $userId, 'SubscribePlanUsers.plan_id' => $planId])
                    ->first();
        
        if (!empty($oldPlan)) {
            $subscriptionData['id'] = $oldPlan->id;
        }
        
        if (!empty($lastCharged)) {
            $subscriptionData['last_charged'] = $lastCharged;
        }
        
        $subscriptionData['status'] = $status;
        $subscribe = $this->newEntity($subscriptionData);
        if ($this->save($subscribe)) {
            return true;
        }
        return false;
    }

    /**
     * TODO: write comment
     */
    public function updateSubscribePlan($subscribeDetail = array())
    {
        if (!empty($subscribeDetail) && isset($subscribeDetail['plan_id']) && isset($subscribeDetail['last_charged']) && isset($subscribeDetail['customer_id'])) {
            //$subscribeDetail['plan_id'] is the varachar here
            $subscribePlan = TableRegistry::get('GintonicCMS.SubscribePlans');
            $userCustomer = TableRegistry::get('GintonicCMS.UserCustomers');
            
            $planDetail = $subscribePlan->getPlanDetail($subscribeDetail['plan_id']);
            $customerDetail = $userCustomer->find()
                                ->where(['customer_id' => $subscribeDetail['customer_id']])
                                ->first();
            
            $subscribePlanUser = $this->find()
                                ->where([
                                    'SubscribePlanUsers.user_id' => $customerDetail->user_id,
                                    'SubscribePlanUsers.plan_id' => $planDetail->id
                                ])
                                ->first()
                                ->toArray();
            
            $subscribePlanUser['last_charged'] = $subscribeDetail['last_charged'];
            $subscribePlanUser['status'] = $subscribeDetail['status'];
            $subscribePlanUserData = $this->newEntity($subscribePlanUser);
            if ($this->save($subscribePlanUserData)) {
                return true;
            }
            return false;
        }
        return false;
    }
}
