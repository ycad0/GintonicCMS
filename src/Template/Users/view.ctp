<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1><?= $user->full_name ?></h1>
            <address>
                <?= $this->Html->link(
                    $user->email,
                    'mailto:'.$user->email,['escape'=>false]
                ) ?>
            </address>
        </div>
    </div>
</div>
