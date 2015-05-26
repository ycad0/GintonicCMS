<?php

namespace GintonicCMS\Controller;

use Cake\Event\Event;
use GintonicCMS\Controller\AppController;

class ThreadsController extends AppController
{
    /**
     * TODO: Write comment
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow([
            'addUsers',
            'create',
            'get',
            'removeUsers',
            'retrieve',
            'unread',
            'unreadCount',
        ]);
    }

    /**
     * TODO: Write Comment.
     */
    public function isAuthorized($user = null)
    {
        if (!empty($user)) {
            return true;
        }
        return parent::isAuthorized($user);
    }

    /**
     * TODO: Write comment
     */
    public function addUsers()
    {
        $this->autoRender = false;
        $users = $this->Threads->Users->find()->where(['Users.id IN' => $this->request->data['users']]);
        $thread = $this->Threads->get($this->request->data['threadId']);
        $success = $this->Threads->Users->link($thread, $users->toArray());
        echo json_encode($success, JSON_NUMERIC_CHECK);
    }

    /**
     * TODO: Write comment
     */
    public function create()
    {
        $this->autoRender = false;
        $thread = $this->Threads->newEntity($this->request->data['users'], ['associated' => ['Users']]);
        $this->Threads->save($thread);
        
        $users = $this->Threads->Users->find()->where(['Users.id IN' => $this->request->data['users']]);
        $this->Threads->Users->link($thread, $users->toArray());
        
        echo json_encode($thread->id, JSON_NUMERIC_CHECK);
    }

    /**
     * TODO: Write Comment
     */
    public function get()
    {
        $this->autoRender = false;
        $threads = $this->Threads->find('details', [$this->request->data['threads']]);
        echo json_encode($threads, JSON_NUMERIC_CHECK);
    }

    /**
     * TODO: Write comment
     */
    public function removeUsers()
    {
        $this->autoRender = false;
        $users = $this->Threads->Users->find()->where([
            'Users.id IN' => $this->request->data['users']
        ]);
        $thread = $this->Threads->get($this->request->data['threadId']);
        $success = $this->Threads->Users->unlink($thread, $users->toArray());
        echo json_encode($success, JSON_NUMERIC_CHECK);
    }

    /**
     * TODO: Write comment
     */
    public function retrieve()
    {
        $this->autoRender = false;
        $users = $this->request->data['users'];
        $threads = $this->Threads
            ->find('withUsers', $users)
            ->find('withUserCount', ['count' => count($users)])
            ->order(['Threads.created' => 'DESC'])
            ->first();
        echo json_encode($threads, JSON_NUMERIC_CHECK);
    }

    /**
     * TODO: Write Comment
     */
    public function unread()
    {
        $this->autoRender = false;
        $threadCount = $this->Threads
            ->find('withUsers', $this->request->data['users'])
            ->find('unread');
        echo json_encode($threadCount, JSON_NUMERIC_CHECK);
    }

    /**
     * TODO: Write Comment
     */
    public function unreadCount()
    {
        $this->autoRender = false;
        $threadCount = $this->Threads
            ->find('withUsers', $this->request->data['users'])
            ->find('unread')
            ->count();
        echo json_encode($threadCount, JSON_NUMERIC_CHECK);
    }
}
