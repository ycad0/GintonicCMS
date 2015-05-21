<?php

namespace GintonicCMS\Controller;

use Cake\Event\Event;
use Cake\ORM\TableRegistry;
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
            'unread'
            'unreadCount',
        ]);
    }

    /**
     * TODO: Write comment
     */
    public function addUsers()
    {
        $this->autoRender = false;
        $users = $this->Users->find()->where(
            'User.id' => $this->request->data['users']
        );
        $this->Threads->Users->link(
            $this->request->data['thread']['id'],
            $users->toArray(),
        );
        echo json_encode($success, JSON_NUMERIC_CHECK);
    }

    /**
     * TODO: Write comment
     */
    public function create()
    {
        $this->autoRender = false;
        $thread = $this->Threads->newEntity(
            $this->request->data['users'], 
            ['associated' => ['Users']]
        );
        $this->Threads->save($thread);
        echo json_encode($thread->id, JSON_NUMERIC_CHECK);
    }

    /**
     * TODO: Write Comment
     */
    public function get()
    {
        $this->autoRender = false;
        $threads = $this->Threads
            ->find('details', $this->request->data['threads']);
        echo json_encode($threads, JSON_NUMERIC_CHECK);
    }

    /**
     * TODO: Write comment
     */
    public function removeUsers()
    {
        $this->autoRender = false;
        $users = $this->Users->find()->where(
            'User.id' => $this->request->data['users']
        );
        $success = $this->Threads->Users->unlink(
            $this->request->data['thread']['id'],
            $users->toArray()
        );
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
            ->find('withUsers', $users])
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
