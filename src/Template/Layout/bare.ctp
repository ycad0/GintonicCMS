<!DOCTYPE html>
<html lang="en">
    <head>
        <?php echo $this->Html->charset() ?>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <?php echo $this->Html->meta('icon') ?>

        <title>
            <?php echo $this->fetch('title') ?>
        </title>

        <?php echo $this->Html->css('GintonicCMS.bare') ?>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>

        <div class="container">
            <?php echo $this->Flash->render(); ?>
            <?php echo $this->fetch('content'); ?>	                    
        </div>

        <?php echo $this->Require->req('jquery');?>
        <?php echo $this->Require->req('bootstrap');?>
        <?php echo $this->Require->load('GintonicCMS.config'); ?>

    </body>
</html>




