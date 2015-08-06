<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace GintonicCMS\View;

use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Utility\Inflector;
use Cake\View\View;
use CrudView\View\CrudView;

/**
 * App View class
 */
class AppView extends CrudView
{
    public $layout = 'default';
    
    /**
     * Initializes the crud-view template paths
     *
     * @return void
     */
    protected function _setupPaths()
    {
        $paths = Configure::read('App.paths.templates');

        $extraPaths = Configure::read('CrudView.templatePaths');
        if (!empty($extraPaths)) {
            $paths = array_merge($paths, (array)$extraPaths);
        }
        $paths[] = Plugin::classPath('GintonicCMS') . 'Template' . DS;
        $paths[] = Plugin::classPath('CrudView') . 'Template' . DS;

        Configure::write('App.paths.templates', $paths);
    }
}
