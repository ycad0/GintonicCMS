<div class="container topic">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3">
            <h1 class="text-center login-title">
                <?php echo __('Sign in to continue'); ?>
            </h1>
            <div class="account-wall">
                <?= $this->element('GintonicCMS.site_logo'); ?>
                <?= $this->Flash->render(); ?>
                <?= $this->Form->create('Users', [
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
                ])?>


                <p class="text-center form-group">
                    <?= $this->Html->link(
                        __('Create an account'), ['action' => 'signup'], [
                        'class' => 'text-center new-account',
                        'style' => 'display:inline-block'
                        ]
                    )?>
                </p>

                <?= $this->Form->input('email', [
                    'label' => false,
                    'placeholder' => 'Email',
                    'required', 'autofocus'
                ])?>
                <?= $this->Form->input('password', [
                    'label' => false,
                    'placeholder' => 'Password',
                    'required'
                ])?>
                <?= $this->Form->submit(__('Sign in'), [
                    'class' => 'btn btn-lg btn-primary btn-block'
                ])?>
                <p class="checkbox form-group">
                    <label>
                        <input name="remember" type="checkbox" value="remember-me">
                        <?= __('Remember me') ?>
                    </label>
                </p>
                <div class="clearfix"></div>
                <?= $this->Form->end(); ?>
            </div>
            <p class="text-center">
                <br>
                <?= $this->Html->link(
                    __('Forgot your password?'), 
                    ['action' => 'sendRecovery'], 
                    ['escape' => false]
                )?>
            </p>
        </div>
    </div>
</div>
