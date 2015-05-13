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
        $this->Auth->allow(['create', 'addParticipants', 'removeParticipants', 'getThread', 'retrieve']);
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
    public function create($participantIds = null)
    {
        $this->autoRender = false;
        $userId = $this->request->session()->read('Auth.User.id');
        $threadId = $this->Threads->create($this->request->data, $userId);
        echo json_encode($threadId);
    }

    /**
     * TODO: Write comment
     */
    public function addParticipants()
    {
        $this->autoRender = false;
        $isAdded = $this->Threads->addParticipants($this->request->data['participants'], $this->request->data['threadId']);
        echo json_encode($isAdded);
    }

    /**
     * TODO: Write comment
     */
    public function removeParticipants()
    {
        $this->autoRender = false;
        $isremoved = $this->Threads->removeParticipants($this->request->data['participants'], $this->request->data['threadId']);
        echo json_encode($isremoved);
    }

    /**
     * TODO: Write comment.
     */
    public function getThread()
    {
        $this->autoRender = false;
        $threadDetails = $this->Threads->getThreadDetailById($this->request->data['threadId']);
        echo json_encode($threadDetails);
    }

    /**
     * TODO: Write comment
     */
    public function retrieve()
    {
        $this->autoRender = false;
        $threadDetails = $this->Threads->retrieve($this->request->data['participants']);
        echo json_encode($threadDetails);
    }
}
