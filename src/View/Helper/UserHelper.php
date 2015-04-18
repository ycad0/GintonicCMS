<?php

namespace GintonicCMS\View\Helper;

use Cake\View\Helper;
use Cake\View\Helper\HtmlHelper;
use Cake\Core\Configure;

class UserHelper extends HtmlHelper 
{

    public $helpers = ['Html'];

    /**
     * Returns the avatar of a user or returns a default avatar if none is 
     * present yet. 
     * 
     * @param array user Array containing the cakephp formatted data of a user
     * @param array options Options defined for cakephp
     * 
     */
    public function avatar(array $user, array $options=[]) 
    {
        if (empty($user['file']['filepath'])) {
            $default = 'GintonicCMS.avatar.png';
            if ( !is_null(Configure::read('default_avatar')) ) {
                $default = Configure::read('default_avatar');
            }
            return $this->Html->image($default, $options);
        }
        return $this->Html->image($user['file']['filepath'], $options);
    }
    
}
?>
