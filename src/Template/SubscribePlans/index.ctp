<?php

use Cake\Routing\Router;
use Cake\Core\Configure;
?>
<div class="container">
    <div  class="row">
        <div class="col-md-12">
            <h1>
                Subscribe Plans
                <?php echo $this->Html->link('<i class="fa fa-th-large"></i> View Subscribe Transactions', Router::url(array('plugin' => 'GintonicCMS', 'controller' => 'subscribe_plans', 'action' => 'myplantransaction', 0, 0, true), true), array('class' => 'btn btn-primary pull-right', 'escape' => false, 'title' => 'View Subscribes transactions')); ?>
                <?php echo $this->Html->link('<i class="fa fa-plus"> </i>Add Plan', array('controller' => 'subscribe_plans', 'action' => 'createPlans'), array('class' => 'btn btn-primary pull-right', 'escape' => false, 'title' => 'Add new plan')); ?>
            </h1>
            <table class="table table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Plan Id</th>
                        <th>Plan Name</th>
                        <th>Plan amount</th>
                        <th>Plan Interval</th>
                        <th>Plan Interval Count</th>
                        <th>Plan Users</th>
                        <th>Plan Status</th>
                        <th>Last Updated</th>
                        <th class='text-center'>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($plans)) { ?>
                        <tr>
                            <td colspan='10' class='text-warning'>No record found.</td>
                        </tr>
                    <?php } else { ?>
                        <?php foreach ($plans as $plan): ?>
                            <tr>
                                <td><?php echo $plan['id']; ?></td>
                                <td><?php echo $plan['plan_id']; ?></td>
                                <td><?php echo $plan['name']; ?></td>
                                <td><?php echo Configure::read('Stripe.currency'). ' '.$plan['amount']; ?></td>
                                <td><?php echo $plan['plan_interval']; ?></td>
                                <td><?php echo $plan['interval_count']; ?></td>
                                <td><?php echo $plan['plan_user_count']; ?></td>
                                <td><?php echo $plan['status']; ?></td>
                                <td><?php echo $plan['modified']; ?></td>
                                <td class="text-center">
                                    <span class="text-center">
                                        <?php echo $this->Html->link('<i class="fa fa-pencil"> </i>', array('plugin' => 'GintonicCMS', 'controller' => 'SubscribePlans', 'action' => 'createPlans', $plan['id']), array('role' => 'button', 'escape' => false, 'title' => 'Edit this plan')); ?>
                                        &nbsp;
                                        <?php echo $this->Html->link('<i class="fa fa-th"> </i>', array('plugin' => 'GintonicCMS', 'controller' => 'SubscribePlans', 'action' => 'myplantransaction', $plan['plan_id']), array('role' => 'button', 'escape' => false, 'title' => 'View this plan transactions')); ?>
                                        &nbsp;
                                        <?php echo $this->Html->link('<i class="fa fa-user"> </i>', array('plugin' => 'GintonicCMS', 'controller' => 'SubscribePlans', 'action' => 'usertransaction', $plan['plan_id']), array('role' => 'button', 'escape' => false, 'title' => 'View this plan users')); ?>
                                        &nbsp;
                                        <?php echo $this->Html->link('<i class="fa fa-trash-o"> </i>', array('plugin' => 'GintonicCMS', 'controller' => 'SubscribePlans', 'action' => 'delete', $plan['id']), array('role' => 'button', 'escape' => false, 'title' => 'Delete this plan'), 'Are you sure? You want to delete this plan.'); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>