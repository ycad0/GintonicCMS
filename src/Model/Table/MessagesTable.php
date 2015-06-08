<?php

namespace GintonicCMS\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

class MessagesTable extends Table
{
    const UNREAD = 0;
    const READ = 1;
    const DELETED = 2;
    /**
     * TODO: doccomment
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->addAssociations([
            'belongsTo' => [
                'GintonicCMS.Threads',
                'GintonicCMS.Users'
            ],
            'hasMany' => ['GintonicCMS.MessageReadStatuses']
        ]);

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'modified' => 'always'
                ]
            ]
        ]);
    }
    
    /**
     * TODO: Write Document
     */
    public function findWithMessages(Query $query, array $options)
    {
        return $query
            ->where(['Messages.id IN' => $options['ids']])
            ->contain(['Users' => ['Files'], 'MessageReadStatuses']);
    }
    
    /**
     * TODO: Write Document
     */
    public function findWithUsers(Query $query, array $options)
    {
        return $query
            ->where([
                'Messages.user_id IN' => $options['userIds'],
                'thread_id IN' => $options['threadIds']
            ])
            ->contain(['Users' => ['Files']])
            ->group(['Messages.user_id'])
            ->order(['Messages.created' => 'asc']);
    }
    
    /**
     * TODO: Write Document
     */
    public function findWithThreads(Query $query, array $options)
    {
        return $query
            ->where([
                'thread_id IN' => $options['threadIds']
            ])
            ->contain(['Users' => ['Files']])
            ->group(['Messages.user_id'])
            ->order(['Messages.created' => 'asc']);
    }

    /**
     * Mark Messages as read.
     * @param array $messageIds array of message id that need to mark as read
     * @param int $userId user id of the user of which messages will mark as read.
     * @return int total affected rows count.
     */
    public function markAsRead($messageIds, $userId)
    {
        return $this->MessageReadStatuses->updateAll(['status' => self::READ], [
            'user_id' => $userId,
            'message_id IN' => $messageIds
        ]);
    }

    /**
     * Mark Messages as deleted.
     * @param array $messageIds array of message id that need to mark as read
     * @param int $userId user id of the user of which messages will mark as read.
     * @return int total affected rows count.
     */
    public function markAsDelete($messageIds, $userId)
    {
        return $this->MessageReadStatuses->updateAll(['status' => self::DELETED], [
            'user_id' => $userId,
            'message_id IN' => $messageIds
        ]);
    }

    /**
     * Mark Messages as unread.
     * @param array $messageIds array of message id that need to mark as unread
     * @param int $userId user id of the user of which messages will mark as read.
     * @return int total affected rows count.
     */
    public function markAsUnread($messageIds, $userId)
    {
        return $this->MessageReadStatuses->updateAll(['status' => self::UNREAD], [
            'user_id' => $userId,
            'message_id IN' => $messageIds
        ]);
    }
}
