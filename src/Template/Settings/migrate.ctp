<div class="container">
    <div class="row">
        <?php
        $class = 'alert alert-danger';
        $message = __('Error while performing Migration.');
        if($resultCode == 0): 
            $class = 'alert alert-success';
            $message = __('Migration successful.');
        endif;
        ?>
        <p class="<?php echo $class?>" style="margin-top: 40px;"><?php echo $message?></p>
        <?php echo $this->Html->link('Continue', '/', ['class' => 'btn btn-default']);?>
    </div>
</div>