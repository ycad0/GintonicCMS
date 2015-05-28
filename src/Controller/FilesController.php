<?php
namespace GintonicCMS\Controller;

use Cake\Event\Event;
use GintonicCMS\Controller\AppController;

class FilesController extends AppController
{
    public $helpers = ['Number', 'Time'];
    
    /**
     * TODO: blockcomment
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }
    
    /**
     * TODO: blockcomment
     */
    public function isAuthorized($user = null)
    {
        return true;
    }
     
    /**
     * TODO: blockcomment
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        if ($this->RequestHandler->responseType() == 'json') {
            $this->RequestHandler->setContent('json', 'application/json');
        }
    }

    /**
     * TODO: blockcomment
     */
    public function index()
    {
        if (!$this->request->session()->check('Auth.User.id')) {
            $this->Flash->set(__('You are not signed in.'), [
                'element' => 'GintonicCMS.alert',
                'params' => ['class' => 'alert-danger']
            ]);
            return $this->redirect(['plugin' => 'GintonicCMS', 'controller' => 'Users', 'action' => 'signin']);
        }
        
        $userFiles = $this->request->session()->read('Auth.User.file.id');
        $arrConditions = [];
        
        if (!empty($userFiles)) {
            $arrConditions = ['Files.id NOT IN' => $this->request->session()->read('Auth.User.file.id')];
        }
        
        if ($this->request->session()->read('Auth.User.role') != 'admin') {
            $arrConditions = ['Files.user_id' => $this->request->session()->read('Auth.User.id')];
        }
        $this->paginate = [
            'conditions' => $arrConditions,
            'order' => ['Files.created' => 'desc'],
            'limit' => 5
        ];
        $this->set('files', $this->paginate('Files'));
    }
    
    /**
     * TODO: blockcomment
     */
    public function add()
    {
        if (!$this->request->session()->check('Auth.User.id')) {
            $this->Flash->set(__('You are not signed in.'), [
                'element' => 'GintonicCMS.alert',
                'params' => ['class' => 'alert-danger']
            ]);
            return $this->redirect(['plugin' => 'GintonicCMS', 'controller' => 'Users', 'action' => 'signin']);
        }
        
        $file = $this->Files->newEntity($this->request->data);
        $this->layout = 'ajax';
        
        if ($this->request->is(['post', 'put'])) {
            if (isset($this->request->data['callBack'])) {
                $this->set('callbackModule', $this->request->data['callBack']);
                unset($this->request->data['callBack']);
            }
            
            $response = $this->Files->upload($this->request->data, $this->Auth->user());
            
            $fileId = $response['fileId'];
            $fileName = $response['fileName'];
            
            $this->set(compact('fileId', 'fileName'));
            $this->render('completed');
        }
        $this->set(compact('file'));
    }

    /**
     * TODO: blockcomment
     */
    public function getRow($id)
    {
        $this->layout = 'ajax';
        $fileIds = explode(', ', $id);
        $files = $this->Files->find('withFileIds', ['fileIds' => $fileIds]);
        $this->set('files', $files);
    }

    /**
     * TODO: blockcomment
     */
    public function delete($fileId)
    {
        $response = $this->Files->deleteUserFiles($fileId);
        $this->Flash->set($response['message'], [
            'element' => 'GintonicCMS.alert',
            'params' => ['class' => $response['class']]
        ]);
        $this->redirect(['action' => 'index']);
    }

    /**
     * TODO: blockcomment
     */
    public function download($filename)
    {
        $fileLocation = $this->Files->checkFileExist($filename);
        if ($fileLocation) {
            $this->autoRender = false;
            return $this->response->file($fileLocation, ['download' => true]);
        }
        $this->Flash->set(__('File Not Found.!!!'), [
            'element' => 'GintonicCMS.alert',
            'params' => ['class' => 'alert-danger']
        ]);
        $this->redirect($this->referer());
    }
    
    /**
     * TODO: blockcomment
     */
    public function update()
    {
        $this->layout = false;
        $this->autoRender = false;
        $response = $this->Files->updateFileName($this->request->data);
        echo json_encode($response, JSON_NUMERIC_CHECK);
    }
}
