<?php
/**
 * GintonicCMS
 * Copyright (c) Gintonic Web (http://gintonicweb.com)
 *
 * Licensed under The GPL 2.0  License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Gintonic Web, Inc. (http://gintonicweb.com)
 * @link          http://cms.gintonicweb.com GintonicCMS Project
 * @since         0.0.0
 * @license       https://www.gnu.org/licenses/gpl-2.0.html GPL 2.0 License
 */

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;

$this->helpers()->load('GintonicCMS.Require');
$this->layout = 'GintonicCMS.default'; 

?>

<div class="container">
    <div class="jumbotron">
        <?= $this->Html->image(
            'GintonicCMS.logo.png',
            ['class' => 'img-responsive center-block']
        ); ?>
        <h1 style="display:none;">GintonicCMS</h1>
        <p class="lead text-center">A robust core for webapps</p>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php
            if (Configure::read('debug')):
                Debugger::checkSecurityKeys();
            endif;
            ?>
            <p id="url-rewriting-warning" style="background-color:#e32; color:#fff;display:none">
                URL rewriting is not properly configured on your server.
                1) <a target="_blank" href="http://book.cakephp.org/3.0/en/installation/url-rewriting.html" style="color:#fff;">Help me configure it</a>
                2) <a target="_blank" href="http://book.cakephp.org/3.0/en/development/configuration.html#general-configuration" style="color:#fff;">I don't / can't use URL rewriting</a>
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <h2>PHP setup</h2>
            <?php if (version_compare(PHP_VERSION, '5.4.16', '>=')): ?>
                <p class="success">Your version of PHP is 5.4.16 or higher.</p>
            <?php else: ?>
                <p class="problem">Your version of PHP is too low. You need PHP 5.4.16 or higher to use CakePHP.</p>
            <?php endif; ?>

            <?php if (extension_loaded('mbstring')): ?>
                <p class="success">Your version of PHP has the mbstring extension loaded.</p>
            <?php else: ?>
                <p class="problem">Your version of PHP does NOT have the mbstring extension loaded.</p>;
            <?php endif; ?>

            <?php if (extension_loaded('openssl')): ?>
                <p class="success">Your version of PHP has the openssl extension loaded.</p>
            <?php elseif (extension_loaded('mcrypt')): ?>
                <p class="success">Your version of PHP has the mcrypt extension loaded.</p>
            <?php else: ?>
                <p class="problem">Your version of PHP does NOT have the openssl or mcrypt extension loaded.</p>
            <?php endif; ?>

            <?php if (extension_loaded('intl')): ?>
                <p class="success">Your version of PHP has the intl extension loaded.</p>
            <?php else: ?>
                <p class="problem">Your version of PHP does NOT have the intl extension loaded.</p>
            <?php endif; ?>
        </div>
        <div class="col-md-6">
            <h2>Caching</h2>
            <?php if (is_writable(TMP)): ?>
                <p class="success">Your tmp directory is writable.</p>
            <?php else: ?>
                <p class="problem">Your tmp directory is NOT writable.</p>
            <?php endif; ?>

            <?php if (is_writable(LOGS)): ?>
                <p class="success">Your logs directory is writable.</p>
            <?php else: ?>
                <p class="problem">Your logs directory is NOT writable.</p>
            <?php endif; ?>

            <?php $settings = Cache::config('_cake_core_'); ?>
            <?php if (!empty($settings)): ?>
                <p class="success">The <em><?= $settings['className'] ?>Engine</em> is being used for core caching. To change the config edit config/app.php</p>
            <?php else: ?>
                <p class="problem">Your cache is NOT working. Please check the settings in config/app.php</p>
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h2>Database</h2>
            <?php
                try {
                    $connection = ConnectionManager::get('default');
                    $connected = $connection->connect();
                } catch (Exception $connectionError) {
                    $connected = false;
                    $errorMsg = $connectionError->getMessage();
                    if (method_exists($connectionError, 'getAttributes')):
                        $attributes = $connectionError->getAttributes();
                        if (isset($errorMsg['message'])):
                            $errorMsg .= '<br />' . $attributes['message'];
                        endif;
                    endif;
                }
            ?>
            <?php if ($connected): ?>
                <p class="success">CakePHP is able to connect to the database.</p>
            <?php else: ?>
                <p class="problem">CakePHP is NOT able to connect to the database.<br /><br /><?= $errorMsg ?></p>
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h2>More about Gintonic CMS</h2>
            <p>Gintonic CMS is a robust core for webapps</p>
            <p>Wraping commonly used features of the web in a single uniform interface</p>
            <ul>
                <li><a href="http://cms.gintonicweb.com">Gintonic CMS website</a></li>
                <li><a href="https://github.com/gintonicweb/GintonicCMS">Project page on github</a></li>
                <li><a href="https://github.com/gintonicweb/GintonicCMS/wiki">Github Wiki</a></li>
            </ul>
        </div>
    </div>
</div>
