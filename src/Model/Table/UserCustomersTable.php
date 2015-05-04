<?php

namespace GintonicCMS\Model\Table;

use Cake\ORM\Table;

class UserCustomersTable extends Table {

    public function initialize(array $config) {
        //parent::initialize($config);
    }
    
    public function getCustomerStripeId($userId = null) {
        if (!empty($userId)) {
            $userCustomer = $this->find()
                            ->where(['UserCustomers.user_id' => $userId]);
            debug($userCustomer->toArray());
            /*$userCustomer = $this->find('first', array('conditions' => array('UserCustomer.user_id' => $userId)));
            if (!empty($userCustomer)) {
                return $userCustomer['UserCustomer']['customer_id'];
            }*/
        }
        return false;
    }

}
