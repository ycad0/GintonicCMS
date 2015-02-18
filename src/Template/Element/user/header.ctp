<!--<header>
    <div class="header-title">
        <span><?= $this->fetch('title') ?></span>
    </div>
    <div class="header-help">
        <?= $this->Html->media('test.mp3') ?>
        <?php
            $controller = strtolower($this->request->params['controller']);
            $action = strtolower($this->request->params['action']);
            if($controller == 'users' && $action != 'register'){
                echo $this->Html->link('Register', ['controller' => 'users', 'action' => 'register'], ['class' => 'button']); 
            }
            if($controller == 'users' && $action != 'login'){
                echo $this->Html->link('Login', ['controller' => 'users', 'action' => 'login'], ['class' => 'button']); 
            }
            echo $this->Html->link('About', '#', ['class' => 'button']);
        ?>
    </div>
</header>-->