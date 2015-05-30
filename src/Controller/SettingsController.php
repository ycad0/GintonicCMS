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
        if (!$this->__databaseConnection()) {
            $this->Auth->allow();
            return;
        }

        if (!$this->__tableExists()) {
            $this->Auth->allow();
            return;
        }

        if (!$this->__adminRecordExists()) {
            $this->Auth->allow();
            return;
        }
    }

    /**
     * Used to Authorized User to access requested action.
     *
     * @param array $user contain user detail.
     * @return boolean Return true if action is allowed else return false.
     */
    public function isAuthorized($user = null)
    {
        return parent::isAuthorized($user);
    }

    /**
     * Path to the plugin config file
     *
     * @param string $vendorDir path to composer-vendor dir
     * @return string absolute file path
     */
    protected static function _configFile($vendorDir)
    {
        return $vendorDir . DIRECTORY_SEPARATOR . 'cakephp-plugins.php';
    }

    /**
     * Used to migrate the database of CMS.
     * it use bin/cake migrations migrate --plugin GintonicCMS command to migrate database.
     */
    public function migrate()
    {
        $missingConnection = true;
        if ($this->__databaseConnection()) {
            $missingConnection = false;
            $command = new Migrate();
            $input = new ArrayInput(array('--plugin' => 'GintonicCMS'));
            $output = new NullOutput();
            $resultCode = $command->run($input, $output);
            $this->set(compact('resultCode'));
        }
        $this->set(compact('missingConnection'));
    }

    /**
     * Used to install node modules.
     * it uses 'node install' command to install node dependencies
     */
    public function nodeInstall()
    {
        ini_set('max_execution_time', 0);
        $this->autoRender = false;
        exec('cd ..' . DS . 'assets && npm install');
        $status = [
            'status' => 'ok',
            'message' => 'Node Install Successfully'
        ];
        echo json_encode($status);
    }

    /**
     * Used to install bower modules.
     * it uses 'bower install' command to install bower Modules.
     */
    public function bowerInstall()
    {
        ini_set('max_execution_time', 0);
        $this->autoRender = false;
        //exec('cd ..' . DS . 'assets'.DS.'node_modules' . DS . 'bower' . DS . 'bin && bower install');
        exec('cd ..' . DS . 'assets && bower install');
        $status = [
            'status' => 'ok',
            'message' => 'Bower Install Successfully'
        ];
        echo json_encode($status);
    }

    /**
     * Used to Compile dependency code
     * It won't minify and optimize code.
     */
    public function gruntDev()
    {
        ini_set('max_execution_time', 0);
        $this->autoRender = false;
        $path = Plugin::path('GintonicCMS');
        exec('cd ..' . DS . 'assets && grunt dev --gintonic=' . $path);
        $status = [
            'status' => 'ok',
            'message' => 'Grunt dev run Successfully'
        ];
        echo json_encode($status);
    }

    /**
     * Used to Compile dependency code
     * Will optimize code and minify it so it takes much longer to run.
     */
    public function grunt()
    {
        ini_set('max_execution_time', 0);
        $this->autoRender = false;
        $path = Plugin::path('GintonicCMS');
        exec('cd ..' . DS . 'assets && grunt --gintonic=' . $path);
        $status = [
            'status' => 'ok',
            'message' => 'Grunt run Successfully'
        ];
        echo json_encode($status);
    }

    /**
     * Used to configure database options.
     * @param string $mode use to identify operation like edit.
     */
    public function databaseSetup($mode = '')
    {
        if ($this->request->is(['post', 'put'])) {
            $default = [
                'className' => 'Cake\Database\Connection',
                'driver' => 'Cake\Database\Driver\Mysql',
                'persistent' => false,
                'port' => 'nonstandard_port_number',
                'host' => $this->request->data['host'],
                'username' => $this->request->data['username'],
                'password' => $this->request->data['password'],
                'database' => $this->request->data['database'],
                'encoding' => 'utf8',
                'timezone' => 'UTC',
                'cacheMetadata' => true,
                'quoteIdentifiers' => false,
                'init' => ['SET GLOBAL innodb_stats_on_metadata = 0'],
            ];

            ConnectionManager::config('userDb', $default);
            $connected = $this->__databaseConnection('userDb');

            if ($connected) {
                file_put_contents('../config/gintonic.database.json', json_encode($default, JSON_PRETTY_PRINT));
            }
            $this->set(compact('connected'));
        }

        if (!empty($mode)) {
            $default = json_decode(file_get_contents('../config/gintonic.database.json'), true);
            $this->request->data = $default;
        }
    }

    /**
     * Create Admin account.
     * if there is already one admin account in user table then it won't allow to create another account.
     */
    public function createAdmin()
    {
        if (!$this->__tableExists('users')) {
            $tableExists = false;
        } else {
            $tableExists = true;
            if ($this->__adminRecordExists()) {
                $recordExists = true;
            } else {
                $recordExists = false;
                if ($this->request->is(['post', 'put'])) {
                    $this->loadModel('GintonicCMS.Users');
                    $user = $this->Users->newEntity()->accessible('password', true);
                    $success = false;
                    $user->password = $this->request->data['password'];
                    $this->request->data['verified'] = 1;
                    $this->request->data['role'] = 'admin';
                    $userInfo = $this->Users->patchEntity($user, $this->request->data);
                    if ($this->Users->save($userInfo)) {
                        $success = true;
                    }
                    $this->set(compact('success'));
                }
            }
        }
        $this->set(compact('tableExists', 'recordExists'));
    }

    /**
     * Write Configure variable in gintonic.php.
     * gintonic.php will be included from bootstrap.php of project.
     * It write admin email and Cookie information.
     */
    public function setupVariable()
    {
        if ($this->request->is(['post', 'put'])) {
            $status = false;
            $cookieKey = substr(str_shuffle("0123456789#@$%^&!abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 37);
            $default = "<?php\n" .
                "return [\n" .
                "    'admin_mail' =>'" . $this->request->data['email'] . "',\n" .
                "    'Cookie' =>[\n" .
                "        'key'=>'" . $cookieKey . "',\n" .
                "        'name'=>'gintonic',\n" .
                "        'loginDuration'=>'+2 weeks'\n" .
                "    ]\n" .
                "];\n";
            if (file_put_contents('../config/gintonic.php', $default)) {
                $status = true;
            }
            $this->set(compact('status'));
        }
    }

    /**
     * Display view to build assets.
     */
    public function assets()
    {
        //assets view
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
