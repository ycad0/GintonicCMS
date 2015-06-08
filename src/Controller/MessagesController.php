<?php

namespace GintonicCMS\Controller;

use App\Controller\AppController;
use Cake\Core\Plugin;
use Cake\Event\Event;

class MessagesController extends AppController
{
    public $paginate = ['maxLimit' => 5];

    /**
     * TODO: doccomment
     */
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * TODO: doccomment
     */
    public function isAuthorized($user = null)
    {
        return true;
    }

    /**
     * TODO: doccomment
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow();
        if (Plugin::loaded('GintonicCMS')) {
            $this->loadModel('GintonicCMS.Users');
        }
    }

    /**
     * TODO: Write Document.
     */
    public function send()
    {
        $this->autoRender = false;
        $threadUsers = $this->Messages->Threads->find('participants', [
            'threadId' => $this->request->data['thread_id']
        ]);
        
        foreach ($threadUsers as $key => $user) {
            $this->request->data['message_read_statuses'][] = [
                'user_id' => $user['_matchingData']['Users']['id'],
                'status' => 0
            ];
        }
        
        $this->request->data['user_id'] = $this->request->Session()->read('Auth.User.id');
        
        $message = $this->Messages->newEntity(
            $this->request->data,
            ['associated' => ['MessageReadStatuses']]
        );
        $status['status'] = 'fail';
        if ($this->Messages->save($message)) {
            $status['status'] = 'ok';
        }
        echo json_encode($status);
    }

    /**
     * TODO: Write Document. this method only mark as read.
     */
    public function read()
    {
        $this->autoRender = false;
        $status['status'] = 'fail';
        $userId = $this->request->Session()->read('Auth.User.id');
        
        if ($this->Messages->markAsRead($this->request->data['messageIds'], $userId)) {
            $status['status'] = 'ok';
        }
        echo json_encode($status);
    }

    /**
     * TODO: Write Document. this method only mark as read.
     */
    public function delete()
    {
        $this->autoRender = false;
        $status['status'] = 'fail';
        $userId = $this->request->Session()->read('Auth.User.id');
        
        if ($this->Messages->markAsDelete($this->request->data['messageIds'], $userId)) {
            $status['status'] = 'ok';
        }
        echo json_encode($status);
    }

    /**
     * TODO: Write Document. this method only mark as read.
     */
    public function unread()
    {
        $this->autoRender = false;
        $status['status'] = 'fail';
        $userId = $this->request->Session()->read('Auth.User.id');
        
        if ($this->Messages->markAsUnread($this->request->data['messageIds'], $userId)) {
            $status['status'] = 'ok';
        }
        echo json_encode($status);
    }
}
