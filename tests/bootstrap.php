<?php
// @codingStandardsIgnoreFile

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Network\Email\Email;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\I18n\I18n;
use Cake\Core\App;

date_default_timezone_set('UTC');
mb_internal_encoding('UTF-8');

$findRoot = function () {
    $root = dirname(__DIR__);
    if (is_dir($root . '/vendor/cakephp/cakephp')) {
        return $root;
    }
    $root = dirname(dirname(__DIR__));
    if (is_dir($root . '/vendor/cakephp/cakephp')) {
        return $root;
    }
    $root = dirname(dirname(dirname(__DIR__)));
    if (is_dir($root . '/vendor/cakephp/cakephp')) {
        return $root;
    }
};

// Path constants to a few helpful things.
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

define('ROOT', $findRoot());
define('APP_DIR', 'App');
define('WEBROOT_DIR', 'webroot');
define('APP', ROOT . '/tests/App/');
define('CONFIG', ROOT . '/tests/config/');
define('WWW_ROOT', ROOT . DS . WEBROOT_DIR . DS);
define('TESTS', ROOT . DS . 'tests' . DS);
define('TMP', ROOT . DS . 'tmp' . DS);
define('LOGS', TMP . 'logs' . DS);
define('CACHE', TMP . 'cache' . DS);
define('CAKE_CORE_INCLUDE_PATH', ROOT . '/vendor/cakephp/cakephp');
define('CORE_PATH', CAKE_CORE_INCLUDE_PATH . DS);
define('CAKE', CORE_PATH . 'src' . DS);

require ROOT . '/vendor/autoload.php';
require CORE_PATH . 'config/bootstrap.php';
require APP . 'Controller/AppController.php';
require APP . 'Controller/Admin/AppController.php';

Cake\Core\Configure::write('App', ['namespace' => 'GintonicCMS\tests\App']);
Configure::write('debug', true);

$TMP = new \Cake\Filesystem\Folder(TMP);
$TMP->create(TMP . 'cache/models', 0777);
$TMP->create(TMP . 'cache/persistent', 0777);
$TMP->create(TMP . 'cache/views', 0777);

Cache::config([
    'default' => [
        'engine' => 'File'
    ],
    '_cake_core_' => [
        'engine' => 'File',
        'prefix' => 'cake_core_',
        'serialize' => true
    ],
    '_cake_model_' => [
        'engine' => 'File',
        'prefix' => 'cake_model_',
        'serialize' => true
    ]
]);

Configure::write([
    'Acl.classname' => 'DbAcl',
    'Acl.database' => 'default',
    'Gintonic.website.name' => 'GintonicCMS'
]);

Configure::load('email');
//Configure::load('app');
Email::configTransport(Configure::consume('EmailTransport'));
Email::config(Configure::consume('Email'));

if (!getenv('db_dsn')) {
    //putenv('db_dsn=postgres://postgres@127.0.0.1/cakephp_test');
    putenv('db_dsn=sqlite:///:memory:');
}

Plugin::load('GintonicCMS', ['path' => ROOT]);

Cake\Routing\DispatcherFactory::add('Routing');
Cake\Routing\DispatcherFactory::add('ControllerFactory');

date_default_timezone_set('UTC');
mb_internal_encoding('UTF-8');
Cake\Datasource\ConnectionManager::config('test', [
    'url' => getenv('db_dsn'),
    'timezone' => 'UTC'
]);
