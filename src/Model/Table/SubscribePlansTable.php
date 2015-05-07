<?php

namespace GintonicCMS\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

class SubscribePlansTable extends Table
{
    /**
     * TODO: write comment
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'modified' => 'always'
                ]
            ]
        ]);

        $this->addAssociations([
            'hasMany' => [
                'SubscribePlanUsers' => [
                    'className' => 'SubscribePlanUsers',
                    'foreignKey' => 'plan_id',
                    'propertyName' => 'SubscribePlanUsers'
                ]
            ]
        ]);
    }

    /**
     * TODO: Write document.
     */
    public function getPlanDetailByPlanId($planId)
    {
        $plan = $this->find()
            ->where(['SubscribePlans.plan_id' => $planId])
            ->contain(['SubscribePlanUsers'])
            ->first();
        return $plan;
    }

    /**
     * TODO: write comment
     */
    public function getPlanDetail($planId = null)
    {
        if (!empty($planId)) {
            $planDetails = $this->find()
                ->where(['SubscribePlans.plan_id' => $planId])
                ->first();
            return $planDetails->toArray();
        }
        return false;
    }
}