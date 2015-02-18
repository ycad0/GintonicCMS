<?php
	foreach ($files as $key => $file) {
		echo $this->element('filelist',array('file'=>$file));
	}
?>
