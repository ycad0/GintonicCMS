<?php

namespace GintonicCMS\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

class User extends Entity
{

    protected $_accessible = ['fullname'=>true,'*' => true];
    protected $_virtual = ['fullname'];

    protected function _setPassword($password)
    {
        return (new DefaultPasswordHasher)->hash($password);
    }
    
    protected function _getFullName()
    {
        return $this->_properties['first'] . '  ' . $this->_properties['last'];
    }
    
    protected function _getUserFiles()
    {
        $files = TableRegistry::get('Files');
        return $files->find('all')
                    ->where(['user_id' => $this->id])
                    ->all();
    }
    
    
}

?>
