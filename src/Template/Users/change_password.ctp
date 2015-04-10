<?php
$this->assign('pagetitle', __('Change Password') . '<small>' . __('My Profile') . '</small>');
$this->Html->addCrumb(__('My Profile'), ['controller' => 'users', 'action' => 'profile']);
$this->Html->addCrumb(__('Change Password'));
$this->start('top_links');
echo $this->Html->link('<i class="fa fa-reply">&nbsp;</i> Back', $this->request->referer(), ['class' => 'btn btn-default', 'escape' => false, 'title' => 'Click here to goto back']);
$this->end();
$this->Helpers()->load('GintonicCMS.Require');
echo $this->Require->req('users/change_password');
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-body">
                <?php echo $this->Form->create('Users', [
                    'templates' => [
                        'inputContainer' => '<div class="form-group input text col-md-12">{{content}}</div>',
                        'input' => '<input type="{{type}}" class="form-control" name="{{name}}"{{attrs}}>'
                    ], 
                    'class' => 'form-horizontal', 
                    'id' => 'UserChangePasswordForm'
                ]); ?>
                <div class="row">
                    <div class="col-md-12">				
                    <?php
                        echo $this->Form->input('current_password', ['type' => 'password']);
                        echo $this->Form->input('new_password', ['type' => 'password']);
                        echo $this->Form->input('confirm_password', ['type' => 'password']);
                        echo $this->Form->submit('Change Password', array('div' => false, 'class' => 'btn btn-primary'));
                    ?>
                    </div>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
