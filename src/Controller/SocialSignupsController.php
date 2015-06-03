<?php

namespace GintonicCMS\Controller;

use GintonicCMS\Controller\AppController;
use Cake\Event\Event;
use Cake\Routing\Router;

class SocialSignupsController extends AppController
{
	
	public function initialize()
	{
		parent::initialize();
		$this->loadComponent('GintonicCMS.OauthConnect');
	}
	
	
	/**
	 * Allow all signups
	 */
	public function beforeFilter(Event $event)
	{
		parent::beforeFilter($event);
		$this->Auth->allow([
				'facebook',
				'google'
		]);
	}
	public function isAuthorized($user = null)
	{
		return true;
		parent::isAuthorized($user);
	}
	
	
	
	public function facebook() 
	{
        $this->OauthConnect->provider = "Facebook";
        $this->OauthConnect->redirect_uri = Router::url(array('action' => 'facebook'), true);
        $this->OauthConnect->setSocial();
        
        if ($this->request->query($this->OauthConnect->responseType) == '') {
            return $this->redirect($this->OauthConnect->authUrl());
        } else {
            $this->OauthConnect->code = $this->request->query($this->OauthConnect->responseType);
            $getData = $this->OauthConnect->getUserProfile();
            if (isset($getData->id)) {
                $arrUser = array();
                $arrUser['first'] = $getData->first_name;
                $arrUser['last'] = $getData->last_name;
                $arrUser['email'] = $getData->email;

                if($this->__socialSignup($arrUser))
                	return;
            }
            
            $this->Flash->set(__('Facebook connect failed. Please try again!'), [
            		'element' => 'GintonicCMS.alert',
            		'params' => ['class' => 'alert-warning']
            ]);
            $this->redirect(array("controller"=>"users", "action"=>"signin"));
        }
        die;
    }

    function google() {
        $this->OauthConnect->provider = "Google";
        $this->OauthConnect->redirect_uri = Router::url(array('action' => 'google'), true);
        $this->OauthConnect->setSocial();
        
        if ($this->request->query($this->OauthConnect->responseType) == '') {
            return $this->redirect($this->OauthConnect->authUrl());
        } else {
            $this->OauthConnect->code = $this->request->query($this->OauthConnect->responseType);
            $getData = $this->OauthConnect->getUserProfile();
            if (isset($getData->id)) {
                $arrUser = array();
                $arrUser['first'] = $getData->given_name;
                $arrUser['last'] = $getData->family_name;
                $arrUser['email'] = $getData->email;
                if($this->__socialSignup($arrUser))
                	return;
            }
            
            $this->Flash->set(__('Google connect failed. Please try again!'), [
            		'element' => 'GintonicCMS.alert',
            		'params' => ['class' => 'alert-warning']
            ]);
            
            return $this->redirect(array("controller"=>"users", "action"=>"signin"));
        }
        die;
    }

    private function __socialSignup($arrUser = array()) {
        if (!empty($arrUser['email'])) {
        	$this->loadModel("GintinicCMS.Users");
        	$user = $this->Users->find()
        			->where(['Users.email' => $arrUser['email']])
        			->first();
        	
        	if(!empty($user)) {
               	$this->Auth->setUser($user->toArray());
	            return $this->redirect($this->Auth->redirectUrl());
            }
            else{
                $user = $this->Users->newEntity();
                $user->verified = 1;
                $user = $this->Users->patchEntity($user, $arrUser);
	            if ($this->Users->save($user)) {
	               	$this->Auth->setUser($user->toArray());
	               	return $this->redirect($this->Auth->redirectUrl());
	            }
            }           
        }
        return false;
    }
}

