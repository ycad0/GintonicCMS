<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
$cakeDescription = 'User Management';
?>
<!DOCTYPE html>
<html>
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            <?= $cakeDescription ?>:
            <?= $this->fetch('title') ?>
        </title>
        <?= $this->Html->meta('icon') ?>
        <?= $this->Html->css('site') ?>
        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css') ?>
        <?= $this->fetch('script') ?>
    </head>
    <body>
        <?= $this->element('user/header'); ?>
        <div id="container">
            <div id="content">
                <section class="content-header">
                    <h1 style="float: left"><?php echo $this->fetch('pagetitle');?></h1>
                    <div class="top-links" style="float: right">
                        <?php echo $this->fetch('top_links'); ?>
                    </div>
                    <div class="clearfix"></div>
                </section>
                <?= $this->Flash->render() ?>
                <div class="row">
                    <?= $this->fetch('content') ?>
                </div>
            </div>
            <?= $this->element('user/footer'); ?>
        </div>
    </body>
    <?php echo $this->GtwRequire->req('jquery');?>
    <?php echo $this->GtwRequire->req('bootstrap');?>
    <?php echo $this->GtwRequire->load($this->Url->build('/',TRUE).'gintonic_c_m_s/js/config'); ?>
</html>
