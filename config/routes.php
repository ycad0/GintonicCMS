<?php
use Cake\Routing\Router;

Router::plugin('GintonicCMS', function ($routes) 
{
    Router::extensions('rss');
    $routes->connect('/', array('controller' => 'users', 'action' => 'signin'));
    $routes->connect('/users', array('controller' => 'users'));
    $routes->connect('/files', array('controller' => 'files'));
    $routes->connect('/signin', array('controller' => 'users', 'action' => 'signin'));
    $routes->connect('/signout', array('controller' => 'users', 'action' => 'signout'));
    $routes->connect('/signup', array('controller' => 'users', 'action' => 'signup'));
    $routes->fallbacks('InflectedRoute');
});