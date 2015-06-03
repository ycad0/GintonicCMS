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
    
    $routes->connect('/subscribe_plans', ['controller' => 'SubscribePlans', 'action'=>'index']);
    $routes->connect('/subscribe_plans/delete/*', ['controller' => 'SubscribePlans', 'action'=>'delete']);
    $routes->connect('/subscribe_plans/userSubscribe/*', ['controller' => 'SubscribePlans', 'action'=>'userSubscribe']);
    $routes->connect('/subscribe_plans/unsubscribeUser/*', ['controller' => 'SubscribePlans', 'action'=>'unsubscribeUser']);
    $routes->connect('/subscribe_plans/createPlans/*', ['controller' => 'SubscribePlans', 'action'=>'createPlans']);
    $routes->connect('/subscribe_plans/myplantransaction/*', ['controller' => 'SubscribePlans', 'action'=>'myplantransaction']);
    $routes->connect('/subscribe_plans/usertransaction/*', ['controller' => 'SubscribePlans', 'action'=>'usertransaction']);
    $routes->connect('/subscribe_plans/subscribeslist/*', ['controller' => 'SubscribePlans', 'action'=>'subscribeslist']);

    

    $routes->connect('/social_signup/google/*', ['controller' => 'SocialSignups', 'action'=>'google']);
    $routes->connect('/social_signup/facebook/*', ['controller' => 'SocialSignups', 'action'=>'facebook']);
    
    $routes->fallbacks('InflectedRoute');
});

Router::plugin('GintonicCMS', function ($routes) {
    $routes->prefix('admin', function ($routes) {
        $routes->fallbacks('InflectedRoute');
    });
    $routes->fallbacks('InflectedRoute');
});
