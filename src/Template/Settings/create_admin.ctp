<div class="container">
    <div class="row">
        <?php if (isset($success)) : ?>
            <p class="alert alert-success" style="margin-top: 40px;">
                All right. Admin account has been created.
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

            ?>
        <?php
        endif;

        ?>
    </div>
</div>