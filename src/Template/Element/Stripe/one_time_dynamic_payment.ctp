<?php
use Cake\Core\Configure;
use Cake\Routing\Router;
?>
<div class="row">
    <div class="col-md-6">
        <?php
        $options = array(
            'success-url' => Router::url(['plugin' => 'GintonicCMS', 'controller' => 'payments', 'action' => 'success'], true),
            'fail-url' => Router::url(['plugin' => 'GintonicCMS', 'controller' => 'payments', 'action' => 'fail'], true),
        );
        echo $this->Form->create('payment', array(
            'id' => 'payment-form',
            'url'=> array("plugin" => 'GintonicCMS', "controller" => "payments", "action" => "confirmPayment"),
            'inputDefaults' => array(
                'div' => 'form-group',
                'wrapInput' => false,
                'class' => 'form-control'
            ),
        ));
        echo $this->Form->input('email', array('id' => 'card-holder-email'));
        echo $this->Form->input('card_number', array('id' => 'card-number'));
        echo $this->Form->hidden('amount', array('id' => 'amount', 'value' => $amount));
        $months = [];
        $years = [];
        for ($i=1; $i <= 12; $i++) {
            $months[$i] = $i;
        }
        for ($i=date('Y'); $i <= date('Y')+15; $i++) {
            $years[$i] = $i;
        }
        echo $this->Form->input('month', array('data-stripe' => "exp-month", 'id' => 'card-expiry-month', 'options'=>$months));
        echo $this->Form->input('year', array('data-stripe' => "exp-year", 'id' => 'card-expiry-year', 'options'=>$years));
        echo $this->Form->input('cvv', array('id' => 'cvv'));
        echo $this->Form->input('success_url', array('type' => 'hidden', 'value' => $options['success-url']));
        echo $this->Form->input('fail_url', array('type' => 'hidden', 'value' => $options['fail-url']));
        echo $this->Form->submit('Pay Now', array('class' => 'btn btn-primary'));
        echo $this->Form->end();
        ?>
    </div>
</div>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
    var PublishableKey = '<?php echo Configure::read('Stripe.publishable_key'); ?>'
</script>
<?php echo $this->Require->req('jquery');?>
<?php $this->Require->req('stripe/common'); ?>