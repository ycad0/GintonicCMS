<?php
$this->Require->req('GintonicCMS/js/settings/assets');
$this->layout = 'GintonicCMS.bare';
?>
<div class="container">
    <h1>Build Assets</h1>
    <div class="row text-center">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h2>Toolkit</h2>
                    <p>Install the npm packages needed to build, optimize and minify assets</p>
                    <button class="btn btn-block btn-primary" data-npm>Install</button>
                    <p>npm status: <span class="label label-default" data-npm-status>unknown</span></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h2>Dependencies</h2>
                    <p>Download front end libraries, including bootstrap, require and adminLTE</p>
                    <button class="btn btn-block btn-primary disabled" data-bower>Install</button>
                    <p>bower status: <span class="label label-default" data-bower-status>unknown</span></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h2>Build</h2>
                    <p>Run the optimization, minification and sends the output to the webroot.</p>
                    <button class="btn btn-block btn-primary disabled" data-grunt>Install</button>
                    <p>grunt status: <span class="label label-default" data-grunt-status>unknown</span></p>
                </div>
            </div>
        </div>
    </div>
</div>
