<?php

use Cake\Routing\Router;

Router::plugin('GintonicCMS', function ($routes) {
    Router::extensions('rss');
    $routes->connect('/', array('plugin' => 'GintonicCMS', 'controller' => 'users', 'action' => 'signin'));
    $routes->connect('/users', array('plugin' => 'GintonicCMS', 'controller' => 'users'));
    $routes->connect('/users/*', array('plugin' => 'GintonicCMS', 'controller' => 'users'));
    $routes->connect('/signin', array('plugin' => 'GintonicCMS', 'controller' => 'users', 'action' => 'signin'));
    $routes->connect('/signout', array('plugin' => 'GintonicCMS', 'controller' => 'users', 'action' => 'signout'));
    $routes->connect('/signup', array('plugin' => 'GintonicCMS', 'controller' => 'users', 'action' => 'signup'));
    $routes->fallbacks();
});
