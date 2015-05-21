<?php
namespace GintonicCMS\Controller\Admin;

use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use GintonicCMS\Controller\AppController;

class FilesController extends AppController
{
    public $helpers = array('Number', 'Time');

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
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->layout = 'default';
        if ($this->RequestHandler->responseType() == 'json') {
            $this->RequestHandler->setContent('json', 'application/json');
        }
    }

    /**
     * TODO: blockcomment
     */
    public function index($userId = 0)
    {
        if ($this->request->session()->read('Auth.User.role') != 'admin') {
            $this->Flash->set(__('You are not signed in.'), [
                'element' => 'GintonicCMS.alert',
                'params' => ['class' => 'alert-danger']
            ]);
            return $this->redirect([
                'plugin' => 'GintonicCMS',
                'controller' => 'Users',
                'action' => 'signin'
            ]);
        }
        $arrConditions = array();
        if (!empty($userId)) {
            $this->set(compact('userId'));
            $arrConditions = array('user_id' => $userId);
        }
        $files = TableRegistry::get('Files');
        $arrConditions = array('Files.id NOT IN' => $this->request->session()->read('Auth.User.file.id'));
        if ($this->request->session()->read('Auth.User.role') != 'admin') {
            $arrConditions = array('user_id' => $this->request->session()->read('Auth.User.id'));
        }
        $this->paginate = array(
            'conditions' => $arrConditions,
            'order' => array('Files.created' => 'desc'),
            'limit' => 5
        );
        $this->set('files', $this->paginate('Files'));
        $this->render('/Files/index');
    }
    
    /**
     * TODO: write doccomment
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
     * TODO: write doccomment
     */
    public function update()
    {
        $this->layout = false;
        $this->autoRender = false;
        $response = $this->Files->updateFileName($this->request->data);
        echo json_encode($response);
    }
    
    /**
     * TODO: write doccomment
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
}
