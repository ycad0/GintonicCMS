<?php
$this->Helpers()->load('GintonicCMS.Require');
echo $this->Require->req('files/filepicker');
echo $this->Require->req('Albums/image_gallery');
?>
<?php if ($userId == $loggedInUserId): ?>
    <div class="row">
        <div class="col-md-12">
            <input id="user-id" type="hidden" value="<?php echo $userId ?>" />
            <input id="logged-in-user-id" type="hidden" value="<?php echo $loggedInUserId ?>" />
            <div id="contact-alert"></div>

            <div id = "upload-alert"></div>
            <div id="modal-loader"></div>
            <button type="button" class="btn btn-primary upload pull-right" data-loading-text="Loading..." data-upload-callback="albums/uploadPhotos">Upload Image</button>
        </div>
    </div>

<?php endif; ?>
<div class="row" data-photogalery>
    <?php echo $this->element('GintonicCMS.Albums/photo_galery', ['album' => $album, 'userId' => $userId, 'loggedInUserId' => $loggedInUserId]); ?>
</div>
