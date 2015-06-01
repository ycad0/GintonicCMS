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
use Migrations\Command\Migrate;
use PDOException;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

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
    }

    /**
     * Used to install node modules.
     * it uses 'node install' command to install node dependencies
     */
    public function nodeInstall()
    {
        $this->autoRender = false;
        chdir('..' . DS . 'assets');
        exec('npm install', $output, $errCode);

        if(!$errCode){
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
        $this->autoRender = false;
        chdir('..' . DS . 'assets');
        exec('node_modules' . DS . 'bower' . DS . 'bin' . DS . 'bower install', $output, $errCode);
        if(!$errCode){
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
        if(!$errCode){
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
        $this->autoRender = false;
        $path = Plugin::path('GintonicCMS');

        chdir('..' . DS . 'assets');
        exec('node_modules' . DS . 'grunt-cli' . DS . 'bin' . DS . 'grunt --gintonic=' . $path, $output, $errCode);
        if(!$errCode){
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
            if ($this->__databaseConnection('userDb')) {
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
        if(!$this->__databaseConnection()){
            $this->Flash->set(__('Impossible to connect to the database'), [
                'element' => 'GintonicCMS.alert',
                'params' => ['class' => 'alert-danger']
            ]);
            return $this->redirect(['controller' => 'Pages', 'action' => 'home']);
        }

        // Run GintonicCMS migrations
        $command = new Migrate();
        $input = new ArrayInput(array('--plugin' => 'GintonicCMS'));
        $output = new NullOutput();
        $resultCode = $command->run($input, $output);

        // TODO: get the interpretation of the error codes
        //if($resultCode == 'Error??'){
        //    $this->Flash->set(__('Error while running the migrations'), [
        //        'element' => 'GintonicCMS.alert',
        //        'params' => ['class' => 'alert-danger']
        //    ]);
        //    return $this->redirect(['controller' => 'Pages', 'action' => 'home']);
        //}

        // Check if the users table exists
        if(!$this->__tableExists('users')){
            $this->Flash->set(__('Unexpected error with Users table'), [
                'element' => 'GintonicCMS.alert',
                'params' => ['class' => 'alert-danger']
            ]);
            return $this->redirect(['controller' => 'Pages', 'action' => 'home']);
        }

        Configure::load('gintonic');
        Configure::write('Gintonic.install.migration', true);
        Configure::dump('gintonic', 'default', ['Gintonic']);

        if ($this->request->is(['post', 'put'])) {
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
            Configure::dump('email', 'default', ['Email','EmailTransport']);

            $newKey = hash('sha256', php_uname() . microtime(true));
            Configure::write('Gintonic.cookie.key', $newKey);
            Configure::write('Gintonic.install.config', true);
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

    /**
     * Test database connection.
     *
     * @param type $dataSource name of data source.
     * @return boolean True if database is connected, False else.
     */
    private function __databaseConnection($dataSource = 'default')
    {
        try {
            $connection = ConnectionManager::get($dataSource);
            $connected = $connection->connect();
        } catch (MissingConnectionException $connectionError) {
            $connected = false;
        }
        return $connected;
    }

    /**
     * Check whether table is exists in database or not.
     *
     * @param string $tableName Name of the table to check.
     * @return boolean True if table exists, False else.
     */
    private function __tableExists($tableName = 'users')
    {
        try {
            $db = ConnectionManager::get('default');
            $collection = $db->schemaCollection();
            $tables = $collection->listTables();
            if (in_array($tableName, $tables)) {
                return true;
            }
        } catch (PDOException $connectionError) {
            return false;
        }
        return false;
    }

    /**
     * Check for admin account.
     *
     * @return boolean True if admin account exists, False else.
     */
    private function __adminRecordExists()
    {
        $conditions = ['Users.role' => 'admin'];
        $this->loadModel('GintonicCMS.Users');
        if ($this->Users->exists($conditions)) {
            return true;
        }
        return false;
    }
}
