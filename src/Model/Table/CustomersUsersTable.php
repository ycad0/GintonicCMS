<?php

namespace GintonicCMS\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;

class CustomersUsersTable extends Table
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
    }

    /**
     * TODO: write comment
     */
    public function findCustomerStripeId(Query $query, array $options)
    {
        return $query
                ->where(['CustomersUsers.user_id' => $options['userId']])
                ->first();
    }
}
