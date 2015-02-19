<aside class="left-side sidebar-offcanvas">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <?php
                echo $this->Html->image('GintonicCMS.admin/avtar3.png',['class' => 'img-circle']);
                ?>
            </div>
            <div class="pull-left info">
                <p>
                    <?php echo $this->Html->link($this->Session->read('Auth.User.first') . ' ' . $this->Session->read('Auth.User.last'),['controller'=>'users','action'=>'profile']);?>
                </p>
                <span title="<?php echo $this->Session->read('Auth.User.email');?>"><?php echo $this->Session->read('Auth.User.email');?></span>
            </div>
        </div>        
        <ul class="sidebar-menu">
            <li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i> <span> ' . __('My Profile') . '</span>', ['controller' => 'users', 'action' => 'profile'], ['escape' => false]) ?></li>
            <li><?php echo $this->Html->link('<i class="fa fa-user"></i> <span> ' . __('User Management') . '</span>', ['controller' => 'users', 'action' => 'index'], ['escape' => false]) ?></li>
            <li><?php echo $this->Html->link('<i class="fa fa-file"></i> <span> ' . __('File Management') . '</span>', ['controller' => 'files', 'action' => 'index'], ['escape' => false]) ?></li>
        </ul>
    </section>
</aside>
