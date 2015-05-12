<?php 
$this->Helpers()->load('GintonicCMS.Require');
echo $this->Require->req('users/forgotpassword_validation'); 
?>
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title"><?php echo __('Forgot your password?'); ?></h1>
            <div class="account-wall">            
                <?= $this->element('GintonicCMS.site_logo'); ?>
                <?= $this->Form->create('Users', [
                    'templates'=>['submitContainer' => '<div class="submit form-group">{{content}}</div>'],
                    'class' => 'form-signin form-horizontal',
                    'id' => 'UserForgotPasswordForm',
                    'novalidate' => 'novalidate'
                ]);?>
                <?= $this->Flash->render();?>
                <?= $this->Form->input('email',[
                    'autofocus',
                    'placeholder'=>__('Email'),
                    'required'
                ]);?>
                <span class="clearfix"></span>
                <?= $this->Form->submit(
                    __('Submit'),
                    ['class' => 'btn btn-lg btn-primary btn-block']
                );?>
                <?= $this->Form->end(); ?>
            </div>
            <?= $this->Html->link(
                __('Already have an account?'),
                ['action'=>'signin'],
                ['escape'=>false,'class' => 'text-center new-account']
            );?>
        </div>
    </div>
</div>
