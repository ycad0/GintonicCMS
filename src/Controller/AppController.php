<?php
/**
 * GintonicCMS : Full Stack Content Management System (http://gintoniccms.com)
 * Copyright (c) Philippe Lafrance (http://phillafrance.com)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Philippe Lafrance (http://phillafrance.com)
 * @link          http://gintoniccms.com GintonicCMS Project
 * @since         0.0.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace GintonicCMS\Controller;

use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\Event;

/**
 * Application Controller
 *
 * Use this controller as the base class for your apps by inheriting it in your
 * application
 */
class AppController extends Controller
{
    use \Crud\Controller\ControllerTrait;

    public $layout = 'GintonicCMS.default';
    /**
     * Base helpers that loads javascript via require and wraps forms with
     * bootstrap markup.
     */
    public $helpers = [
        'GintonicCMS.Require',
        'Form' => ['className' => 'GintonicCMS.Form'],
        'Paginator' => ['className' => 'GintonicCMS.Paginator'],
    ];

    /**
     * We use this controller as the base controller for our whole app. Here we
     * handle everything related to authentication. It's then easy to extend it
     * from the application.
     */
    public function initialize()
    {
        $this->loadComponent('Acl.Acl');
        $this->loadComponent('Flash');
        $this->loadComponent('Cookie');
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Crud.Crud', [
            'actions' => [
                'Crud.Index',
                'Crud.Add',
                'Crud.Edit',
                'Crud.View',
                'Crud.Delete'
            ],
            'listeners' => [
                'Crud.RelatedModels'
            ]
        ]);
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
        $this->__autoLogin();
    }

    /**
     * Called before each action, allows everyone to use the "pages" controller
     * without specific permissions.
     *
     * @param Event $event An Event instance
     * @return void
     * @link http://book.cakephp.org/3.0/en/controllers.html#request-life-cycle-callbacks
     */
    public function beforeFilter(Event $event)
    {
        if ($this->request->params['controller'] == 'Pages') {
            $this->Auth->allow();
        }
    }

    /**
     * Authorization method. We can grant all permissions to everything
     * on the website by adding a user to the group named 'all'.
     *
     * @param array|null $user The user to check the authorization of.
     * @return bool True if $user is authorized, otherwise false
     * @link https://github.com/cakephp/acl
     */
    public function isAuthorized($user = null)
    {
        if (!empty($user)) {
            return $this->Acl->check(['Users' => $user], 'all');
        }
        return false;
    }

    /**
     * If the use is already identified via the cookie, we log him in
     * automatically.
     *
     * @return void
     */
    private function __autoLogin()
    {
        if (!$this->Cookie->read('User')) {
            return;
        }
        $user = $this->Cookie->read('User');
        $this->Auth->setUser($user);
    }
}
