<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-8"><h3 style='margin-top:0px'><?php echo __('Change Password'); ?></h3></div>
            <div class="col-md-4 text-right">
                <?php 
                echo $this->Html->link('<i class="fa fa-reply">&nbsp;</i>'.__('Back'),['action'=>'index'],['escape'=>false]);
                ?>
            </div>
        </div>
    </div>
    <div class="panel-body">		
        <?php echo $this->Form->create('Users', array('templates'=>['inputContainer' => '<div class="form-group input text col-md-12">{{content}}</div>','input'=>'<input type="{{type}}" class="form-control" name="{{name}}"{{attrs}}>'],'class' => 'form-horizontal', 'id' => 'UserChangePasswordForm')); ?>
        <div class="row">
            <div class="col-md-12">				
                <?php
                echo $this->Form->input('current_password', ['type' => 'password']);
                echo $this->Form->input('new_password', ['type' => 'password']);
                echo $this->Form->input('confirm_password', ['type' => 'password']);
                echo $this->Form->submit('Change Password', array('div' => false,'class' => 'btn btn-primary'));
                ?>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
