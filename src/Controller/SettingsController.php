<?php

namespace GintonicCMS\Controller;

use Cake\Auth\DefaultPasswordHasher;
use Cake\Core\Plugin;
use Cake\Database\Exception\MissingConnectionException;
use Cake\Datasource\ConnectionManager;
use Cake\Event\Event;
use GintonicCMS\Controller\AppController;
use Migrations\Command\Migrate;
use PDOException;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

class SettingsController extends AppController
{
    /**
     * TODO: Write Document
     */
    public function beforeFilter(Event $event)
    {
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
        return $this->isAuthorized();
    }

    /**
     * TODO: Write Document
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
     * TODO: Write Document
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
     * TODO: Write Document
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
     * TODO: Write Document
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
     * TODO: Write Document
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
     * TODO: Write Document
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
     * TODO: Write Document
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
     * TODO: Write Document
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
     * TODO: Write Document
     */
    public function setupVariable()
    {
        $status = false;
        $cookieKey = substr(str_shuffle("0123456789#@$%^&!abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 37);
        $default = "<?php\n" .
            "return [\n" .
            "    'admin_mail' =>'admin@gintonicweb.com',\n" .
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

    /**
     * TODO: Write Document
     */
    public function assets()
    {
        //assets view
    }

    /**
     * TODO: Write Document.
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
     * TODO: Write Document.
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
     * TODO: Write Document.
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
