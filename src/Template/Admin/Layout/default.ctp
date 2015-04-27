<!DOCTYPE html>
<html>
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $this->fetch('title') ?></title>
        <?= $this->Html->meta('icon') ?>
        <?= $this->Html->css('GintonicCMS.admin.css') ?>
        
        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css') ?>
        <?= $this->fetch('script') ?>
    </head>
    <body class="wysihtml5-supported  pace-done skin-blue">
        <?= $this->element('GintonicCMS.header')?>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <?= $this->element('GintonicCMS.left')?>
            <aside class="right-side">
                <section class="content-header">
                    <h1 style="float: left"><?= $this->fetch('pagetitle');?></h1>
                    <div class="top-links" style="float: right">
                        <?= $this->fetch('top_links'); ?>
                    </div>
                    <div class="clearfix"></div>
                </section>
                <ul class="breadcrumb">
                    <li class="first">
                        <?= $this->Html->getCrumbs(' / ', [
                            'text' => '<i class="fa fa-dashboard">&nbsp;</i> Home',
                            'url' => ['plugin'=>'GintonicCMS','controller' => 'users', 'action' => 'profile'],
                            'escape' => false
                        ]); ?>
                    </li>
                </ul>
                <section class="content content-breadcrumb">
                    <?= $this->Flash->render();?>
                    <?= $this->fetch('content'); ?>	                    
                </section>
            </aside>
        </div>
        <?= $this->Require->req('jquery'); ?>
        <?= $this->Require->req('bootstrap'); ?>
        <?= $this->Require->load($this->Url->build('/',TRUE).'gintonic_c_m_s/js/config'); ?>
    </body>
</html>
