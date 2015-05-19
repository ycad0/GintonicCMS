<?php

namespace GintonicCMS\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;

class PlansTable extends Table
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
                'PlansUsers'
            ]
        ]);
    }

    /**
     * TODO: Write document.
     */
    public function findPlanDetails(Query $query, array $options)
    {
        return $query
                ->where(['Plans.plan_id' => $options['planId']])
                ->contain(['PlansUsers'])
                ->first();
    }
}
