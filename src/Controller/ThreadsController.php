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
        // thread id recieved via POST variable
        // find last 10 messages for thread
        // find participant list for thread
        // return both arrays via JSON
        $this->autoRender = false;
        $threadDetails = $this->Threads->getThreadDetailById($this->request->data['threadId']);
        echo json_encode($threadDetails);
    }

    /**
     * TODO: Write comment
     */
    public function retrieve()
    {
        // receive an array of participant ids via POST request
        // CUSTOM FINDER: only threads with the exact count of participants
        // CUSTOM FINDER: only threads where the participants are registered
        // Find the last thread that match both custom finders above
        // Find last 10 messages in the thread
        // Return both arrays via JSON
        //$this->Threads->find('withParticipants', $participantsIds)->find('participantCount', count($participantsIds))->order('Thread.created' => 'DESC')->first()
        $threadDetails = $this->Threads->retrieve($this->request->data['participants']);
        echo json_encode($threadDetails);
    }
}
