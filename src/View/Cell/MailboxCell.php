<?php

namespace GintonicCMS\View\Cell;

use Cake\View\Cell;

/**
 * Mailbox cell
 */
class MailboxCell extends Cell
{
    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * TODO: write doccomment
     */
    public function display()
    {
        $this->loadModel('GintonicCMS.Users');
        $this->loadModel('GintonicCMS.Messages');
        $this->loadModel('GintonicCMS.ThreadParticipants');

        $userId = $this->request->session()->read('Auth.User.id');

        $threadIds = $this->ThreadParticipants->find('all')
                ->where(['ThreadParticipants.user_id' => $userId])
                ->combine('id', 'thread_id');
        $participantsIds = [];
        $messages = [];
        $threads = [];
        if (!empty($threadIds)) {
            $participantsIds = $this->ThreadParticipants->find('all')
                    ->where([
                        'ThreadParticipants.user_id !=' => $userId,
                        'thread_id IN' => $threadIds->toArray(),
                        'MessageReadStatuses.status' => 0
                    ])
                    ->contain(['MessageReadStatuses'])
                    ->combine('id', 'user_id');
            if (!empty($participantsIds)) {
                $messages = $this->Messages->find('all')
                        ->where([
                            'Messages.user_id IN ' => $participantsIds->toArray(),
                            'thread_id IN ' => $threadIds->toArray()
                        ])
                        ->contain(['Sender' => ['Files']])
                        ->group(['Messages.user_id'])
                        ->order(['Messages.created' => 'asc']);
            }
        }
        $this->set(compact('messages'));
    }
}
