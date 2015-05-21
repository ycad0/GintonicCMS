<?php
use Cake\I18n\Time;
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>
                <?= __('Transaction'); ?>
                <?php //echo $this->Html->link('Donate', [''], ['class' => 'btn btn-primary pull-right']);?>
            </h1>
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th width='5%'><?php echo $this->Paginator->sort('id'); ?></th>
                            <th width='10%'><?php echo $this->Paginator->sort('Users.first', 'User'); ?></th>
                            <th width='10%'><?php echo $this->Paginator->sort('transaction_type_id', 'Transaction Type'); ?></th>
                            <th width='10%'><?php echo $this->Paginator->sort('transaction_id', 'Transaction Id'); ?></th>
                            <th width='10%'><?php echo $this->Paginator->sort('amount'); ?></th>
                            <th width='10%'><?php echo $this->Paginator->sort('brand', 'Pay Using'); ?></th>
                            <th width='10%'><?php echo $this->Paginator->sort('created', 'Date Added'); ?></th>
                            <th width='10%'><?php echo $this->Paginator->sort('modified', 'Date Updated'); ?></th>
                            <th width='10%' class='text-center'>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($transactions)) { ?>
                            <tr>
                                <td colspan='<?php echo $colCount; ?>' class='text-warning'><?php echo __('No record found.') ?></td>
                            </tr>
                            <?php
                        } else {
                            foreach ($transactions as $transaction) {
                                ?>
                                <tr>
                                    <td><?php echo $transaction['id'] ?></td>
                                    <td><?php echo $transaction['user']['first'] . ' ' . $transaction['user']['last']; ?></td>
                                    <td class="text-center"><?php echo $transaction['transactions_type']['name'] ?></td>
                                    <td><?php echo $transaction['transaction_id'] ?></td>
                                    <td><?php echo strtoupper($transaction['currency']) . ' ' . $transaction['amount'] ?></td>
                                    <td><?php echo $transaction['brand'] . ' ' . $transaction['last4'] ?></td>
                                    <td><?php echo $transaction->created; ?></td>
                                    <td><?php echo $transaction->modified; ?></td>
                                    <td class="text-center actions">
                                        <?php echo '&nbsp&nbsp'; ?>
                                    </td>
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
</div>