<?php

/**
 * GintonicCMS : Full Stack Content Management System (http://cms.gintonicweb.com)
 * Copyright (c) Philippe Lafrance, Inc. (http://phillafrance.com)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Philippe Lafrance (http://phillafrance.com)
 * @link          http://cms.gintonicweb.com GintonicCMS Project
 * @since         0.0.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace GintonicCMS\Controller;

use Cake\Event\Event;
use GintonicCMS\Controller\AppController;

/**
 * Represents the Threads Table
 *
 * A thread is a sequence of messages sent by registered users (participants).
 * A thread can be used to represent a chat log, or could also be used to track
 * messages in the same fashion as an email conversation do.
 */
class ThreadsController extends AppController
{

    /**
     * Call before executoin of every request, also set some action
     * to access without login.
     *
     * @param Cake\Event\Event $event Describe the Events.
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
     * Used to Authorized User to access requested action.
     *
     * @param array $user contain user detail.
     * @return boolean Return true if action is allowed else return false.
     */
    public function isAuthorized($user = null)
    {
        if (!empty($user)) {
            return true;
        }
        return parent::isAuthorized($user);
    }

    /**
     * Allow to Add new users in Existing Thread.
     * its take array of POST data as input.
     * for Example $this->request->data['users'] = [2, 3],
     * $this->request->data['threadId'] = 2
     * then it will add user with id 2 and 3 in thread with Id 2
     * and return true if success else return false.
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
     * Allow to create New Thread,
     * its take array of useIds by POST method as input.
     * for Example $this->request->data['users'] = [2, 3]
     * then it will create new Thread with user id 2 and 3 as Participant of that thread
     * and return Thread Id of new created thread.
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
     * This Method take thread id as POST data input
     * for Example $this->request->data['threads'] = [1, 2]
     * then it Return detail of threads with 1 and 2.
     * in thread detail it contain Message details, related to thread id and,
     * User details, related to Messages.
     */
    public function get()
    {
        $this->autoRender = false;
        $threads = $this->Threads->find('details', $this->request->data['threads']);
        echo json_encode($threads, JSON_NUMERIC_CHECK);
    }

    /**
     * Allow to remove thread participants from existing thread.
     * its take array of user ids and thread id as POST data in input and remove that
     * user Ids from thread.
     * for Example $this->request->data['users'] = [2] and $this->request->data['threadId'] = 1
     * then it will remove user whith id 2 from Thread with id 1.
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
     * This method gives Thread id based on participant count.
     * its take array of user id as POST input
     * for Example $this->request->data['users'] = [2,3]
     * and return thread id which have exact count participant is 2
     * because there is two user id in input array.
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
     * This Method allow to get Thread id which have unread messages.
     * its take array of user id as POST input and give thread id based on that
     * if that user's hase any unread Messages.
     * for Example $this->request->data['users'] = [2] then
     * this method will return thread id if user 2 has any unread message else
     * return false;
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
     * This Method allow to get total count of unread Thread which have unread messages.
     * its take array of user id as POST input and give count based on that
     * if that user's hase any unread Messages.
     * for Example $this->request->data['users'] = [2] then
     * this method will return count of unread thread if user 2 has any unread message else
     * return false;
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
