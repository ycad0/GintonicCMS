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
namespace GintonicCMS\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;

/**
 * Represents the Threads Table
 *
 * A thread is a sequence of messages sent by registered users (participants).
 * A thread can be used to represent a chat log, or could also be used to track
 * messages in the same fashion as an email conversation do.
 */
class ThreadsTable extends Table
{

    /**
     * Initilize the Thread Table.
     * also set Relationship of this Table with other tables and add
     * required behaviour for this Table.
     *
     * @param array $config configuration array for Table.
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
     * Dynamic finder that find threads where a given set of users are
     * participants
     *
     * @param \Cake\ORM\Query $query the original query to append to
     * @param array $users the list of users id formatted according to cake stadards
     * @return \Cake\ORM\Query The amended query
     */
    public function findWithUsers(Query $query, array $users)
    {
        return $query
            ->matching('Users', function ($q) use ($users) {
                return $q
                    ->select(['Threads.id'])
                    ->where(['Users.id' => $users]);
            });
    }

    /**
     * Dynamic finder that find thread details by taking thread ids as argument.
     * Thread details consist of Messages of each Thread provided in argument.
     * And each Message also contain details of related Users of that Message.
     *
     * @param \Cake\ORM\Query $query the original query to append to
     * @param array $options the list of thread id formatted according to cake stadards
     * @return \Cake\ORM\Query The amended query
     */
    public function findDetails(Query $query, array $options)
    {
        return $query
            ->where(['Threads.id' => $options])
            ->contain([
                'Messages' => [
                    'Users'
                ]
            ])
            ->limit(10);
    }
    
    /**
     * Dynamic finder that find thread Id based on total number of participants.
     * it's take Total Number of participant as agrument and find the thread id,
     * which have exact that numbers of participants.
     *
     * @param \Cake\ORM\Query $query the original query to append to
     * @param array $options total numbers of participants formatted according to cake stadards
     * @return \Cake\ORM\Query The amended query
     */
    public function findWithUserCount(Query $query, array $options)
    {
        return $query
            ->matching('Users')
            ->select([
                'Threads.id'
            ])
            ->group('Threads.id')
            // TODO: find the pragmatic way to achieve this
            ->having('COUNT(Users.id) = ' . $options['count']);
    }

    /**
     * Dynamic finder that find thread Id which has unread messages.
     *
     * @param \Cake\ORM\Query $query the original query to append to
     * @param array $options not required
     * @return \Cake\ORM\Query The amended query
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
     * Dynamic finder that find thread Id which has deleted messages.
     *
     * @param \Cake\ORM\Query $query the original query to append to
     * @param array $options not required
     * @return \Cake\ORM\Query The amended query
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
