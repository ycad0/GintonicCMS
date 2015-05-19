<?php

namespace GintonicCMS\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

class ThreadsTable extends Table
{

    /**
     * TODO: doccomment
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'modified' => 'always'
                ]
            ]
        ]);

        $this->addAssociations([
            'hasMany' => ['GintonicCMS.Messages'],
            'belongsToMany' => [
                'Users' => [
                    'saveStrategy' => 'append'
                ]
            ]
        ]);
    }

    /**
     * TODO: doccomment
     */
    public function addParticipants($participantsIds = null, $threadId = null)
    {
        if (empty($threadId) || empty($participantsIds)) {
            return false;
        }

        $users = TableRegistry::get('Users');
        $thread = $this->get($threadId);
        if (!empty($thread)) {
            $participants = $users->find()
                ->where(['Users.id IN' => $participantsIds]);
            if (!empty($participants)) {
                if ($this->Users->link($thread, $participants->toArray())) {
                    return true;
                }
            }
        }
    }

    /**
     * TODO: doccomment
     */
    public function removeParticipants($participantsIds = null, $threadId = null)
    {
        if (empty($threadId) || empty($participantsIds)) {
            return false;
        }

        $thread = $this->get($threadId);
        if (!empty($thread)) {
            echo 'error';
            exit;
            $this->ThreadUsers = TableRegistry::get('Messages.ThreadParticipants');
            $removedCount = $this->ThreadUsers->deleteAll(['thread_id' => $threadId, 'user_id IN ' => $participantsIds]);
            if ($removedCount) {
                return true;
            }
        }
        return false;
    }

    /**
     * TODO: doccomment
     */
    public function getThreadDetailById($threadId = null)
    {
        $messages = TableRegistry::get('Messages');
        //$messages = $messages->getMessageByThreadId($threadId);
        $threadDetails['messages'] = $messages->find()
            ->where(['Messages.thread_id' => $threadId])
            ->limit(10);
        //$threadDetails['participants'] = $this->ThreadParticipants->find('list', [
        //        'keyField' => 'id',
        //        'valueField' => 'user_id'
        //    ])
        //    ->where(['ThreadParticipants.thread_id' => $threadId]);
        return $threadDetails;
    }

    /**
     * TODO: doccomment
     */
    public function findWithUsers(Query $query, array $options)
    {
        return $query
                ->matching('Users', function ($q) use ($options) {
                    return $q
                        ->select(['Threads.id'])
                        ->where(['Users.id IN ' => $options['ids']]);
                });
    }

    /**
     * TODO: doccomment
     */
    public function findWithThreads(Query $query, array $options)
    {
        return $query
            ->where(['Threads.id IN' => $options['ids']])
            ->contain(['Messages' => ['Users' => ['Files']]]);
    }
    
    /**
     * TODO: doccomment
     */
    public function findParticipant(Query $query, array $options)
    {
        return $query
                ->matching('Users', function ($q) use ($options) {
                    return $q
                        ->select(['Users.id'])
                        ->where([
                            'Users.id NOT IN ' => $options['userIds'],
                            'Threads.id IN' => $options['threadIds']
                        ]);
                });
    }
    
    /**
     * TODO: doccomment
     */
    public function findParticipantCount(Query $query, array $options)
    {
        return $query
                ->matching('Users', function ($q) use ($options) {
                    return $q
                        ->select([
                            'Threads.id',
                            'count' => $q->func()->count('Users.id')
                        ])
                        ->group('Threads.id')
                        ->having(['count' => $options['count']]);
                });
    }

    /**
     * TODO: Write Comment
     */
    public function findUnread(Query $query, array $options)
    {
        return $query
                ->matching('Messages.MessageReadStatuses', function ($q) use ($options) {
                    return $q
                        ->where(['MessageReadStatuses.status' => 0, 'MessageReadStatuses.user_id IN' => $options['ids']]);
                });
    }
    
    /**
     * TODO: Write Comment
     */
    public function findDeleted(Query $query, array $options)
    {
        return $query
                ->matching('Messages.MessageReadStatuses', function ($q) use ($options) {
                    return $q
                        ->where(['MessageReadStatuses.status' => 2, 'MessageReadStatuses.user_id IN' => $options['ids']]);
                });
    }

    /**
     * TODO: doccomment
     */
    public function getThread($userId = null, $recipientId = null, $threadUserIds = [])
    {
        echo 'error';
        exit;
        $this->ThreadParticipants = TableRegistry::get('GintonicCMS.ThreadParticipants');
        $participantsUsers = [$userId, $recipientId];
        if (empty($recipientId) && !empty($threadUserIds)) {
            $threadUserIds[] = $userId;
            $participantsUsers = $threadUserIds;
        }
        $threadQuery = $this->ThreadParticipants->find()
            ->where(['ThreadParticipants.user_id IN' => $participantsUsers]);

        $threads = $threadQuery->select([
                'ThreadParticipants.thread_id',
                'count' => $threadQuery->func()->count('ThreadParticipants.thread_id')
            ])
            ->group('ThreadParticipants.thread_id')
            ->having(['count' => count($participantsUsers)])
            ->toArray();

        if (empty($threads) && empty($recipientId) && empty($threadUserIds)) {
            return 0;
        }
        if (empty($threads)) {
            $data['user_id'] = $userId;
            $threadResult = $this->save($this->newEntity($data));
            $data = [];
            $data['thread_id'] = $threadId = $threadResult->id;
            foreach ($participantsUsers as $threadUserId) {
                $data['user_id'] = $threadUserId;
                $threads[] = $this->ThreadParticipants->save($this->ThreadParticipants->newEntity($data));
            }
        } else {
            $threadId = $threads[0]['thread_id'];
        }
        return $threadId;
    }

    /**
     * TODO: doccomment
     */
    public function getGroups($userId = null)
    {
        $threads = $this->find('list', ['keyField' => 'id', 'valueField' => 'id'])
            ->where(['Threads.thread_participant_count >' => 2])
            ->toArray();
        echo 'error';
        exit;
        $this->ThreadParticipants = TableRegistry::get('GintonicCMS.ThreadParticipants');
        $threadIds = $this->ThreadParticipants->find('list', ['keyField' => 'thread_id', 'valueField' => 'thread_id'])
            ->where(['ThreadParticipants.thread_id IN' => $threads, 'ThreadParticipants.user_id' => $userId])
            ->toArray();
        $groups = array();
        $count = 0;
        foreach ($threadIds as $threadId) {
            $groups[$threadId] = 'Group-' . $count++;
        }
        return $groups;
    }

    /**
     * TODO: doccomment
     */
    public function getGroupAdmin($threadId = null)
    {
        $userData = $this->find()
            ->where(['Threads.id' => $threadId])
            ->contain(['Users' => function ($userQuery) {
                    return $userQuery
                        ->select(['id', 'first', 'last', 'email']);
                }])
                ->first()
                ->toArray();
            return $userData['user_thread'];
        }
    }
    