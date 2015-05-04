<?php

use Cake\Core\Configure;
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>
                <?php
                echo __($title);
                echo $this->Html->link('<i class="fa fa-reply"></i> Back', $backUrl, array('escape' => false, 'class' => 'btn btn-primary pull-right'));
                ?>
            </h1>
            <table class="table table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th width='5%'>Sr. No.</th>
                        <?php if ($all) { ?>
                            <th width='8%'><?= $this->Paginator->sort('plan_id', 'Plan Name'); ?></th>
                        <?php } ?>
                        <th width='<?= ($all) ? '22%' : '26%' ?>'><?php echo $this->Paginator->sort('plan_name', 'Plan Description'); ?></th>
                        <th width='<?= ($all) ? '22%' : '26%' ?>'><?php echo $this->Paginator->sort('transaction_id', 'Transaction Id'); ?></th>
                        <th width='7%'><?= $this->Paginator->sort('amount'); ?></th>
                        <th width='10%'><?= $this->Paginator->sort('brand', 'Pay Using'); ?></th>
                        <th width='13%'><?= $this->Paginator->sort('created', 'Date Added'); ?></th>
                        <th width='13%'><?= $this->Paginator->sort('modified', 'Date Updated'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($transactions)) { ?>
                        <tr>
                            <td colspan='<?= ($all) ? '8' : '7' ?>' class='text-warning'><?= __('No transactions found.') ?></td>
                        </tr>
                        <?php
                    } else {
                        $srNo = 1;
                        foreach ($transactions as $key => $transaction) {
                            ?>
                            <tr>
                                <td><?php echo $srNo++; ?></td>
                                <?php if ($all) { ?>
                                    <td><?php echo $transaction['plan_id']; ?></td>
                                <?php } ?>
                                <td><?= $transaction['plan_name']; ?></td>
                                <td><?= $transaction['transaction_id']; ?></td>
                                <td><?= Configure::read('Stripe.currency') . ' ' . $transaction['amount']; ?></td>
                                <td><?= $transaction['brand']; ?></td>
                                <td><?= $transaction['created']; ?></td>
                                <td><?= $transaction['modified']; ?></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>	
        </div>
    </div>
</div>