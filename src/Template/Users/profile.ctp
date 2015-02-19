<?php
$this->assign('pagetitle', __('My Profile'));
$this->Html->addCrumb(__('My Profile'));
$this->start('top_links');
//echo $this->Html->link('<i class="fa fa-chevron-left">&nbsp;</i>&nbsp;' . __('Back'),['action' => 'index'],[ 'class' => 'btn btn-default', 'escape' => false]);
$this->end();
?>
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <div class="account-wall">
                <h1 class="text-center login-title">
                    <?php echo __('Welcome :') . ' '. $this->Session->read("Auth.User.first")." ".$this->Session->read("Auth.User.last") ?>
                </h1>
                <div class="text-center">
                <?php echo $this->Html->link('Logout',['controller' => 'users', 'action' => 'signout']); ?>
                </div>
            </div>                       
        </div>
    </div>
</div>
