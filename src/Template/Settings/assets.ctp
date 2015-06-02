<?php
use Cake\Core\Configure;
Configure::load('gintonic');

$npm = Configure::read('Gintonic.install.npm');
$bower = Configure::read('Gintonic.install.bower');
$grunt = Configure::read('Gintonic.install.grunt');

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
                    <p>npm status: 
                        <span class="label label-<?= $npm?'primary':'default'?>" data-npm-status>
                            <?= $npm?'installed':'unknown'?>
                        </span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h2>Dependencies</h2>
                    <p>Download front end libraries, including bootstrap, require and adminLTE</p>
                    <button class="btn btn-block btn-primary <?= $npm?'':'disabled' ?>" data-bower>Install</button>
                    <p>bower status: 
                        <span class="label label-<?= $bower?'primary':'default'?>" data-bower-status>
                            <?= $bower?'installed':'unknown'?>
                        </span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h2>Build</h2>
                    <p>Run the optimization, minification and sends the output to the webroot.</p>
                    <button class="btn btn-block btn-primary <?= $bower?'':'disabled' ?>" data-grunt>Install</button>
                    <p>grunt status: 
                        <span class="label label-<?= $grunt?'primary':'default'?>" data-grunt-status>
                            <?= $grunt?'installed':'unknown'?>
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
         <div class="col-md-12">
             <a href="/" class="btn btn-default">Cancel</a>
             <a href="/" class="btn btn-primary disabled" data-done>Done</a>
         </div>
    </div>
</div>
