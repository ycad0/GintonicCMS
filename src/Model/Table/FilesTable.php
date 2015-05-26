<?php

namespace GintonicCMS\Model\Table;

use Cake\Filesystem\File;
use Cake\Filesystem\Folder;
use Cake\ORM\Query;
use Cake\ORM\Table;

class FilesTable extends Table
{
    /**
     * TODO: doccomment
     */
    public function initialize(array $config)
    {
        //for the default add the created and modified
        $this->addBehavior('GintonicCMS.File', [
            'uploadDir' => 'files/uploads',
            'allowedTypes' => [
                'image/jpeg'
            ],
            'fileNameFunction' => 'convertName',
        ]);

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'modified' => 'always'
                ]
            ]
        ]);

        $this->belongsTo('Users', [
            'className' => 'GintonicCMS.Users',
            'foreignKey' => 'user_id',
            'propertyName' => 'user',
        ]);

        $this->hasMany('GintonicCMS.Albums');
    }

    /**
     * TODO: doccomment
     * This function creates/define what path and filename to give before storing it
     */
    public function createFileName($ext, $userId, $count)
    {
        $count = empty($count) ? '' : ('_' . $count);
        return date("d_m_Y_G.i.s") . '_' . $userId . $count . '.' . $ext;
    }

    /**
     * TODO: doccomment
     */
    public function getPath($filename, $dirName = null)
    {
        if (empty($dirName)) {
            $path = WWW_ROOT . 'files' . DS . 'uploads' . DS;
        } else {
            $path = WWW_ROOT . 'files' . DS . 'uploads' . DS . $dirName . DS;
        }
        //Check folder and if not exist then create folder
        $dir = new Folder($path, true, 0777);
        return $path . $filename;
    }

    /**
     * TODO: doccomment
     */
    public function getUrl($filename = null, $fileId = null)
    {
        if (!empty($fileId)) {
            $file = $this->get($fileId);
            return 'files/uploads/' . $file->filename;
        }
        return 'files/uploads/' . $filename;
    }

    /**
     * TODO: doccomment
     */
    public function deleteFile($filename, $fileId = null)
    {
        if (!empty($fileId)) {
            $oldFile = $this->get($fileId);
            $this->delete($oldFile);
        }
        $file = new File($this->getPath($filename));
        $file->delete();
        $file->close();
    }

    /**
     * TODO: doccomment
     */
    public function checkFileExist($fileName = null)
    {
        $fileName = WWW_ROOT . 'files' . DS . 'uploads' . DS . $fileName;
        if (file_exists($fileName) && !is_dir($fileName)) {
            return $fileName;
        }
        return false;
    }

    /**
     * TODO: doccomment
     */
    public function updateFileName($data)
    {
        $arrResponse = ['status' => 'fail'];
        $files = $this->newEntity($data);
        if (!empty($data)) {
            $arrResponse = [
                'status' => 'success',
                'id' => $data['id'],
                'value' => $data['title']
            ];
            $files = $this->patchEntity($files, $data);
            $this->save($files);
        }
        return $arrResponse;
    }

    /**
     * TODO: doccomment
     */
    public function deleteUserFiles($fileId = null)
    {
        $response = [
            'message' => __('Error occure while deletinf the file.'),
            'class' => 'alert-danger'
        ];
        if (!empty($fileId)) {
            $file = $this->get($fileId);
            if ($this->delete($file)) {
                $this->deleteFile($file->filename);
                $response = [
                    'message' => __('File has been deleted successfully.'),
                    'class' => 'alert-success'
                ];
            }
        }
        return $response;
    }

    /**
     * TODO: Write Document
     */
    public function convertName($title, $ext, $userId)
    {
        return sha1($title) . '_' . $userId . '.' . $ext;
    }

    /**
     * TODO: Write Document
     */
    public function findWithFileIds(Query $query, array $option)
    {
        return $query
            ->where(['Files.id IN' => $option['fileIds']]);
    }
}
