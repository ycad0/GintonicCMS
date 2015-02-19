<script language="javascript" type="text/javascript">
    <?php if($totalFiles == 1) :?>
    window.top.window.uploadComplete(
         <?php echo $fileId; ?>,
        "<?php echo $fileName; ?>",
        "<?php echo $callbackModule; ?>"
    );
    <?php else : ?>
    window.top.window.uploadComplete(
        "<?php echo $commaSepratedFileId; ?>",
        "<?php echo $commaSepratedFileName; ?>",
        "<?php echo $callbackModule; ?>"
    );    
    <?php endif; ?>
</script>
