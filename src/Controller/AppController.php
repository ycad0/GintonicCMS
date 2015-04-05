<?php

namespace GintonicCMS\Controller;

use App\Controller\AppController as BaseController;
use Cake\Core\Configure;

class AppController extends BaseController
{
    public $helpers = [
        'GintonicCMS.Require',
        'GintonicCMS.Custom',
        'Form' => ['className' => 'BoostCake.Form'],
        'Paginator' => ['className' => 'BoostCake.Paginator'],
    ];
    
    function initialize() 
    {
        $this->loadComponent('Flash');
        $this->loadComponent('GintonicCMS.Cookie');
        $this->loadComponent('GintonicCMS.FlashMessage');
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
