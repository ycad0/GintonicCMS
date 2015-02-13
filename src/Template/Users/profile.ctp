<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <div class="account-wall">
                <h1 class="text-center login-title">Welcome : <?php echo $this->Session->read("Auth.User.first")." ".$this->Session->read("Auth.User.last") ?></h1>
                <div class="text-center">
                <?php echo $this->Html->link("Logout",array( "plugin" => 'gtw_users', "controller" => "users", "action" => "signout")) ?>
                </div>
            </div>                       
        </div>
    </div>
</div>
