<?php

namespace GintonicCMS\Test\App\Config;

use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Routing\Router;

Router::scope('/', ['plugin' => 'GintonicCMS'], function ($routes) {

    $routes->extensions(['json']);
    
    $routes->connect('/signin', ['controller' => 'Users', 'action' => 'signin']);
    $routes->connect('/signout', ['controller' => 'Users', 'action' => 'signout']);
    $routes->connect('/signup', ['controller' => 'Users', 'action' => 'signup']);

    $routes->connect('/users', ['controller' => 'Users']);
    $routes->connect('/users/:action/*', ['controller' => 'Users']);
    
    $routes->connect('/charges', ['controller' => 'Charges']);
    $routes->connect('/charges/:action/*', ['controller' => 'Charges']);
    
    $routes->connect('/plans', ['controller' => 'Plans']);
    $routes->connect('/plans/:action/*', ['controller' => 'Plans']);

    $routes->connect('/messages', ['controller' => 'Messages']);
    $routes->connect('/messages/:action/*', ['controller' => 'Messages']);

	$routes->connect('/settings/:action/*', ['controller' => 'Settings']);
	
    $routes->fallbacks('InflectedRoute');

    $routes->prefix('admin', function ($routes) {
        $routes->connect('/users', ['controller' => 'Users']);
        $routes->connect('/users/:action/*', ['controller' => 'Users']);
        $routes->connect('/plans', ['controller' => 'Plans']);
        $routes->connect('/plans/:action/*', ['controller' => 'Plans']);
        $routes->fallbacks('InflectedRoute');
    });
});

Router::plugin('GintonicCMS', function ($routes) {

    $routes->prefix('admin', function ($routes) {
        $routes->fallbacks('InflectedRoute');
    });

    $routes->extensions(['json']);
    $routes->fallbacks('InflectedRoute');

});
