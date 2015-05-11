<?php

namespace GintonicCMS\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;
use Cake\Network\Email\Email;
use Cake\Core\Configure;

class User extends Entity
{
    protected $_accessible = [
        'password' => false,
        '*' => true
    ];
    protected $_virtual = ['full_name'];
    protected $_hidden = ['password'];

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

    public function sendSignup($emailId = null)
    {
        $email = new Email();
        $email->profile('default');
        $email->viewVars([
            'userId' => $this->id,
            'token' => $this->token
        ]);
        $email->template('GintonicCMS.signup')
            ->emailFormat('html')
            ->to($emailId)
            ->from(Configure::read('admin_mail'))
            ->subject('Account validation');
        return $email->send();
    }

    public function sendVerification($email = null)
    {
        $emailId = !empty($email) ? $email : $this->email;
        $email = new Email('default');
        $email->viewVars([
            'userId' => $this->id,
            'token' => $this->token, 'userName' => $this->full_name
        ]);
        $email->template('GintonicCMS.resend_code')
            ->emailFormat('html')
            ->to($emailId)
            ->from([Configure::read('admin_mail') => Configure::read('site_name')])
            ->subject('Account validation');
        return $email->send();
    }

    public function sendRecovery($email = null)
    {
        $emailId = !empty($email) ? $email : $this->email;

        $email = new Email('default');
        $email->viewVars([
            'userId' => $this->id,
            'token' => $this->token
        ]);
        $email->template('GintonicCMS.forgot_password')
            ->emailFormat('html')
            ->to($emailId)
            ->from([Configure::read('admin_mail') => Configure::read('site_name')])
            ->subject('Forgot Password');
        return $email->send();
    }
}
