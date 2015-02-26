<?php 
if ($this->Paginator->hasPage()) {
    echo $this->Paginator->pagination(['ul'=>'pagination pagination-sm no-margin pull-right']);
}
?>