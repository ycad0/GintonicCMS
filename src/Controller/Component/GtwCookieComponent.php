<?php
/**
 * Gintonic Web
 * @author    Philippe Lafrance
 * @link      http://gintonicweb.com
 */

namespace GintonicCMS\Controller\Component;

use Cake\Controller\Component;


class GtwCookieComponent extends Component {
    
    var $components = array('Cookie','Auth');
    
    public function initialize(array $config) {
        parent::initialize($config);
        $this->Cookie->key = \Cake\Core\Configure::read('GtwCookie.key');
        $this->Cookie->name = \Cake\Core\Configure::read('GtwCookie.name');
        $this->Cookie->httpOnly = true;
//        $this->Controller = $controller;
    }
    
    public function autoAuth(){
        if(!$this->Cookie->read('remember_me') || $this->Auth->loggedIn()){
            return;
        }
        $user = $this->Cookie->read('remember_me');
        if(!$this->Auth->login($user['User'])){
            $this->Controller->redirect(array('plugin' => 'GintonicCMS', 'controller' => 'users', 'action' => 'signout' ));
        }
        return $this->Controller->redirect($this->Auth->redirectUrl());
    }
    
    public function rememberMe($userInfo){
        $this->Cookie->write('remember_me', $userInfo, true, Configure::read('GtwCookie.loginDuration'));
    }
    public function forgetMe(){
        $this->Cookie->delete('remember_me');
    }
    
}