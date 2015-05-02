<?php
$this->assign('pagetitle', __('Edit user') . '<small>' . __('User Management') . '</small>');
$this->Html->addCrumb(__('User Management'), ['controller' => 'users', 'action' => 'admin_index']);
$this->Html->addCrumb(__('Edit user'));

$this->Helpers()->load('GintonicCMS.Require');
echo $this->Require->req('users/reset_password');
echo $this->Require->req('files/filepicker');
?>


<?php echo $this->Form->create($user, [
    'templates' => [
        'inputContainer' => '<div class="form-group">{{content}}</div>',
        'input' => '<input type="{{type}}" class="form-control" name="{{name}}"{{attrs}}>'
    ]
]); ?>
<input id="user-id" type="hidden" value="<?php echo $user->id ?>" />
<div class="row">
    <div class="col-md-12">
        <h1><?php echo $user->first . ' ' . $user->last ?></h1>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div id = "upload-alert"></div>
        <div id="modal-loader"></div>
        <?= $this->Html->image(
            $user['file']['filename'], 
            ['class' => 'img-responsive img-thumbnail', 'id' => 'userphoto']
        ); ?>
        <button type="button" class="btn btn-default upload" data-loading-text="Loading..." data-upload-callback="users/update_avatar">Change Avatar</button>
    </div>
    <div class="col-md-8">
        <fieldset>
            <?php 
            echo $this->Form->input('email', array('label' => 'Email'));
            echo $this->Form->input('password', array('label' => 'Password','type' => 'hidden'));
            ?>
            <div class="form-group">
                <label for="decoy-password">Password</label>
                <input type="password" name="decoy-password" class="form-control" value="DefaultPassword" id="decoy-password">
            </div>
            <?php echo $this->Form->input('first', array('label' => 'First Name')); ?>
            <?php echo $this->Form->input('last', array('label' => 'Last Name')); ?>
            <?php echo $this->Form->submit('Save', [
                'div' => false,
                'class' => 'btn btn-primary'
            ]); ?>
        </fieldset>
    </div>
</div>

<?php echo $this->Form->end(); ?>
