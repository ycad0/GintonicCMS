<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3">
            <h1 class="text-center login-title">
                <?php echo __('Sign in to continue'); ?>
            </h1>
            <div class="account-wall">
                <?php
                echo $this->Html->image(Cake\Core\Configure::read('Gtw.site_logo_url'), ["class" => "img-responsive profile-img", "alt" => Cake\Core\Configure::read('Gtw.site_name')]);
                ?>
                <?php
                echo $this->Form->create('Users', ['action' => 'signin', 'class' => 'form-signin', 'id' => 'UserLoginForm', 'novalidate' => 'novalidate']);
                ?>
                <?php echo $this->Flash->render() ?>
                <p class="text-center">
                    <?php
                    echo $this->Html->link(__('Create an account'), ['controller' => 'users', 'action' => 'signup'], ['class' => 'text-center new-account', 'style' => 'display:inline-block']);
                    ?>
                </p>
                <?php
                echo $this->Form->input('email',['label'=>false,'name'=>'data[Users][email]','class'=>'form-control','placeholder'=>'Email','required','autofocus']);
                echo $this->Form->input('password',['label'=>false,'name'=>'data[Users][password]','class'=>'form-control','placeholder'=>'Password','required']);
                echo $this->Form->submit(__('Sign in'),['class'=>'btn btn-lg btn-primary btn-block']);
                ?>
                <label class="checkbox pull-left col-xs-10">
                    <input name="data[User][remember]" type="checkbox" value="remember-me">
                    <?php echo __('Remember me'); ?>
                </label>
                <div class="clearfix"></div>
                <?php echo $this->Form->end(); ?>
            </div>
            <p class="text-center">
                <br>
                <?php echo $this->Html->link(__('Forgot your password?'), ['controller' => 'Users', 'action' => 'forgot_password'], ['escape' => false]); ?>
                <br>
                <?php echo $this->Html->link(__('Resend the Email Verification'), ['controller' => 'Users', 'action' => 'resend_verification'], ['escape' => false]); ?>
            </p>
        </div>
    </div>
</div>
