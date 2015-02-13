<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">Reset your password</h1>
            <div class="account-wall">            
                <?php echo $this->Html->image("/GtwUsers/img/logo.png", array("class" => "img-responsive profile-img")); ?>
                <?php echo $this->Form->create('User', array(
                        'action' => 'reset_password/'.$userId.'/'.$token,
                        'class' => 'form-signin'
                ));?>
                    <?php echo $this->Session->flash(); ?>
                   	<input name="data[User][new_password]" type="password" class="form-control" autofocus placeholder="New Password" required id='new_password' style='margin-bottom:0px;'>
                   	<input name="data[User][confirm_password]" type="password" class="form-control" placeholder="Confirm Password" required id='confirm_password' oninput="checkPassword(this)">
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Reset Password</button>
                    <span class="clearfix"></span>
                </form>
            </div>
            <?php echo $this->Html->link('Already have an account?',
                array(
                    'plugin' => 'gtw_users',
                    'controller' => 'users',
                    'action' => 'signin'
                ),
                array(
                    'class' => 'text-center new-account'
                ));
             ?>
        </div>
    </div>
</div>
<script language='javascript' type='text/javascript'>
function checkPassword(input) {
	if (input.value != document.getElementById('new_password').value) {
		input.setCustomValidity('New Password and Confirm Password must be same');
    } else {
        // input is valid -- reset the error message
        input.setCustomValidity('');
   }
}
</script>
