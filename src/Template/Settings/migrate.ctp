<div class="container">
    <div class="row">
        <?php
        if ($missingConnection):
            ?>
            <p class="alert alert-danger" style="margin-top: 40px;">
                It seems that you haven't Configure database yet. Please Configure Database first.
            </p>
            <?php
            echo $this->Html->link('Continue', '/', ['class' => 'btn btn-default']);
        else:
            $class = 'alert alert-danger';
            $message = __('Error while performing Migration.');
            if ($resultCode == 0):
                $class = 'alert alert-success';
                $message = __('Migration successful.');
            endif;

            ?>
            <p class="<?php echo $class ?>" style="margin-top: 40px;"><?php echo $message ?></p>
            <?php
            echo $this->Html->link('Continue', '/', ['class' => 'btn btn-default']);
        endif;
        ?>
    </div>
</div>