<?php
$this->Helpers()->load('GintonicCMS.Require');
echo $this->Require->req('files/filepicker');
echo $this->Require->req('Albums/image_galery');
?>
<?php if ($userId == $loggedInUserId): ?>
    <div class="col-md-12">
        <input id="user-id" type="hidden" value="<?php echo $userId ?>" />
        <input id="logged-in-user-id" type="hidden" value="<?php echo $loggedInUserId ?>" />
        <div id="contact-alert"></div>
        <div class="col-md-12">
            <div id = "upload-alert"></div>
            <div id="modal-loader"></div>
            <button type="button" class="btn btn-default upload pull-right" data-loading-text="Loading..." data-upload-callback="Albums/upload_photos">Upload Image</button>
        </div>
    </div>
<?php endif; ?>
<div class="col-md-12 nopadding" data-photogalery>
    <?php echo $this->element('GintonicCMS.Albums/photo_galery', ['album' => $album, 'userId' => $userId, 'loggedInUserId' => $loggedInUserId]); ?>
</div>
