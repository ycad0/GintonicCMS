<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h1>Database Setup</h1>
            <p>
                Welcome to GintonicCMS. Before getting started, we need some information 
                on the database. Please enter your database connection details. if you 
                are not sure about this, contact your host.
            </p>
        </div>
        <div class="col-md-6">
            <h2>Connection Info</h2>
            <?php
                echo $this->Form->create('Datasource');
                echo $this->Form->input('database');
                echo $this->Form->input('username');
                echo $this->Form->input('password');
                echo $this->Form->input('host');
                echo $this->Form->submit('Submit', ['class' => 'btn btn-default']);
                echo $this->Form->end();
            ?>
        </div>
    </div>
</div>
