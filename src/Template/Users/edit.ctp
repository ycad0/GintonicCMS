<div class="container">
    <div class="row">
        <h1>Preferences</h1>
        <?php echo $this->Form->create($user); ?>
        <?= $this->Form->input('email', array('label' => 'Email')); ?>
        <?= $this->Form->input('password', array('label' => 'Password')); ?>
        <?= $this->Form->input('first', array('label' => 'First Name')); ?>
        <?= $this->Form->input('last', array('label' => 'Last Name')); ?>
        <?php echo $this->Form->submit('Save', [
            'div' => false,
            'class' => 'btn btn-primary'
        ]); ?>
    </div>
</div>
<?php echo $this->Form->end(); ?>
