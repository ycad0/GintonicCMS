<?php
namespace GintonicCMS\View\Cell;

use Cake\View\Cell;

/**
 * AlbumPhotos cell
 */
class AlbumPhotosCell extends Cell
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
        $this->loadModel('GintonicCMS.AlbumPhotos');
        
        $loggedInUserId = $this->request->session()->read('Auth.User.id');
        $album = $this->AlbumPhotos->find('all')
                    ->where(['AlbumPhotos.user_id' => $userId])
                    ->contain(['Files' => ['fields' => ['Files.id','Files.filename','Files.dir']]]);
        
        $this->set(compact('loggedInUserId','album','userId'));
    }
    
    public function upload_photos($userId = null, $fileId =null)
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
        
        if(!empty($userId) && !empty($fileId)){
            
            $albumData = array(
                'user_id' => $userId,
                'file_id' => $fileId
            );
            $album = $this->AlbumPhotos->newEntity($albumData);
            if($this->AlbumPhotos->save($album)){
                
                $message = __('Photo uploaded successfully.');
                $success = true;
                $status = 200;
            }
        }
        echo json_encode(array(
                'message' => $message,
                'success' => $success
            ));
        exit;
    }
    
    public function delete_image()
    {
        
        $message = __('Unable to delete image. Please try again...');
        $success = false;
        if(!empty($this->request->data['id']) && !empty($this->request->data['fileId'])){
            $image = $this->AlbumPhotos->get($this->request->data['id']);
            if($this->AlbumPhotos->delete($image)){
                $message = __('Image has been successfulyl deleted');
                $success = true;
                $this->loadModel('GintonicCMS.Files');
                $this->Files->deleteFile($this->request->data['fileName'],$this->request->data['fileId']);
            }
        }
        
        echo json_encode(array(
                'message' => $message,
                'success' => $success
            ));
        exit;
    }
    
    public function loadFiles()
    {
        $this->layout = 'ajax';
        $album = '';
        if(!empty($this->request->data['fileIds'])){
            $userId = $this->request->data['userId'];
            $loggedInUserId = $this->request->data['loggedInUserId'];
            
            $album = $this->AlbumPhotos->find('all')
                    ->where(['AlbumPhotos.file_id' => $this->request->data['fileIds']])
                    ->contain(['Files' => ['fields' => ['Files.id','Files.filename','Files.dir']]]);
            
            $this->set(compact('album','userId','loggedInUserId'));
        }
        $this->render('GintonicCMS.Element/AlbumPhotos/photo_galary');
    }
}
