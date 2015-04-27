<?php
namespace GintonicCMS\View\Cell;

use Cake\View\Cell;

/**
 * Albums cell
 */
class AlbumsCell extends Cell
{

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * Default display method.
     *
     * @return void
     */
    public function display($userId = null)
    {
        $this->loadModel('Users');
        $this->loadModel('GintonicCMS.Albums');
        
        $loggedInUserId = $this->request->session()->read('Auth.User.id');
        $album = $this->Albums->find('all')
            ->where(['Albums.user_id' => $userId])
            ->contain([
                'Files' => [
                    'fields' => ['Files.id', 'Files.filename', 'Files.dir']
                ]
            ]);
        
        $this->set(compact('loggedInUserId', 'album', 'userId'));
    }
    
    /**
     * TODO: docomment
     */
    public function uploadPhotos($userId = null, $fileId = null)
    {
        if (!empty($this->request->data['id'])) {
            $userId = $this->request->data['id'];
        }
        if (!empty($this->request->data['file_id'])) {
            $fileId = $this->request->data['file_id'];
        }
        $message = __('Can\'t upload photo.');
        $success = false;
        $status = 500;
        
        if (!empty($userId) && !empty($fileId)) {
            $albumData = [
                'user_id' => $userId,
                'file_id' => $fileId
            ];
            $album = $this->Albums->newEntity($albumData);
            if ($this->Albums->save($album)) {
                $message = __('Photo uploaded successfully.');
                $success = true;
                $status = 200;
            }
        }
        echo json_encode([
            'message' => $message,
            'success' => $success
        ]);
        exit;
    }
    
    /**
     * TODO: docomment
     */
    public function deleteImage()
    {
        $message = __('Unable to delete image. Please try again...');
        $success = false;
        if (!empty($this->request->data['id']) && !empty($this->request->data['fileId'])) {
            $image = $this->Albums->get($this->request->data['id']);
            if ($this->Albums->delete($image)) {
                $message = __('Image has been successfulyl deleted');
                $success = true;
                $this->loadModel('GintonicCMS.Files');
                $this->Files->deleteFile(
                    $this->request->data['fileName'],
                    $this->request->data['fileId']
                );
            }
        }
        
        echo json_encode([
            'message' => $message,
            'success' => $success
        ]);
        exit;
    }
    
    /**
     * TODO: docomment
     */
    public function loadFiles()
    {
        $this->layout = 'ajax';
        $album = '';
        if (!empty($this->request->data['fileIds'])) {
            $userId = $this->request->data['userId'];
            $loggedInUserId = $this->request->data['loggedInUserId'];
            
            $album = $this->Albums->find('all')
                ->where(['Albums.file_id' => $this->request->data['fileIds']])
                ->contain([
                    'Files' => [
                        'fields' => ['Files.id', 'Files.filename', 'Files.dir']
                    ]
                ]);
            
            $this->set(compact('album', 'userId', 'loggedInUserId'));
        }
        $this->render('GintonicCMS.Element/Albums/photo_galary');
    }
}
