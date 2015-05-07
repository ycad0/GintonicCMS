<?php

namespace GintonicCMS\Model\Behavior;

use ArrayObject;
use Cake\Event\Event;
use Cake\Filesystem\File;
use Cake\ORM\Behavior;
use Cake\ORM\TableRegistry;

class FileBehavior extends Behavior
{
    public $_defaultConfig = [
        'defaultFile' => false,
        'allowedTypes' => [],
        'uploadDir' => 'files/uploads',
        'fileNameFunction' => false,
    ];

    /**
     * TODO: write document
     */
    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
        debug('test');exit;
        $data['path'] = 'test';
        if (isset($data['file']) && isset($data['file']['filename'])) {
            $config = $this->config();
            $data['file']['path'] = $config['uploadDir'] . '/' . $data['file']['filename'];
        }
    }

    /**
     * TODO: write document
     */
    public function upload($fileData, $userDetails)
    {
        $fileTable = TableRegistry::get('Files');
        $response = false;

        if (is_uploaded_file($fileData['tmpFile']['tmp_name'])) {
            if ($this->__validateFile($fileData['tmpFile']['type'])) {
                $fileDetail = $this->__moveUploadedFiles($fileData, $userDetails['id']);
                $file = $fileTable->newEntity($fileDetail);
                unset($file->tmpFile);
                if ($result = $fileTable->save($file)) {
                    $response = [
                        'fileId' => $result->id,
                        'fileName' => $fileDetail['filename']
                    ];
                    $flag = true;
                } else {
                    $flag = false;
                }
            }
        }
        return $response;
    }

    /**
     * TODO: write document
     */
    private function __moveUploadedFiles($fileData, $userId)
    {
        $fileInfo['user_id'] = $userId;
        $fileInfo['size'] = $fileData['tmpFile']['size'];
        $fileInfo['type'] = $fileData['tmpFile']['type'];
        $fileInfo['title'] = $fileData['title'];
        $fileInfo['ext'] = pathinfo($fileData['tmpFile']['name'], PATHINFO_EXTENSION);
        $fileInfo['filename'] = $this->__getFileName($fileData['tmpFile']['name'], $fileInfo['ext'], $userId);
        $fileInfo['modified'] = $fileInfo['created'] = date('Y-m-d H:i:s');

        $file = new File($fileData['tmpFile']['tmp_name']);
        $fileData = $file->read(true, 'r');
        $file->close();

        $file = new File($this->config('uploadDir') . '/' . $fileInfo['filename'], true, 644);
        $file->write($fileData, 'w');
        $file->close();

        return $fileInfo;
    }

    /**
     * TODO: write document
     */
    private function __getFileName($title = null, $ext = null, $userId = null)
    {
        $fileNameFunction = $this->config('fileNameFunction');
        if (empty($fileNameFunction)) {
            return date("d_m_Y_G.i.s") . '_' . $userId . '.' . $ext;
        } else {
            $function = $fileNameFunction;
            return $this->_table->$function($title, $ext, $userId);
        }
    }

    /**
     * TODO: write document
     */
    private function __getFilePath($fileName = null)
    {
        return $this->config('rootDir') . $this->config('uploadDir') . DS . $fileName;
    }

    /**
     * TODO: write document
     */
    private function __validateFile($fileType = null)
    {
        if (in_array($fileType, $this->config('allowedTypes'))) {
            return true;
        }
        return false;
    }
}
