<?php use Cake\Core\Configure; ?>
<div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <?php echo $this->Html->link(
                $this->Html->image(
                    Configure::read('site_logo_url'),
                    [
                        "class" => "img-responsive profile-img navbar-img",
                        "alt" => Configure::read('site_name')
                    ]
                ),
                '/',
                ['escape'=>false,'class'=>['navbar-brand']]
            );?>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#user-menu">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="user-menu">
            <?php if($this->request->session()->check('Auth.User')): ?>
            <ul class="nav navbar-nav">
                <li>
                    <?php echo $this->Html->link(
                        __('Dashboard'),
                        ['plugin'=>'GintonicCMS','controller' => 'Users', 'action' => 'profile'],
                        ['escape' => false]
                    );?>
                </li>
                <li>
                    <?php echo $this->Html->link(
                        __('Manage Files'),
                        ['plugin'=>'GintonicCMS','controller' => 'files', 'action' => 'index'],
                        ['escape' => false]
                    ); ?>
                </li>
            </ul>
            <?php endif; ?>
            <ul class="nav navbar-nav navbar-right">
                <?php if($this->request->session()->check('Auth.User')): ?>
                <li class="dropdown">
                    <?php echo $this->Html->link(
                        ($this->request->session()->read('Auth.User.first').' '.$this->request->session()->read('Auth.User.last')).'<span class="caret"></span>',
                        '#',
                        [
                            'escape'=>false,
                            'class'=>'dropdown-toggle',
                            'data-toggle'=>'dropdown',
                            'role'=>'button',
                            'aria-expanded'=>false
                        ]
                    ); ?>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <?php if($this->request->session()->read('Auth.User.role') == 'admin'): ?>
                                <?php echo $this->Html->link(
                                    __('Administration'),
                                    [
                                        'plugin'=>'GintonicCMS',
                                        'controller'=>'Users',
                                        'action' => 'change_layout',
                                        'admin'
                                    ],
                                    ['escape' => false]
                                );?>
                            <?php endif; ?>
                        </li>
                        <li>
                            <?php echo $this->Html->link(
                                __('Profile'),
                                [
                                    'plugin'=>'GintonicCMS',
                                    'controller'=>'Users',
                                    'action'=>'edit',
                                    $this->request->session()->read('Auth.User.id')
                                ],
                                ['escape'=>false]
                            ); ?>
                        </li>
                        <?php echo $this->fetch('topMenuActions'); ?>
                        <li>
                            <?php echo $this->Html->link(
                                __('Signout'),
                                [
                                    'plugin'=>'GintonicCMS',
                                    'controller'=>'Users',
                                    'action'=>'signout'
                                ],
                                ['escape'=>false]
                            ); ?>
                        </li>
                    </ul>
                </li>
                <?php else: ?>
                    <li>
                        <a href="/signin">Sign in</a>
                    </li>
                    <li>
                        <a href="/signup">Sign up</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
