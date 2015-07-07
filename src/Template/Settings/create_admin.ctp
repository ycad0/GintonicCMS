<div class="container">
    <div class="row">
        <h2><?php echo __('Create Admin Account.'); ?></h2>
        <?= $this->Form->create('createAdmin'); ?>
        <?= $this->Form->input('id', ['type' => 'hidden']); ?>
        <?= $this->Form->input('first', ['label' => 'First Name']); ?>
        <?= $this->Form->input('last', ['label' => 'Last Name']); ?>
        <?= $this->Form->input('email'); ?>
        <?= $this->Form->input('password'); ?>
        <?= $this->Form->submit('Create', ['class' => 'btn btn-default']); ?>
        <?= $this->Form->end(); ?>
    </div>
</div>
