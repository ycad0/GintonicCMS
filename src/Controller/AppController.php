<?php

namespace GintonicCMS\Controller;

use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\Event;

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
            'authorize' => 'Controller',
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
                'plugin' => 'GintonicCMS',
                'prefix' => false
            ],
            'loginRedirect' => [
                'controller' => 'Users',
                'action' => 'view',
                'plugin' => 'GintonicCMS',
                'prefix' => false

            ],
            'logoutRedirect' => [
                'controller' => 'Pages',
                'action' => 'home',
                'plugin' => 'GintonicCMS',
                'prefix' => false

            ],
            'unauthorizedRedirect' => [
                'controller' => 'Users',
                'action' => 'signin',
                'plugin' => 'GintonicCMS',
                'prefix' => false

            ]
        ]);
        parent::initialize();
    }

    /**
     * TODO: blockcomment
     */
    public function beforeFilter(Event $event)
    {
        if ($this->request->params['controller'] == 'Pages') {
            $this->Auth->allow();
        }
    }
    /**
     * TODO: blockcomment
     */
    public function isAuthorized($user = null)
    {
        if (!empty($user) && $user['role'] == 'admin') {
            return true;
        }
        //return parent::isAuthorized($user);
        return false;
    }
}
