<?php

namespace GintonicCMS\Controller;

use Cake\Controller\Controller;
use Cake\Core\Configure;

class AppController extends Controller
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
        $this->loadComponent('Auth', [
            'authorize' => 'controller',
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'email',
                        'password' => 'password'
                    ]
                ]
            ],
            'flash' => [
                'key' => 'auth',
                'params' => [
                    'plugin' => 'GintonicCMS',
                    'class' => 'alert-danger'
                ]
            ],
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'signin',
                'plugin' =>'GintonicCMS'
            ],
            'loginRedirect' => [
                'controller' => 'Users',
                'action' => 'profile',
                'plugin' =>'GintonicCMS'
            ],
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'signin',
                'plugin' =>'GintonicCMS'
            ],
            'unauthorizedRedirect' => [
                'controller' => 'Users',
                'action' => 'signin',
                'plugin' =>'GintonicCMS'
            ]
        ]);
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
