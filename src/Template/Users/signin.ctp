<?php

use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;

$this->Helpers()->load('GintonicCMS.Require');
echo $this->Require->req('users/login_validation'); 

?>

<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3">
            <h1 class="text-center login-title">
                <?php echo __('Sign in to continue'); ?>
            </h1>
            <div class="account-wall">

                <?php echo $this->Html->image(
                    Configure::read('site_logo_url'), 
                    [
                        "class" => "img-responsive profile-img site-logo",
                        "alt" => Configure::read('site_name')
                    ]
                );?>

                <?php echo $this->Form->create('Users', [
                    'inputdefaults' => [
                        'div' => 'form-group',
                        'wrapInput' => false,
                        'class' => 'form-control'
                    ],
                    'templates' => [
                        'submitContainer' => '<div class="submit form-group">{{content}}</div>'
                    ],
                    'class' => 'form-signin form-horizontal', 
                    'id' => 'UserLoginForm',
                    'novalidate' => 'novalidate'
                ]); ?>

                <?php echo $this->Flash->render(); ?>

                <p class="text-center form-group">
                    <?php echo $this->Html->link(
                        __('Create an account'),
                        ['controller' => 'Users', 'action' => 'signup'], 
                        [
                            'class' => 'text-center new-account',
                            'style' => 'display:inline-block'
                        ]
                    );?>
                </p>

                <?php echo $this->Form->input('email', [
                    'label' => false,
                    'placeholder' => 'Email',
                    'required', 'autofocus'
                ]);?>
                <?php echo $this->Form->input('password', [

                    'label' => false,
                    'placeholder' => 'Password',
                    'required'
                ]); ?>
                <?php echo $this->Form->submit(__('Sign in'), 
                    ['class' => 'btn btn-lg btn-primary btn-block']
                );?>
                <p class="checkbox form-group">
                    <label>
                        <input name="remember" type="checkbox" value="remember-me">
                        <?php echo __('Remember me'); ?>
                    </label>
                </p>
                <div class="clearfix"></div>
                <?php echo $this->Form->end(); ?>
            </div>
            <p class="text-center">
                <br>
                <?php echo $this->Html->link(
                    __('Forgot your password?'),
                    [
                        'controller' => 'Users',
                        'action' => 'forgot_password'
                    ],
                    ['escape' => false]
                ); ?>
            </p>
        </div>
    </div>
</div>
