<?php if(empty($from)): ?>    
    <div class="text-left pagination-info <?php echo isset($pagiDisplayStyles)?$pagiDisplayStyles:'';?>">
        <?php echo $this->Paginator->counter(
            'Displaying {{start}} - {{end}} of {{count}} total'
        );?>
    </div>
<?php endif; ?>
