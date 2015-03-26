<?php

namespace GintonicCMS\Controller;

use App\Controller\AppController as BaseController;

class AppController extends BaseController
{
    public $helpers = ['GintonicCMS.GtwRequire','GintonicCMS.Custom'];
    
    public $paginate = ['maxLimit' => 5];
    
    function initialize() 
    {
        parent::initialize();

        $this->loadComponent('Flash');
        $this->loadComponent('Cookie');
        $this->loadComponent('GintonicCMS.FlashMessage');
        $this->loadComponent('Auth');
        
        $this->Auth->allow(['display']);
    }
    
    function isAuthorized($user)
    {
        if(!empty($user) && $user['role'] == 'admin'){
            $this->layout = 'admin';
            return true;
        }
        return false;
    }
    
    function __checklogin()
    {
        $user = $this->Auth->user();
        $this->layout = 'default';
        if(!empty($user) && $user['role'] == 'admin'){
            if(!empty($user['file_id'])){
                $this->loadModel('GintonicCMS.Files');
                $adminAvatar ='/' . $this->Files->getUrl('',$user['file_id']);
                $this->set(compact('adminAvatar'));
            }
            $this->layout = 'GintonicCMS.admin';
        }
    }
    
}
