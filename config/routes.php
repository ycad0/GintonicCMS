<?php

use Cake\Routing\Router;

Router::scope('/', ['plugin' => 'GintonicCMS'], function ($routes) {

    $routes->extensions(['json']);
    
    $routes->connect('/signin', ['controller' => 'Users', 'action' => 'signin']);
    $routes->connect('/signout', ['controller' => 'Users', 'action' => 'signout']);
    $routes->connect('/signup', ['controller' => 'Users', 'action' => 'signup']);

    $routes->connect('/users', ['controller' => 'Users']);
    $routes->connect('/users/:action/*', ['controller' => 'Users']);

    $routes->connect('/messages', ['controller' => 'Messages']);
    $routes->connect('/messages/:action/*', ['controller' => 'Messages']);

    $routes->connect('/payments', ['controller' => 'Payments']);
    $routes->connect('/payments/:action/*', ['controller' => 'Payments']);
    
    $routes->connect('/plans', ['controller' => 'Plans', 'action'=>'index']);
    $routes->connect('/plans/:action/*', ['controller' => 'Plans']);

	
    $routes->fallbacks('InflectedRoute');
});

Router::plugin('GintonicCMS', function ($routes) {

    $routes->prefix('admin', function ($routes) {
        $routes->fallbacks('InflectedRoute');
    });

    $routes->extensions(['json']);
    $routes->fallbacks('InflectedRoute');
	$routes->connect('/settings/:action/*', ['controller' => 'Settings']);

});
