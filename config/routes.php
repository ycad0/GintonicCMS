<?php

use Cake\Routing\Router;

Router::scope('/', ['plugin' => 'GintonicCMS'], function ($routes) {

    $routes->connect('/signin', ['controller' => 'Users', 'action' => 'signin']);
    $routes->connect('/signout', ['controller' => 'Users', 'action' => 'signout']);
    $routes->connect('/signup', ['controller' => 'Users', 'action' => 'signup']);

    $routes->connect('/users', ['controller' => 'Users']);
    $routes->connect('/users/:action/*', ['controller' => 'Users']);

    $routes->connect('/messages', ['controller' => 'Messages']);
    $routes->connect('/messages/:action/*', ['controller' => 'Messages']);

    $routes->connect('/payments', ['controller' => 'Payments']);
    $routes->connect('/payments/index/*', ['controller' => 'Payments', 'action'=>'index']);
    $routes->connect('/payments/success/*', ['controller' => 'Payments', 'action'=>'success']);
    $routes->connect('/payments/fail/*', ['controller' => 'Payments', 'action'=>'fail']);
    $routes->connect('/payments/callback_subscribes/*', ['controller' => 'Payments', 'action'=>'callback_subscribes']);
    $routes->connect('/payments/subscribe/*', ['controller' => 'Payments', 'action'=>'subscribe']);
    
    $routes->connect('/subscribe_plans', ['controller' => 'SubscribePlans', 'action'=>'index']);
    $routes->connect('/subscribe_plans/delete/*', ['controller' => 'SubscribePlans', 'action'=>'delete']);
    $routes->connect('/subscribe_plans/user_subscribe/*', ['controller' => 'SubscribePlans', 'action'=>'user_subscribe']);
    $routes->connect('/subscribe_plans/unsubscribe_user/*', ['controller' => 'SubscribePlans', 'action'=>'unsubscribe_user']);
    $routes->connect('/subscribe_plans/create_plans/*', ['controller' => 'SubscribePlans', 'action'=>'create_plans']);
    $routes->connect('/subscribe_plans/myplantransaction/*', ['controller' => 'SubscribePlans', 'action'=>'myplantransaction']);
    $routes->connect('/subscribe_plans/usertransaction/*', ['controller' => 'SubscribePlans', 'action'=>'usertransaction']);
    $routes->connect('/subscribe_plans/subscribeslist/*', ['controller' => 'SubscribePlans', 'action'=>'subscribeslist']);

    $routes->fallbacks('InflectedRoute');
});

Router::plugin('GintonicCMS', function ($routes) {
    $routes->prefix('admin', function ($routes) {
        $routes->fallbacks('InflectedRoute');
    });
    $routes->fallbacks('InflectedRoute');
});
