<?php

/**
 * GintonicCMS : Full Stack Content Management System (http://cms.gintonicweb.com)
 * Copyright (c) Philippe Lafrance, Inc. (http://phillafrance.com)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Philippe Lafrance (http://phillafrance.com)
 * @link          http://cms.gintonicweb.com GintonicCMS Project
 * @since         0.0.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace GintonicCMS\Controller;

use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;
use Cake\Core\Plugin;
use Cake\Database\Exception\MissingConnectionException;
use Cake\Datasource\ConnectionManager;
use Cake\Event\Event;
use GintonicCMS\Controller\AppController;
use PDOException;

/**
 * Represents the Settings Controller
 * Settings Controller is used to Configure settings of
 * GintonicCMS Plugin.
 */
class SettingsController extends AppController
{
    /**
     * Call before executoin of every request, also set some action
     * to access without login.
     * access login as below.
     * if database is not created then it will allow all action to users.
     * if database is created but users table is not created then it will allow all action to users.
     * if users table is created but there is no any admin account then it will allow all action to users.
     * if admin record is found in users table then it ask Authentication in order to access actions of this controller.
     *
     * @param Cake\Event\Event $event Describe the Events.
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        Configure::load('gintonic');
        if (!Configure::read('Gintonic.install.lock')) {
            $this->Auth->allow();
        }
        $this->loadComponent('GintonicCMS.Setup');
    }

    /**
     * TODO: doc bloc
     */
    public function lock()
    {
        Configure::load('gintonic');
        Configure::write('Gintonic.install.lock', true);
        Configure::dump('gintonic', 'default', ['Gintonic']);
        return $this->redirect([
            'controller' => 'Pages',
            'action' => 'home'
        ]);
    }
    /**
     * Used to install node modules.
     * it uses 'node install' command to install node dependencies
     */
    public function nodeInstall()
    {
        chdir('..' . DS . 'assets');
        exec('npm install', $output, $errCode);

        if (!$errCode) {
            Configure::load('gintonic');
            Configure::write('Gintonic.install.npm', true);
            Configure::dump('gintonic', 'default', ['Gintonic']);
        }
        $response = [
            'message' => $output,
            'errCode' => $errCode
        ];
        $this->set(compact('response'));
        $this->set('_serialize', ['response']);
    }

    /**
     * Used to install bower modules.
     * it uses 'bower install' command to install bower Modules.
     */
    public function bowerInstall()
    {
        chdir('..' . DS . 'assets');
        exec('node_modules' . DS . 'bower' . DS . 'bin' . DS . 'bower install', $output, $errCode);
        if (!$errCode) {
            Configure::load('gintonic');
            Configure::write('Gintonic.install.bower', true);
            Configure::dump('gintonic', 'default', ['Gintonic']);
        }
        $response = [
            'message' => $output,
            'errCode' => $errCode
        ];
        $this->set(compact('response'));
        $this->set('_serialize', ['response']);
    }

    /**
     * Used to Compile dependency code
     * It won't minify and optimize code.
     */
    public function gruntDev()
    {
        $path = Plugin::path('GintonicCMS');

        chdir('..' . DS . 'assets');
        exec('node_modules' . DS . 'grunt-cli' . DS . 'bin' . DS . 'grunt dev --gintonic=' . $path, $output, $errCode);
        if (!$errCode) {
            Configure::load('gintonic');
            Configure::write('Gintonic.install.grunt', true);
            Configure::dump('gintonic', 'default', ['Gintonic']);
        }
        $response = [
            'message' => $output,
            'errCode' => $errCode
        ];
        $this->set(compact('response'));
        $this->set('_serialize', ['response']);
    }

    /**
     * Used to Compile dependency code
     * Will optimize code and minify it so it takes much longer to run.
     */
    public function grunt()
    {
        $path = Plugin::path('GintonicCMS');

        chdir('..' . DS . 'assets');
        exec('node_modules' . DS . 'grunt-cli' . DS . 'bin' . DS . 'grunt --gintonic=' . $path, $output, $errCode);
        if (!$errCode) {
            Configure::load('gintonic');
            Configure::write('Gintonic.install.grunt', true);
            Configure::dump('gintonic', 'default', ['Gintonic']);
        }
        $response = [
            'message' => $output,
            'errCode' => $errCode
        ];
        $this->set(compact('response'));
        $this->set('_serialize', ['response']);
    }

    /**
     * TODO: doc comments
     */
    public function databaseSetup()
    {
        Configure::load('datasources');
        $default = Configure::read('Datasources.default');
        if ($this->request->is(['post', 'put'])) {
            $default = array_merge($default, $this->request->data);
            ConnectionManager::config('userDb', $default);
            if ($this->Setup->databaseConnection('userDb')) {
                Configure::write('Datasources.default', $default);
                Configure::dump('datasources', 'default', ['Datasources']);
                return $this->redirect([
                    'controller' => 'Pages',
                    'action' => 'home'
                ]);
            } else {
                $this->Flash->set(__('Impossible to connect to the database'), [
                    'element' => 'GintonicCMS.alert',
                    'params' => ['class' => 'alert-danger']
                ]);
            }
        }
        $this->request->data = $default;
    }

    /**
     * Create Admin account.
     * if there is already one admin account in user table then it won't allow to create another account.
     */
    public function createAdmin()
    {
        // Lets make sure that we can connect to the database first
        if (!$this->Setup->databaseConnection()) {
            $this->Flash->set(__('Impossible to connect to the database'), [
                'element' => 'GintonicCMS.alert',
                'params' => ['class' => 'alert-danger']
            ]);
            return $this->redirect(['controller' => 'Pages', 'action' => 'home']);
        }

        if ($this->request->is(['post', 'put'])) {
            $this->Setup->runMigration('Acl');
            $this->Setup->runMigration('GintonicCMS');

            // Check if the users table exists
            if (!$this->Setup->tableExists('users')) {
                $this->Flash->set(__('Unexpected error with Users table'), [
                    'element' => 'GintonicCMS.alert',
                    'params' => ['class' => 'alert-danger']
                ]);
                $this->autoRender = false;
                return $this->redirect(['controller' => 'Pages', 'action' => 'home']);
            }

            Configure::load('gintonic');
            Configure::write('Gintonic.install.migration', true);
            Configure::dump('gintonic', 'default', ['Gintonic']);

            $this->loadModel('GintonicCMS.Users');
            $user = $this->Users->newEntity()->accessible('password', true);
            $user->password = $this->request->data['password'];
            $this->request->data['verified'] = 1;
            $this->request->data['role'] = 'admin';
            $userInfo = $this->Users->patchEntity($user, $this->request->data);

            if ($this->Users->save($userInfo)) {
                Configure::write('Gintonic.install.admin', true);
                Configure::dump('gintonic', 'default', ['Gintonic']);
                $this->Flash->set(__('GintonicCMS successfully installed'), [
                    'element' => 'GintonicCMS.alert',
                    'params' => ['class' => 'alert-success']
                ]);

                // Init permissions
                $aro = $this->Acl->Aro->newEntity();
                $aro->alias = 'admin';
                $this->Acl->Aro->save($aro);

                $aro = $this->Acl->Aro->newEntity();
                $aro->model = 'Users';
                $aro->parent_id = '1'; // id of 'admin' role
                $aro->foreign_key = '1'; // id of the user
                $this->Acl->Aro->save($aro);

                $aco = $this->Acl->Aco->newEntity();
                $aco->alias = 'all';
                $this->Acl->Aco->save($aco);

                $this->Acl->allow(['Users' => ['id' => 1]], 'all');
                
                return $this->redirect(['controller' => 'Pages', 'action' => 'home']);
            } else {
                $this->Flash->set(__('Unable to add Users'), [
                    'element' => 'GintonicCMS.alert',
                    'params' => ['class' => 'alert-danger']
                ]);
                return $this->redirect(['controller' => 'Pages', 'action' => 'home']);
            }
        }
    }

    /**
     * Write Configure variable in gintonic.php.
     * gintonic.php will be included from bootstrap.php of project.
     * It write admin email and Cookie information.
     */
    public function configure()
    {
        Configure::load('gintonic');
        Configure::load('email');

        if ($this->request->is(['post', 'put'])) {
            Configure::write('Email.default.from', $this->request->data['email']);
            Configure::dump('email', 'default', ['Email', 'EmailTransport']);

            $newKey = hash('sha256', php_uname() . microtime(true));
            Configure::write('Gintonic.cookie.key', $newKey);
            Configure::write('Gintonic.install.config', true);
            Configure::write('Gintonic.website.name', $this->request->data['name']);
            Configure::dump('gintonic', 'default', ['Gintonic']);

            return $this->redirect(['controller' => 'Pages', 'action' => 'home']);
        }
    }

    /**
     * Display view to build assets.
     */
    public function assets()
    {
        // assets view
    }
}
