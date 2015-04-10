<?php

namespace GintonicCMS\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;
use Cake\Controller\Component\CookieComponent as CakeCookieComponent;

class CookieComponent extends CakeCookieComponent 
{
    
    public $components = ['Auth'];

    public function initialize(array $config) 
    {
        parent::initialize($config);
        $this->key = Configure::read('Cookie.key');
        $this->name = Configure::read('Cookie.name');
        $this->httpOnly = true;
    }
    
    public function autoAuth()
    {
        if(!$this->read('remember_me') || $this->Auth->loggedIn()){
            return;
        }
        $user = $this->read('remember_me');
        $auth = $this->Auth->user($user);
        if (!empty($auth)) {
            $this->Controller->redirect(['controller' => 'users', 'action' => 'signout']);
        }
        return $this->Controller->redirect($this->Auth->redirectUrl());
    }
    
    public function rememberMe($userInfo)
    {
        $this->write(
            'remember_me',
            $userInfo,
            true,
            Configure::read('Cookie.loginDuration')
        );
    }
    
    public function forgetMe()
    {
        $this->delete('remember_me');
    }
    
}
