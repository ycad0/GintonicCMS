<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-8"><h3 style='margin-top:0px'>Edit User</h3></div>
            <div class="col-md-4 text-right"><?php echo $this->Html->actionIconBtn('fa fa-reply', ' Back', 'index'); ?></div>
        </div>
    </div>
    <div class="panel-body">
        <?php echo $this->Form->create('Users', array('templates'=>['inputContainer' => ['div' => 'col-md-12 form-group', 'class' => 'form-control']], 'class' => 'form-horizontal', 'id' => 'CompanyAddForm')); ?>
        <input id="user-id" type="hidden" value="<?php echo $this->request->data['User']['id'] ?>" />
        <div class="row">
            <div class="col-md-12">				
                <?php
                echo $this->Form->input('first', array(
                    'label' => 'First Name',
                ));
                ?>
                <?php
                echo $this->Form->input('last', array(
                    'label' => 'Last Name',
                ));
                ?>
                <?php
                echo $this->Form->input('email', array(
                    'label' => 'Email',
                ));
                ?>				
        <?php
        echo $this->Form->submit('Save', array(
            'div' => false,
            'class' => 'btn btn-primary'
        ));
        ?>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
