<?php

if(!empty($album)):
    foreach ($album as $key => $image): ?>
       <div class="col-md-3" style="margin-top: 10px">
            <?= $this->Html->image(
                '/files/uploads/'.$image->file->filename,
                ['class' => 'img-responsive img-thumbnail', 'id' => 'userphoto']
            );?>
            <?php if ($userId == $loggedInUserId): ?>
            <i id="<?php echo $image->id?>" class="fa fa-times delete-link" data-delete-image data-fileid="<?php echo $image->file->id?>" data-filename="<?php echo $image->file->filename?>"></i>
            <?php endif;?>
        </div>        
    <?php endforeach;
endif;
?>
