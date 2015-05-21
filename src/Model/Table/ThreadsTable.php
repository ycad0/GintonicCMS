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
    public function findWithUsers(Query $query, array $options)
    {
        return $query
            ->matching('Users', function ($q) use ($options) {
                return $q
                    ->select(['Threads.id'])
                    ->where(['Users.id IN ' => $options['users']]);
            });
    }

    /**
     * TODO: doccomment
     */
    public function findDetails(Query $query, array $options)
    {
        return $query
            ->where(['Threads.id' => $options['threads']])
            ->contain([
                'Messages' => [
                    'Users' => [
                        'Files'
                    ]
                ]
            ])
            ->limit(10);
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
                        'Threads.id' => $options['threadIds']
                    ]);
            });
    }
    
    /**
     * TODO: doccomment
     */
    public function findWithUserCount(Query $query, array $options)
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
                return $q->where([
                    'MessageReadStatuses.status' => 0,
                ]);
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
                    ->where([
                        'MessageReadStatuses.status' => 2,
                    ]);
            });
    }
}
