<?php

use Cake\Core\Configure;
?>
<header class="header">
    <?php echo $this->Html->link(
        $this->Html->image(
            'GintonicCMS.gintonic-white.png',
            ['alt' => Configure::read('site_name')]
        ),
        ['controller' => 'admins', 'action' => 'index'],
        ['escape' => false, 'class' => 'logo']
    ); ?>
    <nav class="navbar navbar-static-top" role="navigation">
        <div class="container-fluid">
            <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <ul class="nav navbar-nav navbar-right">					
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-user"></i>
                        <span>
                            <?php echo $this->request->session()->read('Auth.User.email'); ?> <i class="caret"></i>
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header bg-danger">
                            <?php echo $this->Html->image($this->File->getFileUrl($this->request->session()->read('Auth.User.file.filename')), ['class' => 'img-circle']); ?>
                            <p>
                                <?php echo $this->request->session()->read('Auth.User.first') . ' ' . $this->request->session()->read('Auth.User.last'); ?>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="col-xs-12 text-center">
                                <?php echo $this->Html->link('Change Password', array('plugin' => 'GintonicCMS', 'controller' => 'users', 'action' => 'changePassword')); ?>
                            </div>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <?php echo $this->Html->link('Profile', array('plugin' => 'GintonicCMS', 'controller' => 'users', 'action' => 'view', $this->request->session()->read('Auth.User.id')), array('class' => 'btn btn-default btn-flat')); ?>
                            </div>
                            <div class="pull-right">
                                <?php echo $this->Html->link('Sign out', array('plugin' => 'GintonicCMS', 'controller' => 'users', 'action' => 'signout'), array('class' => 'btn btn-default btn-flat')) ?>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
