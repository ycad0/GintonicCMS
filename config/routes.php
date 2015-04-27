<?php

use Cake\Routing\Router;

Router::plugin('GintonicCMS', function ($routes) {
    $routes->fallbacks('InflectedRoute');
});

Router::scope('/', ['plugin' => 'GintonicCMS'], function ($routes) {
    $routes->connect('/users/:action/*', ['controller' => 'Users']);
    $routes->connect('/signin', ['controller' => 'Users', 'action' => 'signin']);
    $routes->connect('/signout', ['controller' => 'Users', 'action' => 'signout']);
    $routes->connect('/signup', ['controller' => 'Users', 'action' => 'signup']);
    
    /*
     * Routing for Messages
     */
    $routes->connect('/messages', array('controller' => 'messages'));
    $routes->connect('/messages/index/*', array('controller' => 'messages'));
    $routes->connect('/messages/compose/*', array('controller' => 'messages', 'action' => 'compose'));
    $routes->connect('/messages/delete/*', array('controller' => 'messages', 'action' => 'delete'));
    $routes->connect('/messages/view/*', array('controller' => 'messages', 'action' => 'view'));
    $routes->connect('/messages/reply/*', array('controller' => 'messages', 'action' => 'reply'));
    $routes->connect('/messages/forward/*', array('controller' => 'messages', 'action' => 'forward'));
    
    //$routes->fallbacks('InflectedRoute');
});
Router::plugin('GintonicCMS', function ($routes) {
    $routes->prefix('admin', function ($routes) {
        $routes->fallbacks('InflectedRoute');
    });
});
