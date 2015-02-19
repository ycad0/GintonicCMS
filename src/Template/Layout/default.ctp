<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            <?php echo $this->fetch('title') ?>
        </title>
        <?php echo $this->Html->meta('icon') ?>
        <?php echo $this->Html->css('site') ?>
        <?php echo $this->fetch('meta') ?>
        <?php echo $this->fetch('css') ?>
        <?php echo $this->fetch('script') ?>
    </head>
    <body>
        <?php echo $this->element('user/header')?>
        <div class="wrapper row-offcanvas ">
            <section class="content">
                <section class="content-header">
                    <div class="top-links" style="float: right;margin-bottom: 10px">
                        <?php echo $this->fetch('top_links'); ?>
                    </div>
                </section>
                <?php echo $this->Flash->render(); ?>
                <?php echo $this->fetch('content'); ?>	                    
            </section>
        </div>
        <?php echo $this->GtwRequire->req('jquery');?>
        <?php echo $this->GtwRequire->req('bootstrap');?>
        <?php echo $this->GtwRequire->load($this->Url->build('/',TRUE).'gintonic_c_m_s/js/config'); ?>
    </body>
</html>
