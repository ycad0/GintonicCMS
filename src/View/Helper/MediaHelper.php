<?php

namespace GintonicCMS\View\Helper;

use Cake\View\Helper;

class MediaHelper extends Helper
{
    /**
     * TODO: doccomment
     */
    public function getYouTubeUrl($url)
    {
        $tempUrl = strstr($url, 'v=');
        
        if ($tempUrl) {
            $tempUrl = substr($tempUrl, 2);
            return "http://www.youtube.com/embed/" . $tempUrl;
        }
        return false;
    }
}
