<?php
use Cake\Core\Configure;
?>
<div class="container">
    <div class="row">
        <div class="col-md-3 pull-right text-left">
            <h3 ><?php echo !empty(Configure::read('Stripe.Invoive.CompanyName'))?Configure::read('Stripe.Invoive.CompanyName'):'';?></h3>
            <h5><?php echo !empty(Configure::read('Stripe.Invoive.address'))?Configure::read('Stripe.Invoive.address'):'';?></h5>
            <h5><?php echo !empty(Configure::read('Stripe.Invoive.email'))?Configure::read('Stripe.Invoive.email'):'';?></h5>
            <h5><?php echo !empty(Configure::read('Stripe.Invoive.phone'))?Configure::read('Stripe.Invoive.phone'):'';?></h5>
        </div>
        <div style="border-bottom: 1px solid #d5d5d5" class="col-md-12"></div>
        <div class="col-md-12">
            <?php
                $userName = 'Anonymous';
                $userInfo = $this->request->session()->read('Auth.User');
                if(!empty($userInfo)){
                    $userName = $userInfo['first'] . ' ' . $userInfo['last'];
                }
            ?>
            <h4><?php echo 'Name : ' . $userName; ?></h4>
            <h5><?php echo 'Email : ' . $transactionDetail['email']; ?></h5>
            <table class="table table-responsive table-striped">
                <tr>
                    <td>Date</td>
                    <td><?php echo $transactionDetail['created']; ?></td>
                <tr>
                <tr>
                    <td>Invoice Id</td>
                    <td><?php echo $transactionDetail['id']; ?></td>
                <tr>
                <tr>
                    <td>Amount</td>
                    <td><?php echo $transactionDetail['amount']; ?></td>
                <tr>
                <tr>
                    <td>Currency</td>
                    <td><?php echo strtoupper($transactionDetail['currency']); ?></td>
                <tr>
                <tr>
                    <td>Payment Method</td>
                    <td><?php echo $transactionDetail['brand']; ?></td>
                <tr>
            </table>
            <button onclick="window.print();" class="btn btn-default"><i class="fa fa-print"></i> Print</button>
        </div>
    </div>
</div>