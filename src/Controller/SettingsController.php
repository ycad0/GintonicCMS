<?php

namespace GintonicCMS\Controller;

use Cake\Auth\DefaultPasswordHasher;
use Cake\Core\Plugin;
use Cake\Database\Exception\MissingConnectionException;
use Cake\Datasource\ConnectionManager;
use Cake\Event\Event;
use GintonicCMS\Controller\AppController;
use Migrations\Command\Migrate;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

class SettingsController extends AppController
{

    /**
     * TODO: Write Document
     */
    public function beforeFilter(Event $event)
    {
        $this->Auth->allow();
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
        $command = new Migrate();
        $input = new ArrayInput(array('--plugin' => 'GintonicCMS'));
        $output = new NullOutput();
        $resultCode = $command->run($input, $output);
        $this->set(compact('resultCode'));
    }

    /**
     * TODO: Write Document
     */
    public function nodeInstall()
    {
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

            try {
                ConnectionManager::config('userDb', $default);
                $connection = ConnectionManager::get('userDb');
                $connected = $connection->connect();
            } catch (MissingConnectionException $connectionError) {
                $connected = false;
                $errorMsg = $connectionError->getMessage();
                if (method_exists($connectionError, 'getAttributes')) {
                    $attributes = $connectionError->getAttributes();
                    if (isset($errorMsg['message'])) {
                        $errorMsg .= '<br />' . $attributes['message'];
                    }
                }
            }
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
        if ($this->request->is(['post', 'put'])) {
            $this->loadModel('GintonicCMS.Users');
            $user = $this->Users->newEntity()->accessible('password', true);
            $success = false;
            $this->request->data['password'] = (new DefaultPasswordHasher)->hash($this->request->data['password']);
            $this->request->data['verified'] = 1;
            $this->request->data['role'] = 'admin';
            $userInfo = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($userInfo)) {
                $success = true;
            }
            $this->set(compact('success'));
        }
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
}
