<?php

use Cake\Core\Plugin;

// Utilities and core
Plugin::load('Acl', ['bootstrap' => true]);
Plugin::load('BootstrapUI');
Plugin::load('Crud');
Plugin::load('CrudView');
Plugin::load('Requirejs');
Plugin::load('Search');

// Themes
Plugin::load('AdminTheme');
Plugin::load('TwbsTheme');

// Application base
Plugin::load('Payments', ['routes' => true]);
Plugin::load('Users', ['routes' => true]);



