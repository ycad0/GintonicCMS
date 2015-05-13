<?php

namespace GintonicCMS\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

class ThreadParticipantsTable extends Table
{
    /**
     * TODO: doccomment
     */
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->primaryKey('id');
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new'
                ]
            ]
        ]);

        $this->addAssociations([
            'belongsTo' => [
                'Threads' => [
                    'className' => 'GintonicCMS.Threads',
                    'foreignKey' => 'thread_id',
                    'propertyName' => 'Thread'
                ],
                'Users' => [
                    'className' => 'GintonicCMS.Users',
                    'foreignKey' => 'user_id',
                    'fields' => ['id', 'first', 'last', 'email'],
                    'propertyName' => 'User'
                ]
            ],
            'hasOne' => ['MessageReadStatuses']
        ]);

        $this->addBehavior('CounterCache', [
            'Threads' => ['thread_participant_count']
        ]);
    }

    /**
     * TODO: doccomment
     */
    public function findParticipantCount(Query $query, array $options)
    {
        return $query
                ->select([
                    'ThreadParticipants.thread_id',
                    'count' => $query->func()->count('ThreadParticipants.thread_id')
                ])
                ->group('ThreadParticipants.thread_id')
                ->having(['count' => $options['count']]);
    }

    /**
     * TODO: doccomment
     */
    public function findWithParticipants(Query $query, array $options)
    {
        return $query
                ->select([
                    'ThreadParticipants.thread_id',
                ])
                ->where(['ThreadParticipants.user_id IN' => $options['participantsIds']]);
    }

    /**
     * TODO: doccomment
     */
    public function getThreadParticipant($threadId = null, $userId = null, $recipientId = null)
    {
        $userIds = array();
        if (!empty($userId)) {
            $userIds[$userId] = $userId;
        }
        if (!empty($recipientId)) {
            $userIds[$recipientId] = $recipientId;
        }
        $threadParticipant = $this->find()
            ->where(['thread_id' => $threadId, 'user_id IN' => $userIds])
            ->first();
        if (!empty($threadParticipant)) {
            return $threadParticipant->id;
        }
        return 0;
    }

    /**
     * TODO: doccomment
     */
    public function getThreadOfUsers($threadId = null)
    {
        $userList = $this->find()
            ->where(['ThreadParticipants.thread_id' => $threadId])
            ->combine('user_id', 'user_id')
            ->toArray();
        $this->Users = TableRegistry::get('GintonicCMS.Users');
        $userList = $this->Users->find('list', ['keyField' => 'id', 'valueField' => 'first'])
            ->where(['Users.id IN' => $userList])
            ->toArray();
        return $userList;
    }
}
