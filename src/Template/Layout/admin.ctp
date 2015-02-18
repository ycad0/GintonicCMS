<?php
$cakeDescription = 'GintonicCMS';
?>
<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            <?php echo $cakeDescription ?>:
            <?php echo $this->fetch('title') ?>
        </title>
        <?php echo $this->Html->meta('icon') ?>
        <?php echo $this->Html->css('GintonicCMS.site.css') ?>        
        
        <?php 
        //echo $this->Html->script('http://code.jquery.com/jquery.min.js');
        //echo $this->Html->script('https://code.jquery.com/ui/1.11.2/jquery-ui.min.js');
        //echo $this->GtwRequire->load('/js/config');
        //echo $this->GtwRequire->req('jquery');
        /*echo $this->GtwRequire->req('bootstrap');
        echo $this->GtwRequire->req('files/default');
        echo $this->GtwRequire->req('files/feedback');
        echo $this->GtwRequire->req('files/filepicker');
        echo $this->GtwRequire->req('files/index');
        echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/wysihtml5/0.3.0/wysihtml5.min.js'); */
        ?>
        <?php //echo $this->Html->script('//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js'); ?>
        <?php echo $this->fetch('meta') ?>
        <?php echo $this->fetch('css') ?>
        <?php echo $this->fetch('script') ?>
    </head>
    <body class="wysihtml5-supported  pace-done fixed skin-blue">
        <?php echo $this->element('admin/header')?>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <?php echo $this->element('admin/left')?>
            <aside class="right-side">
                <section class="content-header">
                    <h1 style="float: left"><?php echo $this->fetch('pagetitle');?></h1>
                    <div class="top-links" style="float: right">
                        <?php echo $this->fetch('top_links'); ?>                        
                    </div>
                    <div class="clearfix"></div>
                </section>
                <ul class="breadcrumb">
                    <li class="first">
                        <?php
                        echo $this->Html->getCrumbs(' / ', [
                            'text' => '<i class="fa fa-dashboard">&nbsp;</i> Home',
                            'url' => ['controller' => 'users', 'action' => 'profile'],
                            'escape' => false
                        ]);
                        ?>
                    </li>
                </ul>
                <section class="content content-breadcrumb">
                    <?php echo $this->Flash->render() ?>
                    <?php echo $this->fetch('content'); ?>	                    
                </section>
            </aside>
        </div>
    </body>
    <?php echo $this->GtwRequire->req('jquery');?>
    <?php echo $this->GtwRequire->req('bootstrap');?>
    <?php echo $this->GtwRequire->load($this->Url->build('/',TRUE).'gintonic_c_m_s/js/config'); ?>
    <?php echo $this->GtwRequire->req('admin/app');?>
    <?php echo $this->GtwRequire->req('admin/dashboard');?>
</html>
