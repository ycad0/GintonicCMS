<?php
namespace Crud\Test\App\Config;

use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Routing\Router;

Router::scope('/', function ($routes) {
    $routes->extensions(['json']);
    $routes->connect('/:controller', ['action' => 'index', 'plugin' => 'GintonicCMS'], ['routeClass' => 'InflectedRoute']);
    $routes->connect('/:controller/:action/*', ['plugin' => 'GintonicCMS'], ['routeClass' => 'InflectedRoute']);
});
