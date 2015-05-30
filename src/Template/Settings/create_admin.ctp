<div class="container">
    <div class="row">
        <?php
        if (!$tableExists):
            ?>
            <p class="alert alert-danger" style="margin-top: 40px;">
                It seems that you haven't run Migration yet. Please Run Migration First. 
            </p>
            <?php
            echo $this->Html->link('Continue', '/', ['class' => 'btn btn-default']);
        else:
            if (isset($success) && $success):

                ?>
                <p class="alert alert-success" style="margin-top: 40px;">
                    All right. Admin account has been created.
                </p>
                <?php
                echo $this->Html->link('Continue', '/', ['class' => 'btn btn-default']);
            else:
                if ($recordExists):

                    ?>
                    <p class="alert alert-warning" style="margin-top: 40px;">
                        One admin account is already setup.
                    </p>
                    <?php
                    echo $this->Html->link('Continue', '/', ['class' => 'btn btn-default']);
                else:

                    ?>
                    <h2><?php echo __('Create Admin Account.'); ?></h2>
                    <?php
                    echo $this->Form->create('createAdmin');
                    echo $this->Form->input('id', ['type' => 'hidden']);
                    echo $this->Form->input('first', ['label' => 'First Name']);
                    echo $this->Form->input('last', ['label' => 'Last Name']);
                    echo $this->Form->input('email');
                    echo $this->Form->input('password');
                    echo $this->Form->submit('Create', ['class' => 'btn btn-default']);
                    echo $this->Form->end();
                endif;
            endif;
        endif;

        ?>
    </div>
</div>