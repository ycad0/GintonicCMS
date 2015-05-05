<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>
                <?= $title?>
            </h1>
            <table class="table table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th width='5%'>Sr. No.</th>
                        <th width='20%'>User Name</th>
                        <th width='10%'>Plan Status</th>
                        <th width='15%'>Last Charged</th>
                        <th width='15%'>Last Modified</th>
                        <th width='13%'>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($planUsers)) { ?>
                        <tr>
                            <td colspan='5' class='text-warning'><?php echo __('No users found for this plan.') ?></td>
                        </tr>
                        <?php
                    } else {
                        $srNo = 1;
                        foreach ($planUsers->SubscribePlanUsers as $key => $planUser) {
                            ?>
                            <tr>
                                <td><?php echo $srNo++; ?></td>
                                <td><?php echo (isset($userList[$planUser['user_id']]) ? $userList[$planUser['user_id']] : ''); ?></td>
                                <td><?php echo $planUser['status']; ?></td>
                                <td><?php echo $planUser['last_charged']; ?></td>
                                <td><?php echo $planUser['modified']; ?></td>
                                <td class="text-center">
                                    <?php
                                    echo $this->Html->link('View Transactions', array('plugin' => 'GintonicCMS', 'controller' => 'subscribe_plans', 'action' => 'myplantransaction', $planUsers['plan_id'], $planUser['user_id']), array('class' => 'btn btn-info'));
                                    ?>
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