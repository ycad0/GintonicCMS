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
    //$routes->fallbacks('InflectedRoute');
});
/*Router::prefix('admin', ['plugin' => 'GintonicCMS'], function ($routes) {

    $routes->connect('/signin', ['controller' => 'Users', 'action' => 'signin']);
    $routes->connect('/signout', ['controller' => 'Users', 'action' => 'signout']);
    $routes->connect('/signup', ['controller' => 'Users', 'action' => 'signup']);
    $routes->connect('/change_password', ['controller' => 'Users', 'action' => 'change_password']);
    $routes->connect('/profile', ['controller' => 'Users', 'action' => 'profile']);

    //    $routes->fallbacks('InflectedRoute');
});*/
