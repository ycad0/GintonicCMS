<?php
namespace GintonicCMS\Controller;

use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
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
    public function add()
    {
        // TODO: this whole action is gibberish
        // TODO: wow wow wow wow, security breach below!!!!! We can't let users
        // chose a path in the front-end and save files anywhere they want! O_O
        debug('This method contains a security breach and cannot be used in it\'s current state.');exit;
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
            $totalFiles = count($this->request->data['tmpFile']);
            $count = count($this->request->data['tmpFile']) > 1 ? 0:'';
            $flag = true;
            $title = $this->request->data['title'];

            $dirName = isset($this->request->data['dir'])?$this->request->data['dir']:"";
            $fileIds = $fileNames = [];
            foreach ($this->request->data['tmpFile'] as $key => $name) {
                $tmpFileArray['title'] = !empty($count)?($title . '_' . $count):$title;
                $tmpFileArray['tmpFile'] = $name;
                if (is_uploaded_file($tmpFileArray['tmpFile']['tmp_name'])) {
                    $this->request->data = $this->Files->moveUploaded(
                        $tmpFileArray,
                        $this->Auth->user('id'),
                        $dirName,
                        $count
                    );
                    $this->request->data['dir'] = $dirName;
                    $file = $this->Files->newEntity($this->request->data);
                    unset($file->tmpFile);
                    if ($result = $this->Files->save($file)) {
                        $fileIds[] = $result->id;
                        $fileNames[] = $this->request->data['filename'];
                        $flag = true;
                    } else {
                        $flag = false;
                    }
                }
                $count++;
            }
            if ($totalFiles == 1) {
                $fileId = $fileIds[0];
                $fileName = $fileNames[0];
                $this->set(compact('fileId', 'fileName', 'totalFiles'));
            } else {
                $commaSepratedFileId = implode(', ', $fileIds);
                $commaSepratedFileName = implode(', ', $fileNames);
                $this->set(compact('commaSepratedFileId', 'commaSepratedFileName', 'totalFiles'));
            }
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
        foreach ($fileIds as $key => $id) {
                $files[] = $this->Files->get($id);
        }
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
    public function index()
    {
        if (!$this->request->session()->check('Auth.User.id')) {
            $this->Flash->set(__('You are not signed in.'), [
                'element' => 'GintonicCMS.alert',
                'params' => ['class' => 'alert-danger']
            ]);
            return $this->redirect(['plugin' => 'GintonicCMS', 'controller' => 'Users', 'action' => 'signin']);
        }
        $arrConditions = [];
        $arrConditions = ['Files.id NOT IN' => $this->request->session()->read('Auth.User.file.id')];
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
        $response = $this->Files->updateFileName($this->request->data);
        echo json_encode($response, JSON_NUMERIC_CHECK);
        exit;
    }
}
