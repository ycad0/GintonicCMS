<?php
$this->Helpers()->load('GintonicCMS.Require');
echo $this->Require->req('users/resend_code');

?>
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title"><?= __('Resend the Email Verification') ?></h1>
            <div class="account-wall">
                <?= $this->element('GintonicCMS.site_logo'); ?>
                <?=
                $this->Form->create('Users', [
                    'class' => 'form-signin',
                    'url' => ['controller' => 'Users', 'action' => 'sendVerification'],
                    'id' => 'UserResendVerificationForm',
                    'novalidate' => 'novalidate'
                ]);

                ?>
                <?= $this->Flash->render(); ?>
                <?=
                $this->Form->input('email', [
                    'label' => 'Email',
                    'class' => 'form-control',
                    'placeholder' => 'Email Address',
                    'required',
                    'autofocus'
                ]);

                ?>
                <?=
                $this->Form->submit(
                    __('Resend Code'), ['class' => 'btn btn-lg btn-primary btn-block'
                ]);

                ?>
                <span class="clearfix"></span>
                <?= $this->Form->end(); ?>
            </div>
            <?=
            $this->Html->link(
                __('Go to Profile?'), ['controller' => 'Users', 'action' => 'profile'], ['escape' => false, 'class' => 'text-center new-account']
            );

            ?>
        </div>
    </div>
</div>
