<?php

namespace GintonicCMS\Controller\Component;

use Cake\Controller\Component;

class TransacComponent extends Component
{
    public $components = array('Session');
    public $uses = array('User');

    public function initialize(array $config) {
        parent::initialize($config);
    }
    
    function setLastTransaction($transaction = [])
    {
        $key = md5($transaction['Transaction']['id']);
        $this->request->session()->write($key, $transaction);
        return $key;
    }

    function getLastTransaction($key)
    {
        $transaction = $this->request->session()->read($key);
        $this->request->session()->delete($key);
        if (!empty($transaction['Transaction']['user_id'])) {
            ClassRegistry::init('User')->recursive = -1;
            $transaction['User'] = ClassRegistry::init('User')->findById($transaction['Transaction']['user_id']);
            $transaction['User'] = $transaction['User']['User'];
        }
        return $transaction;
    }

}
