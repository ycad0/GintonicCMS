<?php
    foreach ($files as $key => $file) {
            echo $this->element('GintonicCMS.filelist',array('file'=>$file));
    }
?>
