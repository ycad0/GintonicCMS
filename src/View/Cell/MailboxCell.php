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
        $this->loadModel('GintonicCMS.Threads');
        $this->loadModel('GintonicCMS.Messages');

        $userId = $this->request->session()->read('Auth.User.id');

        $threadIds = $this->Threads
            ->find('withUsers', ['ids' => $userId])
            ->combine('id', 'id');

        $participantsIds = [];
        $messages = [];

        if (!empty($threadIds)) {
            $participantsIds = $this->Threads
                ->find('participant', ['userIds' => $userId, 'threadIds' => $threadIds->toArray()])
                ->select('Users.id');

            foreach ($participantsIds as $key => $value) {
                $participantsUserIds[] = $value->_matchingData['Users']->id;
            }

            if (!empty($participantsUserIds)) {
                $messages = $this->Messages
                    ->find('withUsers', [
                        'userIds' => $participantsUserIds,
                        'threadIds' => $threadIds->toArray()
                    ]);
            }
        }
        $this->set(compact('messages'));
    }
}
