<?php 
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;

$this->Helpers()->load('GtwRequire.GtwRequire');
echo $this->GtwRequire->req('users/forgotpassword_validation'); 
?>
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title"><?php echo __('Forgot your password?'); ?></h1>
            <div class="account-wall">            
                <?php 
                echo $this->Html->image(Configure::read('Gtw.site_logo_url'), ["class" => "img-responsive profile-img", "alt" => Configure::read('Gtw.site_name')]);
                echo $this->Form->create('Users', ['templates'=>['inputContainer' => '<div class="form-group input text">{{content}}</div>','input'=>'<input type="{{type}}" class="form-control" name="{{name}}"{{attrs}}>'],'class' => 'form-signin', 'id' => 'UserForgotPasswordForm', 'novalidate' => 'novalidate']);
                echo $this->Flash->render();
                echo $this->Form->input('email',['autofocus','placeholder'=>__('Email'),'required']);
                ?>
                <span class="clearfix"></span>
                <?php 
                echo $this->Form->submit(__('Submit'), ['class' => 'btn btn-lg btn-primary btn-block']);
                echo $this->Form->end(); 
                ?>
            </div>
            <?php echo $this->Html->link(__('Already have an account?'),['controller'=>'users','action'=>'signin'],['escape'=>false,'class' => 'text-center new-account']); ?>
        </div>
    </div>
</div>
