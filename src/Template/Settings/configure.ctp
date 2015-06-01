<div class="container">
    <div class="row">
        <h1>GintonicCMS Configuration</h1>
        <?= $this->Form->create('configure') ?>
        <?= $this->Form->input('email', [
            'label' => 'Admin Email'
        ]) ?>
        <?= $this->Form->submit('Submit', [
            'class' => 'btn btn-default'
        ]) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
