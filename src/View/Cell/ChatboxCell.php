<?php

namespace GintonicCMS\View\Cell;

use Cake\View\Cell;

/**
 * Mailbox cell
 */
class ChatboxCell extends Cell
{
    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [
    ];

    /**
     * TODO: write doccomment
     */
    public function display($recipientId = null, $isGroup = null, $isProhibitUser = null)
    {
        $this->loadModel('GintonicCMS.Users');
        $this->loadModel('GintonicCMS.Threads');
        $this->loadModel('GintonicCMS.ThreadParticipants');
        $this->loadModel('GintonicCMS.Messages');
        $this->loadModel('GintonicCMS.MessageReadStatuses');

        $this->set('title_for_layout', 'Compose Message');
        if (empty($recipientId) && !empty($isGroup) && $isGroup == 'group') {
            $this->set('isGroupChat', true);
            $this->set('chats', array());
        } else {
            $userId = $this->request->session()->read('Auth.User.id');
            $recipientId = (int)$recipientId;
            if ($this->request->is(['put', 'post']) && !empty($this->request->data['body']) && empty($isGroup)) {
                $response = $this->Messages->sentMessage($userId, $this->request->data);
                if ($response['status']) {
                    $message = [
                        'id' => $response['id'],
                        'body' => $this->request->data['body']
                    ];
                    $this->set(compact('message'));
                    $response['content'] = $this->render('GintonicCMS.Element/Messages/new_message', 'ajax')->body();
                }
                echo json_encode($response);
                exit;
            }
            $recipient = $this->Users->find()
                ->where(['Users.id' => $recipientId])
                ->select(['id', 'first', 'last', 'email'])
                ->first();
            if (!empty($recipient)) {
                $recipient = $recipient->toArray();
            }
            $threadId = $this->Threads->getThread($userId, $recipientId);
            $threadParticipantId = $this->ThreadParticipants->getThreadParticipant($threadId, $userId);
            $threadRecipientId = $this->ThreadParticipants->getThreadParticipant($threadId, $recipientId);
            $chats = $this->Messages->find()
                ->where(['Messages.thread_id' => $threadId])
                ->all()
                ->toArray();
            $unReadMessage = $this->getUnreadMessage($threadRecipientId, true);
            $threadMessageList = $this->Messages->find()
                ->where(['Messages.thread_id' => $threadId])
                ->combine('id', 'id')
                ->toArray();
            $deletedMessage = $this->MessageReadStatuses->find('all')
                ->where([
                    'MessageReadStatuses.status' => 2,
                    'MessageReadStatuses.message_id IN' => $threadMessageList
                ])
                ->combine('message_id', 'message_id')
                ->toArray();
            if (!empty($unReadMessage)) {
                $this->MessageReadStatuses->updateAll(
                    ['status' => 1],
                    ['message_id IN' => $unReadMessage]
                );
            }
            $this->set('messageType', 'compose', 'recipient');
            $this->set(compact(
                'isProhibitUser',
                'recipientId',
                'recipient',
                'threadId',
                'threadParticipantId',
                'chats',
                'unReadMessage',
                'threadRecipientId',
                'deletedMessage'
            ));
        }
    }

    /**
     * TODO: write doccomment
     */
    public function getUnreadMessage($participantId = null, $getUnreadMessageId = false)
    {
        if (!empty($participantId) && !empty($getUnreadMessageId)) {
            $query = $this->MessageReadStatuses->find('all')
                ->where(
                    [
                        'MessageReadStatuses.thread_participant_id' => $participantId,
                        'MessageReadStatuses.status' => 0
                    ]
                )
                ->combine('message_id', 'message_id');
            return $query->toArray();
        } else {
            $userId = $this->request->session()->read('Auth.User.id');
            $userList = $participantId;
            if (!empty($participantId)) {
                foreach ($participantId as $key => $user) {
                    $userList[$key]['unread_message'] = 0;
                    $recipantThreads = $this->ThreadParticipants->find()
                        ->where(['ThreadParticipants.user_id' => $userId])
                        ->select(['ThreadParticipants.thread_id'])
                        ->combine('thread_id', 'thread_id')
                        ->toArray();
                    $threads = $this->ThreadParticipants->find()
                        ->where(
                            [
                                'ThreadParticipants.user_id' => $user->id,
                                'ThreadParticipants.thread_id IN' => $recipantThreads
                            ]
                        )
                        ->select(['ThreadParticipants.id'])
                        ->order('ThreadParticipants.thread_id ASC')
                        ->toArray();
                    if (!empty($threads)) {
                        $threadparticipantId = $threads[0]['id'];
                        $userList[$key]['unread_message'] = $this->MessageReadStatuses->find('all')
                            ->where(
                                [
                                    'MessageReadStatuses.thread_participant_id' => $threadparticipantId,
                                    'MessageReadStatuses.status' => 0
                                ]
                            )
                            ->combine('message_id', 'message_id')
                            ->count();
                    }
                }
            }
            return $userList;
        }
    }
}
