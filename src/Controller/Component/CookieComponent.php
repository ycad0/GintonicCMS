<?php

namespace GintonicCMS\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\Component\CookieComponent as CakeCookieComponent;
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;

class CookieComponent extends CakeCookieComponent
{
    public $components = ['Auth'];

    /**
     * TODO: blockcomment
     */
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->key = Configure::read('Cookie.key');
        $this->name = Configure::read('Cookie.name');
        $this->httpOnly = true;
    }
    
    /**
     * TODO: blockcomment
     */
    public function autoAuth()
    {
        if (!$this->read('remember_me') || $this->Auth->loggedIn()) {
            return;
        }
        $user = $this->read('remember_me');
        $auth = $this->Auth->user($user);
        if (!empty($auth)) {
            $this->Controller->redirect([
                'controller' => 'users',
                'action' => 'signout'
            ]);
        }
        return $this->Controller->redirect($this->Auth->redirectUrl());
    }
    
    /**
     * TODO: blockcomment
     */
    public function rememberMe($userInfo)
    {
        $this->write(
            'remember_me',
            $userInfo,
            true,
            Configure::read('Cookie.loginDuration')
        );
    }
    
    /**
     * TODO: blockcomment
     */
    public function forgetMe()
    {
        $this->delete('remember_me');
    }
}
