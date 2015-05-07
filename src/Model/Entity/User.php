<?php

namespace GintonicCMS\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

class User extends Entity
{
    protected $_accessible = ['*' => true];
    protected $_virtual = ['full_name'];

    /**
     * TODO: doccomment
     */
    protected function _setPassword($password)
    {
        return (new DefaultPasswordHasher)->hash($password);
    }

    /**
     * TODO: doccomment
     */
    protected function _getFullName()
    {
        if (isset($this->_properties['first']) && isset($this->_properties['last'])) {
            return $this->_properties['first'] . '  ' . $this->_properties['last'];
        }
        return false;
    }

    /**
     * TODO: doccomment
     */
    protected function _getUserFiles()
    {
        $files = TableRegistry::get('Files');
        return $files->find('all')
                ->where(['user_id' => $this->id])
                ->all();
    }
}
