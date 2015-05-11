<?php
    foreach ($files as $key => $file) {
            echo $this->element('GintonicCMS.Files/filelist',array('file'=>$file));
    }
?>
