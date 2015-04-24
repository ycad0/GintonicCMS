<?php

namespace GintonicCMS\Controller;

use App\Controller\AppController as BaseController;
use Cake\Core\Configure;

class AppController extends BaseController
{
    public $helpers = [
        'GintonicCMS.Require',
        'GintonicCMS.User',
        'GintonicCMS.File',
        'Form' => ['className' => 'GintonicCMS.Form'],
        'Paginator' => ['className' => 'GintonicCMS.Paginator'],
    ];
    
    function initialize() 
    {
        $this->loadComponent('Flash');
        $this->loadComponent('GintonicCMS.Cookie');
        $this->__set_layout();
        parent::initialize();
    }
    
    function isAuthorized($user = null)
    {
        if(!empty($user) && $user['role'] == 'admin'){
            return true;
        }
        return parent::isAuthorized($user);
    }
    
    function __set_layout()
    {
        if(!$this->request->session()->check('Site.layout')){
            $this->request->session()->write('Site.layout',Configure::read('Site.layout'));
        }
        $this->layout = $this->request->session()->read('Site.layout');
    }
    
}
