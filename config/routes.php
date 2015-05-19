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
    $routes->connect('/payments/callbackSubscribes/*', ['controller' => 'Payments', 'action'=>'callbackSubscribes']);
    $routes->connect('/payments/subscribe/*', ['controller' => 'Payments', 'action'=>'subscribe']);
    $routes->connect('/payments/confirmPayment/*', ['controller' => 'payments', 'action'=>'confirmPayment']);
    
    $routes->connect('/plans', ['controller' => 'Plans', 'action'=>'index']);
    $routes->connect('/plans/delete/*', ['controller' => 'Plans', 'action'=>'delete']);
    $routes->connect('/plans/userSubscribe/*', ['controller' => 'Plans', 'action'=>'userSubscribe']);
    $routes->connect('/plans/unsubscribeUser/*', ['controller' => 'Plans', 'action'=>'unsubscribeUser']);
    $routes->connect('/plans/createPlans/*', ['controller' => 'Plans', 'action'=>'createPlans']);
    $routes->connect('/plans/myplantransaction/*', ['controller' => 'Plans', 'action'=>'myplantransaction']);
    $routes->connect('/plans/usertransaction/*', ['controller' => 'Plans', 'action'=>'usertransaction']);
    $routes->connect('/plans/subscribeslist/*', ['controller' => 'Plans', 'action'=>'subscribeslist']);

    $routes->fallbacks('InflectedRoute');
});

Router::plugin('GintonicCMS', function ($routes) {
    $routes->prefix('admin', function ($routes) {
        $routes->fallbacks('InflectedRoute');
    });
    $routes->fallbacks('InflectedRoute');
});
