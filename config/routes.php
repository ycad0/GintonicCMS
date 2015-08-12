<?php

use Cake\Routing\Router;

Router::scope('/', function ($routes) {

    $routes->fallbacks('DashedRoute');
    $routes->prefix('admin', function ($routes) {
        $routes->fallbacks('DashedRoute');
    });

});
