<?php

if(!empty($album)):
    foreach ($album as $key => $image): ?>
       <div class="col-md-3" style="margin-top: 10px">
            <?php echo $this->Html->image($this->Custom->getFileUrl($image->file->filename, ''), array('class' => 'img-responsive img-thumbnail', 'id' => 'userphoto', 'style' => 'height:150px;width:255px;'));?>
            <?php if ($userId == $loggedInUserId): ?>
            <i id="<?php echo $image->id?>" class="fa fa-times" style="background: #fff;padding: 2px 5px 3px;position: absolute;right: 25px;top: 5px;cursor: pointer;" data-delete-image data-fileid="<?php echo $image->file->id?>" data-filename="<?php echo $image->file->filename?>"></i>
            <?php endif;?>
        </div>        
    <?php endforeach;
endif;
?>