<?php

namespace GintonicCMS\View\Helper;

use Cake\Core\Configure;
use Cake\Filesystem\File;
use Cake\View\Helper;
use Cake\View\Helper\HtmlHelper;

class FileHelper extends HtmlHelper
{

    public $helpers = ['Html'];

    /**
     * Returns the Image path of a user or returns a default image if none is
     * present yet.
     *
     * @param string $fileName string contain file name.
     * @param string $dirName string contain Directory name of file.
     *
     */
    public function getFileUrl($fileName = null, $dirName = null)
    {
        if (!empty($fileName)) {
            $fileLocation = !empty($dirName) ? WWW_ROOT . '/files/uploads/' . $dirName . '/' . $fileName : WWW_ROOT . '/files/uploads/' . $fileName;
            $filePath = !empty($dirName) ? '/files/uploads/' . $dirName . '/' . $fileName : '/files/uploads/' . $fileName;
            $file = new File($fileLocation);
            if ($file->exists()) {
                return $filePath;
            }
        }
        return false;
    }
    
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
