<?php 
 $this->Helpers->load('GtwRequire.GtwRequire');
echo $this->Require->req('users/resend_code'); 
?>
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title"><?php echo __('Resend the Email Verification')?></h1>
            <div class="account-wall">            
                <?php echo $this->Html->image("/GtwUsers/img/logo.png", array("class" => "img-responsive profile-img")); ?>
                <?php echo $this->Form->create('User', array(
                        'action' => 'resend_verification',
                        'class' => 'form-signin',
                        'id'=>'UserResendVerificationForm',
                        'novalidate'=>'novalidate'
                ));?>
                    <?php echo $this->Session->flash(); ?>
					<?php echo $this->Form->input('email',array('label'=>false,'class'=>'form-control','autofocus','placeholder'=>'Email Address','required','div'=>array('class'=>'form-group')))?>
					<?php echo $this->Form->submit(__('Resend Code'),array('class'=>'btn btn-lg btn-primary btn-block'))?>
                    <span class="clearfix"></span>
                </form>
            </div>
            <?php echo $this->Html->link(__('Already have an account?'),
                array(
                    'plugin' => 'gtw_users',
                    'controller' => 'users',
                    'action' => 'signin'
                ),
                array(
                    'class' => 'text-center new-account'
                ));
             ?>
        </div>
    </div>
</div>
