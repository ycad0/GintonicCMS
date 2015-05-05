<?php

namespace GintonicCMS\Model\Table;

use Cake\ORM\Table;

class UserCustomersTable extends Table
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
    public function getCustomerStripeId($userId = null)
    {
        if (!empty($userId)) {
            $userCustomer = $this->find()
                    ->where(['UserCustomers.user_id' => $userId])
                    ->first();
            if (!empty($userCustomer->customer_id)) {
                return $userCustomer->customer_id;
            }
        }
        return false;
    }
}
