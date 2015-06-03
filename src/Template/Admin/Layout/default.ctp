<!DOCTYPE html>
<html>
  <head>
    <?= $this->Html->charset() ?>
    <title><?= $this->fetch('title') ?></title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->fetch('meta') ?>
    <?= $this->Html->css('GintonicCMS.admin') ?>

    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="skin-blue sidebar-mini">
    <div class="wrapper">

      <?= $this->element('navbar') ?>
      <?= $this->element('sidebar') ?>
      <div class="content-wrapper">
        <?= $this->element('heading') ?>
        <section class="content">
            <?= $this->element('demo') ?>
        </section>
      </div>
      <?= $this->element('footer') ?>
      <?= $this->element('rightbar') ?>
    </div>

    <?= $this->Require->req('lib/fastclick/fastclick'); ?>
    <?= $this->Require->req('lib/admin-lte/app'); ?>
    <?= $this->Require->req('lib/sparkline/jquery.sparkline'); ?>
    <?= $this->Require->req('lib/jvectormap/jquery-jvectormap-1.2.2.min'); ?>
    <?= $this->Require->req('lib/jvectormap/jquery-jvectormap-world-mill-en'); ?>
    <?= $this->Require->req('lib/slimScroll/jquery.slimscroll'); ?>
    <?= $this->Require->req('lib/chartjs/Chart.min'); ?>
    <?= $this->Require->req('lib/admin-lte/pages/dashboard2'); ?>
    <?= $this->Require->req('lib/admin-lte/demo'); ?>
    <?= $this->Require->req('jquery'); ?>
    <?= $this->Require->req('bootstrap'); ?>
    <?= $this->Require->load('GintonicCMS.config'); ?>
  </body>
</html>
