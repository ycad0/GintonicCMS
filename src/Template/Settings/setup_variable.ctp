<div class="container">
    <div class="row">
        <?php
        if (isset($status)):
            $class = 'alert alert-danger';
            $message = __('Unable to write variables. Please try again.');
            if (!empty($status)):
                $class = 'alert alert-success';
                $message = __('Variable has been written successfully.');
            endif;
            ?>
            <p class="<?php echo $class ?>" style="margin-top: 40px;"><?php echo $message ?></p>
            <?php
            echo $this->Html->link('Continue', '/', ['class' => 'btn btn-default']);
        else:
            ?>
            <h2>Configure CMS Variable</h2>
            <?php
            echo $this->Form->create('setpVariable');
            echo $this->Form->input('email', ['label' => 'Admin Email']);
            echo $this->Form->submit('Submit', ['class' => 'btn btn-default']);
            echo $this->Form->end();
        endif;
        ?>
    </div>
</div>