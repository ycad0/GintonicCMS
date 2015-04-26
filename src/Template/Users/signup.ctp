<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title"><?php echo __('Sign up'); ?></h1>
            <div class="account-wall">
                <?= $this->Html->link(
                    $this->Html->image('GintonicCMS.logo.png', [
                        "class" => "img-responsive profile-img site-logo",
                        "alt" => 'GintonicCMS'
                    ]), '/', ['escape'=>false]
                );?>
                <?= $this->Flash->render(); ?>
                <?= $this->Form->create('Users',[
                    'url'=>['action'=>'signup'],
                    'templates'=>['submitContainer' => '<div class="submit form-group">{{content}}</div>'],
                    'class' => 'form-signin form-horizontal','id'=>'UserSignupForm'
                ]);?>
                // TODO: Check what's up with parsley, require is outside here
                <?= $this->Form->input('first',[
                    'class'=>'form-control',
                    'placeholder'=>__('First Name'),
                    'id'=>'signup-first'
                ],'required');?>
                <?= $this->Form->input('last',[
                    'class'=>'form-control',
                    'placeholder'=>__('Last Name'),
                    'id'=>'signup-last'
                ]);?>
                // TODO: and it's on the inside here
                <?= $this->Form->input('email',[
                    'class'=>'form-control',
                    'placeholder'=>__('Email'),
                    'id'=>'signup-email',
                    'parsley-trigger'=>'change',
                    'required'
                ]);?>
                <?= $this->Form->input('password',[
                    'type'=>'password',
                    'class'=>'form-control',
                    'placeholder'=>__('Password'),
                    'id'=>'signup-password'
                ]);?>
                <?= $this->Form->submit(__('Sign up'),[
                    'class'=>'btn btn-lg btn-primary btn-block'
                ]);?>
                <?= $this->Form->end(); ?>
            </div>
            <?= $this->Html->link(
                __('Already have an account?'),
                ['action'=>'signin'],
                ['escape'=>false,'class' => 'text-center new-account']
            ); ?>
        </div>
    </div>
</div>
