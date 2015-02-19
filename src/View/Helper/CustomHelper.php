<?php
namespace GintonicCMS\View\Helper;

use Cake\View\Helper;

class CustomHelper extends Helper 
{
    
    public $helpers = array('Html');
    
    public function getActiveClass($controller, $actions = ['index']) 
    {
        $curAction = $this->request->params['action'];
        $curController = $this->request->params['controller'];
        if (!empty($curController) && $curController == $controller) {
            foreach($actions as $action){
                if ($curAction == $action) {
                    return 'active open';
                }
            }
        }
        return '';
    }
    
}

?>