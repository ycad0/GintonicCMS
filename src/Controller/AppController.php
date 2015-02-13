<?php

namespace GintonicCMS\Controller;

use App\Controller\AppController as BaseController;
use Cake\Event\Event;

class AppController extends BaseController {
    
    public function initialize() {
//        $this->loadHelper('Form', [
//            'templates' => 'app_form',
//        ]);
        
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'authorize' => 'Controller', //added this line
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'email',
                        'password' => 'password'
                    ]
                ]
            ],
            'unauthorizedRedirect' => [
                'controller' => 'Users',
                'action' => 'login'
            ]
        ]);
        
    }
}
?>
