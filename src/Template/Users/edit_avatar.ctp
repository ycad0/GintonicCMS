<?php 
    $this->Helpers->load('GtwRequire.GtwRequire');
    echo $this->GtwRequire->req('users/reset_password');
    echo $this->GtwRequire->req('files/filepicker');
    CakePlugin::loaded('GtwFiles');
?>

<?php 
    echo $this->Form->create('User', array(
        'inputDefaults' => array(
            'div' => 'form-group',
            'wrapInput' => false,
            'class' => 'form-control'
        ),
    ));
?>
<input id="user-id" type="hidden" value="<?php echo $this->request->data['User']['id'] ?>" />
<div class="row">
    <div class="col-md-12">
        <h1><?php echo $this->request->data['User']['first'].' '.$this->request->data['User']['last']?></h1>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div id = "upload-alert"></div>
        <div id="modal-loader"></div>
        <?php 
			if(!empty($avatar)){
				echo $this->Html->image('/'.$avatar,array('class'=>'img-responsive img-thumbnail','id'=>'gtwuserphoto'));
			}else{
				echo $this->Html->image('http://i.imgur.com/dCVa3ik.jpg',array('class'=>'img-responsive img-thumbnail','id'=>'gtwuserphoto'));
			}
		?>
        <button type="button" class="btn btn-default upload" data-loading-text="Loading..." data-upload-callback="users/update_avatar">Change Avatar</button>
    </div>
    <div class="col-md-8">
        <fieldset>
            <?php echo $this->Form->input('email', array(
                'label' => 'Email',
            )); ?>
            <?php echo $this->Form->input('password', array(
                'label' => 'Password',
                'type' => 'hidden'
            )); ?>
            <div class="form-group">
                <label for="decoy-password">Password</label>
                <input type="password" name="decoy-password" class="form-control" value="DefaultPassword" id="decoy-password">
            </div>
            <?php echo $this->Form->input('first', array(
                'label' => 'First Name',
            )); ?>
            <?php echo $this->Form->input('last', array(
                'label' => 'Last Name',
            )); ?>
            <?php echo $this->Form->submit('Save', array(
                'div' => false,
                'class' => 'btn btn-primary'
            )); ?>
        </fieldset>
    </div>
</div>

<?php echo $this->Form->end(); ?>