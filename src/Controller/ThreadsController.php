<?php

namespace GintonicCMS\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class ThreadsController extends AppController
{

    /**
     * TODO: Write comment
     */
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * TODO: Write comment
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow([
            'create',
            'addParticipants',
            'removeParticipants',
            'getThread',
            'retrieve',
            'getUnreadCount',
            'getUnreadThreads'
        ]);
    }

    /**
     * TODO: Write comment
     */
    public function isAuthorized($user = null)
    {
        return true;
        //parent::isAuthorized($user);
    }

    /**
     * TODO: Write comment
     */
    public function create()
    {
        $this->autoRender = false;
        $data = $this->request->data['participants'];
        $threadUser = [];
        foreach ($data as $key => $id) {
            $threadUser['users'][] = ['id' => (int) $id];
        }

        $thread = $this->Threads->newEntity($threadUser, [
            'associated' => ['Users']
        ]);

        $this->Threads->save($thread);
        echo json_encode($thread->id, JSON_NUMERIC_CHECK);
    }

    /**
     * TODO: Write comment
     */
    public function addParticipants()
    {
        $this->autoRender = false;
        $isAdded = $this->Threads->addParticipants($this->request->data['participants'], $this->request->data['threadId']);
        echo json_encode($isAdded, JSON_NUMERIC_CHECK);
    }

    /**
     * TODO: Write comment
     */
    public function removeParticipants()
    {
        $this->autoRender = false;
        $isremoved = $this->Threads->removeParticipants($this->request->data['participants'], $this->request->data['threadId']);
        echo json_encode($isremoved, JSON_NUMERIC_CHECK);
    }

    /**
     * TODO: Write comment.
     */
    public function getThread()
    {
        $this->autoRender = false;
        $threadDetails = $this->Threads->getThreadDetailById($this->request->data['threadId']);
        echo json_encode($threadDetails, JSON_NUMERIC_CHECK);
    }

    /**
     * TODO: Write comment
     */
    public function retrieve()
    {
        $this->autoRender = false;
        $participants = $this->request->data['participants'];
        $threads = $this->Threads
            ->find('withParticipants', ['ids' => $participants])
            ->find('participantCount', ['count' => count($participants)])
            ->order(['Threads.created' => 'DESC'])
            ->first();
        echo json_encode($threads, JSON_NUMERIC_CHECK);
    }

    /**
     * TODO: Write Comment
     */
    public function unreadCount()
    {
        $this->autoRender = false;
        $this->request->data['users'] = 2;
        $this->loadModel('GintonicCMS.Messages');
        
        $threadCount = $this->Threads->Messages
            ->find('unread', ['userId' => $this->request->data['users']])
            ->count();
        debug($threadCount);
        exit;
        echo json_encode($threadCount, JSON_NUMERIC_CHECK);
    }

    /**
     * TODO: Write Comment
     */
    public function get()
    {
        $this->autoRender = false;
        $threadIds = [1, 2];
        exit;
    }
}
