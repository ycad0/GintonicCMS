<?php use Cake\Core\Configure; ?>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <?php
            echo $this->Html->link($this->Html->image(Configure::read('Gtw.site_logo_url'), ["class" => "img-responsive profile-img", "alt" => Configure::read('Gtw.site_name')]),['controller'=>'users','action'=>'profile'],['escape'=>false,'class'=>['navbar-brand']]);
            ?>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <?php if($this->Session->check('Auth.User')): ?>
            <ul class="nav navbar-nav">
                <li class="<?php echo $this->Custom->getActiveClass('Users',['profile']) ?>">
                    <?php echo $this->Html->link(__('Dashboard'), ['controller' => 'users', 'action' => 'profile'], ['escape' => false]); ?>
                </li>
                <li class="<?php echo $this->Custom->getActiveClass('Files',['index']) ?>">
                    <?php echo $this->Html->link(__('Manage Files'), ['plugin'=>'GintonicCMS','controller' => 'files', 'action' => 'index'], ['escape' => false]); ?>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <?php echo $this->Html->link(($this->Session->read('Auth.User.first') . ' ' . $this->Session->read('Auth.User.last')) . '<span class="caret"></span>','#',['escape'=>false,'class'=>'dropdown-toggle','data-toggle'=>'dropdown','role'=>'button','aria-expanded'=>false]); ?>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <?php echo $this->Html->link(__('Profile'),['plugin'=>'GintonicCMS','controller'=>'users','action'=>'edit',$this->Session->read('Auth.User.id')],['escape'=>false]); ?>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <?php echo $this->Html->link(__('Signout'),['plugin'=>'GintonicCMS','controller'=>'users','action'=>'signout'],['escape'=>false]); ?>
                        </li>
                    </ul>
                </li>
            </ul>
            <?php else : ?>
            <ul class="nav navbar-nav navbar-right">
                <li class="<?php echo $this->Custom->getActiveClass('users',['signin']) ?>">
                    <?php echo $this->Html->link(__('signin'), ['plugin'=>'GintonicCMS','controller' => 'users', 'action' => 'signin'], ['escape' => false]); ?>
                </li>
                <li class="<?php echo $this->Custom->getActiveClass('users',['signup']) ?>">
                    <?php echo $this->Html->link(__('Signup'), ['plugin'=>'GintonicCMS','controller' => 'users', 'action' => 'signup'], ['escape' => false]); ?>
                </li>
            </ul>
            <?php endif; ?>
        </div>
    </div>
</nav>
