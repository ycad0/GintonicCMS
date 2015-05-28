<div class="container">
    <div class="row">
        <?php if (isset($connected) && $connected): ?>
            <p class="alert alert-success" style="margin-top: 40px;">
                All right. You've made it through this part of the installation. GintonicCMS can now communicate with your database.
            </p>
            <?php echo $this->Html->link('Continue', '/', ['class' => 'btn btn-default']); ?>
        <?php elseif (isset($connected) && !$connected):

            ?>
            <p class="alert alert-danger" style="margin-top: 40px;">
                Unable to Connect with database. Please try again.
            </p>
            <?php echo $this->Html->link('Continue', '/', ['class' => 'btn btn-default']); ?>
        <?php else:

            ?>
            <h3>Welcome to GintonicCMS. Before getting started, we need some information on the database.
                You will need to know the following items before proceeding.</h3>

            <ol>
                <li>Database name</li>
                <li>Database username</li>
                <li>Database password</li>
                <li>Database host</li>
            </ol>

            <h3>Below should enter your database connection detail. if you are not sure about this, contact your host.</h3>
            <?php
            echo $this->Form->create('database_setup');
            echo $this->Form->input('database');
            echo $this->Form->input('username');
            echo $this->Form->input('password');
            echo $this->Form->input('host');
            echo $this->Form->submit('Submit', ['class' => 'btn btn-default']);
            echo $this->Form->end();
        endif;

        ?>
    </div>
</div>