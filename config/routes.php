<?php

use Cake\Routing\Router;

Router::scope('/', ['plugin' => 'GintonicCMS'], function ($routes) {

    $routes->fallbacks('DashedRoute');

    $routes->prefix('admin', function ($routes) {

        $routes->connect('/users', ['controller' => 'Users']);
        $routes->connect('/users/:action/*', ['controller' => 'Users']);
        $routes->connect('/plans', ['controller' => 'Plans']);
        $routes->connect('/plans/:action/*', ['controller' => 'Plans']);

        $routes->fallbacks('DashedRoute');
    });

});
