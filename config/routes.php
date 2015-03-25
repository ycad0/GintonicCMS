<?php
use Cake\Routing\Router;

Router::scope('/', ['plugin' => 'GintonicCMS'], function ($routes) {
    Router::extensions('rss');
    $routes->connect('/', array('controller' => 'Users', 'action' => 'signin'));
    $routes->connect('/users', ['controller' => 'Users']);
    $routes->connect('/files', array('controller' => 'Files'));
    $routes->connect('/signin', array('controller' => 'Users', 'action' => 'signin'));
    $routes->connect('/signout', array('controller' => 'Users', 'action' => 'signout'));
    $routes->connect('/signup', array('controller' => 'Users', 'action' => 'signup'));
    $routes->fallbacks('InflectedRoute');
});
//Router::plugin('GintonicCMS', function ($routes) {
//});
