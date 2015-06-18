<div class="container">
    <div class="row">
        <h1>Preferences</h1>
        <?= $this->Form->create($user) ?>
        <?= $this->Form->input('email', ['label' => 'Email']) ?>
        <?= $this->Form->input('pwd', [
            'label' => 'Password',
            'type' => 'password',
            'default' => 'dummy'
        ]) ?>
        <?= $this->Form->input('first', ['label' => 'First Name']) ?>
        <?= $this->Form->input('last', ['label' => 'Last Name']) ?>
        <?= $this->Form->submit('Save', [
            'div' => false,
            'class' => 'btn btn-primary'
        ]) ?>
    </div>
</div>
<?= $this->Form->end() ?>
