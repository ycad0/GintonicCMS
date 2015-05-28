<div class="container">
    <div class="row">
        <?php
        $class = 'alert alert-danger';
        $message = __('Unable to write variables. Please try again.');
        if(!empty($status)): 
            $class = 'alert alert-success';
            $message = __('Variable has been written successfully.');
        endif;
        ?>
        <p class="<?php echo $class?>" style="margin-top: 40px;"><?php echo $message?></p>
        <?php echo $this->Html->link('Continue', '/', ['class' => 'btn btn-default']);?>
    </div>
</div>