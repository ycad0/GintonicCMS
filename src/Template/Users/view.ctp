<?php
$this->assign('pagetitle', __('view user detail') . '<small>' . __('User Management') . '</small>');
$this->Html->addCrumb(__('User Management'), ['controller' => 'users', 'action' => 'index']);
$this->Html->addCrumb(__('view user detail'));
$this->start('top_links');
echo $this->Html->link('<i class="fa fa-reply">&nbsp;</i> Back', ['action' => 'index'], ['class' => 'btn btn-default', 'escape' => false, 'title' => 'Click here to goto users list']);
if($this->request->session()->read('Auth.User.role') == 'admin'){
    echo $this->Html->link('<i class="fa fa-plus">&nbsp;</i> Add User', ['action' => 'add'], ['class' => 'btn btn-primary', 'escape' => false, 'title' => 'Click here to add new user']);
    echo $this->Html->link('<i class="fa fa-edit">&nbsp;</i> Edit User', ['action' => 'edit', $user->id], ['class' => 'btn btn-primary', 'escape' => false, 'title' => 'Click here to edit this user']);
}
$this->end();
?>
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-footer clearfix">
                <h1><?php echo $user->first.' '.$user->last; ?></h1>
            </div>
            <div class="box-body">
                <div class="col-md-8">
                    <?php echo $this->Html->image($avatar, array('class' => 'img-responsive img-thumbnail')); ?>
                </div>
                <div class="col-md-4">
                    <h2><a href="mailto:<?php echo $user->email ?>"><?php echo $user->email; ?></a></h2>
                </div>
            </div>
            <div class="box-footer clearfix">
            </div>
        </div>
    </div>
</div>