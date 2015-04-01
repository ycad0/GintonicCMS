<div class='col-md-6 pagination-body no-padding  ' style="<?php echo (empty($pagination)?'':$pagination)?>">
    <?php if(empty($from)): ?>    
    <div class="text-left pagination-info <?php echo isset($pagiDisplayStyles)?$pagiDisplayStyles:'';?>">
        <?php echo $this->Paginator->counter('Displaying {{start}} - {{end}} of {{count}} total'); ?>
    </div>
    <?php endif; ?>
</div>
