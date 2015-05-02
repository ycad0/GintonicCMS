<?php 
$this->Helpers()->load('GintonicCMS.Require');
echo $this->Require->req('admin/admin');
?>
<aside class="left-side sidebar-offcanvas">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <?= $this->Html->image('GintonicCMS.avatar.jpg', [
                    'class' => 'img-circle'
                ]);?>
            </div>
            <div class="info">
                <span>
                    <?= $this->request->session()->read('Auth.User.email');?>
                </span>
            </div>
        </div>        
        <ul class="sidebar-menu">
            <li>
            <?= $this->Html->link(
                '<i class="fa fa-dashboard"></i> <span> ' . __('My Profile') . '</span>', 
                [
                    'plugin'=>'GintonicCMS',
                    'controller' => 'users',
                    'action' => 'profile'
                ], 
                ['escape' => false]
            ) ?>
            </li>
            <li>
                <?= $this->Html->link(
                    '<i class="fa fa-user"></i> <span> ' . __('User Management') . '</span>',
                    [
                        'plugin'=>'GintonicCMS',
                        'controller' => 'users',
                        'action' => 'index'
                    ], 
                    ['escape' => false]
                ); ?>
            </li>
            <li>
                <?= $this->Html->link(
                    '<i class="fa fa-file"></i> <span> ' . __('File Management') . '</span>',
                    [
                        'plugin'=>'GintonicCMS',
                        'controller' => 'files',
                        'action' => 'index'
                    ], 
                    ['escape' => false]
                ); ?>
            </li>
        </ul>
    </section>
</aside>
