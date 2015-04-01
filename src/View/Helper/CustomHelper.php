<?php

namespace GintonicCMS\View\Helper;

use Cake\View\Helper;
use Cake\Filesystem\File;
use Cake\View\Helper\HtmlHelper;

class CustomHelper extends HtmlHelper 
{
    public function getActiveClass($controller, $actions = ['index']) 
    {
        $curAction = $this->request->params['action'];
        $curController = $this->request->params['controller'];
        if (!empty($curController) && $curController == $controller) {
            foreach ($actions as $action) {
                if ($curAction == $action) {
                    return 'active open';
                }
            }
        }
        return '';
    }

    function link($title, $url = null, array $options = array()) 
    {
        if (!empty($options['icon'])) {
            $title = '<i class="fa ' . $options['icon'] . '">&nbsp;</i>' . $title;
            unset($options['icon']);
            $options['escape'] = false;
        }
        if (is_array($url) && !isset($url['plugin'])) {
            $url['plugin'] = false;
        }
        return parent::link($title, $url, $options);
    }

    function projectMenu($menus, $plugin = null) 
    {
        foreach ($menus as $menuLabel => $menuOptions) {
            if (isset($menuOptions['multiLeval'])) {
                echo '<li class="treeview">';
                echo $this->link(__($menuLabel), $menuOptions['url'], ['data-toggle' => 'dropdown', 'title' => __($menuLabel), 'icon' => (isset($menuOptions['icon']) ? $menuOptions['icon'] : 'fa-dashboard')]);
                echo '<ul class="treeview-menu">';
                foreach ($menuOptions['multiLeval'] as $subMenuLabel => $subMenuoption) {
                    if (!empty($plugin) && is_array($subMenuoption['url'])) {
                        $subMenuoption['url']['plugin'] = $plugin;
                    }
                    echo '<li class="sub-menu ">' . $this->link(__($subMenuLabel), $subMenuoption['url'], ['title' => __($subMenuLabel), 'icon' => 'fa-angle-double-right']) . '</li>';
                }
                echo '</ul></li>';
            } else {
                if (!empty($plugin) && is_array($menuOptions['url'])) {
                    $menuOptions['url']['plugin'] = $plugin;
                }
                echo '<li>' . $this->link(__($menuLabel), $menuOptions['url'], ['title' => __($menuLabel), 'icon' => (isset($menuOptions['icon']) ? $menuOptions['icon'] : 'fa-dashboard')]) . '</li>';
            }
        }
    }

    public function getFileUrl($fileName = null, $defaultFile = DEFAULT_ADMIN_IMAGE_URL) 
    {
        if (!empty($fileName)) {
            $file = new File(WWW_ROOT . '/files/uploads/' . $fileName);
            if ($file->exists()) {
                return '/files/uploads/' . $fileName;
            }
        }
        return $defaultFile;
    }
    
}
?>