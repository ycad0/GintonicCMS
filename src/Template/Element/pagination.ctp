<?php if ($this->Paginator->hasPage()) { ?>
    <ul class="pagination pagination-sm no-margin pull-right">
        <?php
        echo $this->Paginator->prev('&laquo; Previous', array('escape'=>false,'tag'=>'li'), null, array('escape'=>false,'tag'=>'li','disabledTag'=>'a'));
        echo $this->Paginator->numbers(array('separator' => '','tag'=>'li','currentTag'=>'a','currentClass'=>'active'));
        echo $this->Paginator->next('Next &raquo;', array('escape'=>false,'tag'=>'li'), null, array('escape'=>false,'tag'=>'li','disabledTag'=>'a'));
        ?>
    </ul>
<?php } ?>