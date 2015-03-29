<?php

namespace GintonicCMS\Controller;

use App\Controller\AppController as BaseController;

class AppController extends BaseController
{
    public $helpers = [
        'GintonicCMS.GtwRequire',
        'GintonicCMS.Custom',
        'Form' => ['className' => 'BoostCake.Form'],
        'Paginator' => ['className' => 'BoostCake.Paginator'],
    ];
    
    function initialize() 
    {
        $this->loadComponent('Flash');
        $this->loadComponent('GintonicCMS.Cookie');
        $this->loadComponent('GintonicCMS.FlashMessage');
        $this->loadComponent('Auth');
        parent::initialize();
    }
    
    function isAuthorized($user = null)
    {
        if(!empty($user) && $user['role'] == 'admin'){
            return true;
        }
        return parent::isAuthorized($user);
    }

}
