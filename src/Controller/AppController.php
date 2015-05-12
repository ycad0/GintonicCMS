<?php

namespace GintonicCMS\Controller;

use App\Controller\AppController as BaseController;
use Cake\Core\Configure;

class AppController extends BaseController
{
    public $helpers = [
        'GintonicCMS.Require',
        'GintonicCMS.User',
        'GintonicCMS.Media',
        'Form' => ['className' => 'GintonicCMS.Form'],
        'Paginator' => ['className' => 'GintonicCMS.Paginator'],
    ];

    /**
     * TODO: blockcomment
     */
    public function initialize()
    {
        $this->loadComponent('Flash');
        $this->loadComponent('GintonicCMS.Cookie');
        $this->loadComponent('RequestHandler');
        parent::initialize();
    }
    
    /**
     * TODO: blockcomment
     */
    public function isAuthorized($user = null)
    {
        if (!empty($user) && $user['role'] == 'admin') {
            return true;
        }
        return parent::isAuthorized($user);
    }
}
