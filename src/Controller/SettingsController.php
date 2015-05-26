<?php

namespace GintonicCMS\Controller;

use Cake\Core\Plugin;
use Cake\Event\Event;
use GintonicCMS\Controller\AppController;
use Migrations\Command\Migrate;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

class SettingsController extends AppController
{
    public function beforeFilter(Event $event){
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
        $this->autoRender = false;
        $command = new Migrate();
        $input = new ArrayInput(array('--plugin' => 'GintonicCMS'));
        $output = new NullOutput();
        $resultCode = $command->run($input, $output);
        if ($resultCode == 0) {
            echo __('Migration successful');
        } else {
            echo __('Error while performing Migration');
        }
    }

    public function node_install()
    {
        debug(shell_exec('cd ..' . DS . 'assets && npm install 2>&1'));
        exit;
    }

    public function bower_install()
    {
        debug(shell_exec('cd ..' . DS . 'assets && node_modules' . DS . 'bower' . DS . 'bin' . DS . 'bower install 2>&1'));
        exit;
    }

    public function grunt_dev()
    {
        $path = Plugin::path('GintonicCMS');
        debug(shell_exec('cd ..' . DS . 'assets && node_modules' . DS . 'grunt-cli' . DS . 'bin' . DS . 'grunt dev --gintonic=' . $path. ' 2>&1'));
        exit;
    }

    public function grunt()
    {
        $path = Plugin::path('GintonicCMS');
        debug(shell_exec('cd ..' . DS . 'assets && node_modules' . DS . 'grunt-cli' . DS . 'bin' . DS . 'grunt --gintonic=' . $path. ' 2>&1'));
        exit;
    }
}
