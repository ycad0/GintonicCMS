<?php 
use Cake\Core\Configure;
?>
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">Reset your password</h1>
            <div class="account-wall">
                <?= $this->element('GintonicCMS.site_logo'); ?>
                <?= $this->Form->create('Users', [
                    'class' => 'form-signin',
                    'url'=>[
                        'controller'=>'Users',
                        'action'=>'recover',
                        $id,
                        $token
                    ], 
                    'id' => 'UserLoginForm',
                    'novalidate' => 'novalidate'
                ]);?>
                <?= $this->Flash->render(); ?>
                <?= $this->Form->input('password', [
                    'label' => false,
                    'type'=>'password',
                    'class' => 'form-control',
                    'placeholder' => 'New Password',
                    'required',
                    'autofocus',
                    'style'=>['margin-bottom:0px;']
                ]);?>
                <?= $this->Form->input('confirm_password', [
                    'label' => false,
                    'type'=>'password',
                    'class' => 'form-control',
                    'placeholder' => 'Confirm Password',
                    'required',
                    'autofocus',
                ]);?>
                <?= $this->Form->submit(
                    __('Reset Password'),
                    ['class' => 'btn btn-lg btn-primary btn-block']
                ); ?>
                <span class="clearfix"></span>
                <?= $this->Form->end();?>
            </div>
            <?= $this->Html->link(
                __('Already have an account?'),
                ['controller' => 'Users', 'action' => 'signin'], 
                ['escape' => false,'class'=>'text-center new-account']
            ); ?>
        </div>
    </div>
</div>
