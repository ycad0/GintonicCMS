<?php

use Cake\Core\Configure;
use Cake\Routing\Router;

$defaultOptions = array(
    'label' => '',
    'panel-label' => '',
    'description' => '',
    'amount' => 0,
    //'success-url' => Router::url(['plugin' => 'GintonicCMS', 'controller' => 'payments', 'action' => 'success'], true),
    'success-url' => 'http://proball_market.local/gintonic_c_m_s/payments/success',
    //'fail-url' => Router::url(['plugin' => 'GintonicCMS', 'controller' => 'payments', 'action' => 'fail'], true),
    'fail-url' => 'http://proball_market.local/gintonic_c_m_s/payments/fail',
);
$options = array_merge($defaultOptions, $options);
$amount = $options['amount'] * 100; // Convert to Stripe Format
$amountKey = $this->requestAction(array('plugin' => 'GintonicCMS', 'controller' => 'payments', 'action' => 'one_time_payment_set_amount', 'amount' => $amount));
?>
<?php //echo $this->Form->create('Stripe', array('url' => array('plugin' => 'GintonicCMS', 'controller' => 'payments', 'action' => 'one_time_payment'))) ?>
<?php echo $this->Form->create('Stripe', array('url' => 'http://proball_market.local/gintonic_c_m_s/payments/one_time_payment')) ?>
<script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
        data-key="<?php echo Configure::read('Stripe.publishable_key'); ?>"
        data-name="<?php echo Configure::read('Stripe.site_name'); ?>"
        data-image="<?php echo Configure::read('Stripe.site_logo_path'); ?>"
        data-currency="<?php echo Configure::read('Stripe.currency'); ?>"
        data-amount="<?php echo $amount; ?>" 
        data-description="<?php echo $options['description'] ?>" 
        data-label = "<?php echo $options['label'] ?>"
        data-panel-label = "<?php echo $options['panel-label'] ?>"
        >
</script>
<?php
	echo $this->Form->input('key', array('type' => 'hidden', 'value' => $amountKey));
	echo $this->Form->input('success_url', array('type' => 'hidden', 'value' => $options['success-url']));
	echo $this->Form->input('fail_url', array('type' => 'hidden', 'value' => $options['fail-url']));
	echo $this->Form->end();