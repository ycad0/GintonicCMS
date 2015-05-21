<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-8"><h3 class="title"><?php echo __('Subscribe Now') ?></h3></div>
            <div class="col-md-4 text-right">
                <?php 
                    echo $this->Html->link('My Subscribes',array('plugin' => 'GintonicCMS', 'controller' => 'plans', 'action' => 'userSubscribe'),array('class'=>'btn btn-default'));
                ?>
            </div>
        </div>
    </div>    
    <table class="table table-hover table-striped table-bordered">
        <tbody>	
            <?php if(empty($plans)){ ?>
            <tr>
                <td>
                   <?php echo __('No any Subscribes plan found') ?>
                </td>
            </tr>
            <?php } ?>
            <?php foreach ($plans as $key => $plan) { ?>
            <tr>
                <td>
                    Subscribe this plan ($<?php echo $plan->amount?> per <?php echo $plan->interval_count. ' '.$plan->plan_interval ?>)
                </td>
                <td width="10%" class="text-center">
                    <?php
                    echo $this->element('GintonicCMS.Stripe/subscribe', array('options' => array(
                            'description' => $plan->name,
                            'amount' => $plan->amount,
                            'label' => __('Subscribe Now'),
                    ),'plan_id'=>$plan->plan_id,'subscribe_id'=>(isset($arrPlans[$plan->plan_id])?$arrPlans[$plan->plan_id]:null)));
                    ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>	
</div>