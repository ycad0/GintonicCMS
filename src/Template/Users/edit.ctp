<?php
$this->assign('pagetitle', __('Edit user') . '<small>' . __('User Management') . '</small>');
$this->Html->addCrumb(__('User Management'), ['controller' => 'users', 'action' => 'index']);
$this->Html->addCrumb(__('Edit user'));
$this->start('top_links');
echo $this->Html->link('<i class="fa fa-reply">&nbsp;</i> Back', ['action' => 'index'], ['class' => 'btn btn-default', 'escape' => false, 'title' => 'Click here to goto users list']);
if($this->request->session()->read('Auth.User.role') == 'admin'){
    echo $this->Html->link('<i class="fa fa-plus">&nbsp;</i> Add User', ['action' => 'add'], ['class' => 'btn btn-primary', 'escape' => false, 'title' => 'Click here to add new user']);
    echo $this->Html->link('<i class="fa fa-th">&nbsp;</i> View User', ['action' => 'view', $user->id], ['class' => 'btn btn-primary', 'escape' => false, 'title' => 'Click here to view this user']);
}
$this->end();
$this->Helpers()->load('GintonicCMS.GtwRequire');
echo $this->GtwRequire->req('users/add_edit');
echo $this->GtwRequire->req('files/filepicker');
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-body">
                <?php echo $this->Form->create($user, array('templates' => ['inputContainer' => '<div class="form-group input text col-md-12">{{content}}</div>', 'input' => '<input type="{{type}}" class="form-control" name="{{name}}"{{attrs}}>'], 'class' => 'form-horizontal', 'id' => 'UserAddEditForm')); ?>
                <div class="row">
                    <div class="col-md-12">				
                        <?php
                        echo $this->Form->input('id', ['type' => 'hidden']);
                        echo $this->Form->input('first', ['label' => __('First Name')]);
                        echo $this->Form->input('last', ['label' => __('Last Name')]);
                        echo $this->Form->input('email', ['label' => __('Email')]);
                        echo $this->Form->submit('Save', ['class' => 'btn btn-primary']);
                        ?>
                    </div>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
