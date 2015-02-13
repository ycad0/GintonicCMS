<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-8"><h3 style='margin-top:0px'><?php echo __('Add User'); ?></h3></div>
            <div class="col-md-4 text-right">
                <?php 
                echo $this->Html->link('<i class="fa fa-reply">&nbsp;</i>'.__('Back'),['action'=>'index'],['escape'=>false]);
                ?>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <?php echo $this->Form->create($user, array('inputDefaults' => array('div' => 'col-md-12 form-group', 'class' => 'form-control'), 'class' => 'form-horizontal', 'id' => 'CompanyAddForm', 'novalidate' => 'novalidate')); ?>
        <div class="row">
            <div class="col-md-12">				
                <?php
                $myTemplates = [
                    'inputContainer' => '<div class="form-group no-leftpadding input text col-md-2 col-sm-2">{{content}}</div>',
                    'input' => ['class' => 'form-control']
                ];
                $this->Form->templates($myTemplates);
                echo $this->Form->input('first', array('label' => __('First Name')));
                echo $this->Form->input('last', array('label' => __('Last Name')));
                echo $this->Form->input('email', array('label' => __('Email')));
                echo $this->Form->input('password',['label'=>__('Password')]);
                echo $this->Form->submit(__('Create User'), array('div' => false,'class' => 'btn btn-primary'));
                ?>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
