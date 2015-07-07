<!DOCTYPE html>
<html lang="en">
    <head>
        <?= $this->Html->charset() ?>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <?= $this->Html->meta('icon') ?>

        <title>
            <?= $this->fetch('title') ?>
        </title>

        <?php echo $this->Html->css('TwbsTheme.bare') ?>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>

        <div class="container">
            <?= $this->Flash->render(); ?>
            <?= $this->fetch('content'); ?>	                    
        </div>

        <?= $this->Require->req('jquery');?>
        <?= $this->Require->req('bootstrap');?>
        <?= $this->Require->load(); ?>

    </body>
</html>




