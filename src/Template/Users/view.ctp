<?php
$this->assign('pagetitle', __('User detail') . '<small>' . __('User Management') . '</small>');
$this->Html->addCrumb(__('User Management'), ['controller' => 'users', 'action' => 'admin_index']);
$this->Html->addCrumb(__('view user detail'));
$this->start('top_links');
if($this->request->session()->read('Auth.User.role') == 'admin'){
    echo $this->Html->link('<i class="fa fa-plus">&nbsp;</i> Add User', ['action' => 'admin_add'], ['class' => 'btn btn-primary btn-sm', 'escape' => false, 'title' => 'Click here to add new user']);
    echo $this->Html->link('<i class="fa fa-edit">&nbsp;</i> Edit User', ['action' => 'admin_edit', $user->id], ['class' => 'btn btn-primary btn-sm', 'escape' => false, 'title' => 'Click here to edit this user']);
}
$this->end();
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-footer clearfix">
                <h1><?php echo $user->first.' '.$user->last; ?></h1>
            </div>
            <div class="box-body clearfix">
                <div class="col-md-4">
                    <?= $this->Html->image(
                        $user['file']['filename'], 
                        ['class' => 'img-responsive img-thumbnail']
                    ); ?>
                </div>
                <div class="col-md-8">
                    <div class="col-md-2 col-sm-3">
                        <?php echo __('First Name: ');?>
                    </div>
                    <div class="col-md-10 col-sm-9">
                        <?php echo $user->first;?>
                    </div>
                    <div class="col-md-2 col-sm-3">
                        <?php echo __('Last Name: ');?>
                    </div>
                    <div class="col-md-10 col-sm-9">
                        <?php echo $user->last;?>
                    </div>
                    <div class="col-md-2 col-sm-3">
                        <?php echo __('Email: ');?>
                    </div>
                    <div class="col-md-10 col-sm-9">
                        <?php echo $this->Html->link($user->email,'mailto:'.$user->email,['escape'=>false])?>
                    </div>
                </div>
            </div>
            <div class="box-footer clearfix">
            </div>
        </div>
    </div>
</div>
