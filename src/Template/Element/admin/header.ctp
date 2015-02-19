<?php 
use Cake\Core\Configure;
?>
<header class="header">
    <?php echo $this->Html->link($this->Html->image(Configure::read('Gtw.site_logo_url'),['alt'=>Configure::read('Gtw.site_name')]), ['controller' => 'admins', 'action' => 'index'], ['escape' => false, 'class' => 'logo']) ?>
    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <div class="navbar-right">
            <ul class="nav navbar-nav">					
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-user"></i>
                        <span><?php echo $this->Session->read('Auth.User.first') . ' ' . $this->Session->read('Auth.User.last') ?> <i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header bg-danger">
                            <?php echo $this->Html->image('GintonicCMS.admin/avtar3.png', array('class' => 'img-circle')) ?>
                            <p>
                                <?php echo $this->Session->read('Auth.User.first') . ' ' . $this->Session->read('Auth.User.last');?>
<!--                                <small>
                                    Last login <?php echo str_replace('k','sup',date('d<k>S</k> M, Y', strtotime($this->Session->read('Auth.User.last_login_time')))); ?>
                                </small>-->
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="col-xs-12 text-center">
                                <?php echo $this->Html->link('Change Password',array('controller'=>'users','action'=>'change_password'));?>
                            </div>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <?php echo $this->Html->link('Profile',array('controller'=>'users','action'=>'view',$this->Session->read('Auth.User.id')),array('class'=>'btn btn-default btn-flat'));?>
                            </div>
                            <div class="pull-right">
                                <?php echo $this->Html->link('Sign out', array('controller' => 'users', 'action' => 'signout'), array('class' => 'btn btn-default btn-flat')) ?>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>