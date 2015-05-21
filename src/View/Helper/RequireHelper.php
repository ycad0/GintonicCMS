<?php
namespace GintonicCMS\View\Helper;

use Cake\Core\Configure;
use Cake\Utility\Inflector;
use Cake\View\Helper;
use Cake\View\Helper\HtmlHelper;
use Cake\View\Helper\UrlHelper;

class RequireHelper extends Helper
{
    
    public $helpers = ['Html', 'Url'];
    
    /**
     * TODO: doccomment
     */
    public function load($url, $requireLib = 'GintonicCMS.config')
    {
        if (strpos($url, '//') === false) {
            $url = $this->Url->assetUrl($url, ['pathPrefix' => Configure::read('App.jsBaseUrl')]);
        }
        $modules = '';
        if (!is_null($this->_View->get('requiredeps'))) {
            $modules = "require([" . implode(',', $this->_View->get('requiredeps')) . "]);";
        }
        $output = $this->Html->script(
            'GintonicCMS.config',
            ['data-main' => $url]
        );
        $output .= "<script type='text/javascript'>";
        $output .= "require(['" . $url . "'], function () {";
        $output .= $modules;
        $output .= '});</script>';

        return $output;
    }

    /**
     * TODO: doccomment
     */
    public function req($name)
    {
        if (!isset($this->_View->viewVars['requiredeps'])) {
            $this->_View->viewVars['requiredeps'] = array();
        }
        array_push($this->_View->viewVars['requiredeps'], "'" . $name . "'");
        return;
    }
    
    /**
     * TODO: doccomment
     */
    public function ajaxReq($name)
    {
        return '<script>' .
            'require(["' . $name . '"]);' .
            '</script>';
    }
    
    /**
     * TODO: doccomment
     */
    public function basemodule($base, $default)
    {
        $jsController = $base . Inflector::camelize($this->params['controller']);
        
        // if action exists
        if (is_file($jsController . '/' . $this->params['action'] . '.js')) {
            $file = $base . Inflector::camelize($this->params['controller']) . '/' . $this->params['action'];
            $this->req($file);
            return;
        }
        
        // if controller exists
        if (is_file($jsController . '.js')) {
            $file = $base . Inflector::camelize($this->params['controller']);
            $this->req($file);
            return;
        }
        
        // if nothing else exists
        return $this->req($base . '/' . $default);
    }
}
