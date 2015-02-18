<div class='row pagination-body' style="<?php echo (empty($pagination)?'':$pagination)?>">
    <?php if(empty($from)){ ?>    
    <div class="col-md-6 text-left pagination-info">
        <?php echo $this->Paginator->counter('Displaying {{start}} - {{end}} of {{count}} total'); ?>
    </div>
    <?php }?>
<!--    <div class="col-md-6 text-right pagination-info">
        <?php
        echo __("Page Size: ");
        $results = array();
        foreach ((array) $paginationOptions as $option) {
            if ($paginationLimit == $option) {
                $results[] = $option;
            } else {
                $args = $this->passedArgs;
                $args['Paginate'] = $option;
                $results[] = $this->Html->link($option, $args);
            }
        }
        echo implode(" | ", $results);
        ?>
    </div>-->
</div>
