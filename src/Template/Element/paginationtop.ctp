<div class='row pagination-body ' style="<?php echo (empty($pagination)?'':$pagination)?>">
    <?php if(empty($from)): ?>    
    <div class="col-md-6 text-left pagination-info <?php echo isset($pagiDisplayStyles)?$pagiDisplayStyles:'';?>">
        <?php echo $this->Paginator->counter('Displaying {{start}} - {{end}} of {{count}} total'); ?>
    </div>
    <?php endif; ?>
</div>
