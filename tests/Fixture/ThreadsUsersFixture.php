<?php

namespace GintonicCMS\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class ThreadsUsersFixture extends TestFixture
{
    public $fields = [
        'id' => ['type' => 'integer'],
        'thread_id' => ['type' => 'integer'],
        'user_id' => ['type' => 'integer'],
        'created' => 'datetime',
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']]
        ]
    ];
    
    public $records = [
        [
            'id' => 1,
            'thread_id' => 1,
            'user_id' => 1,
            'created' => '2007-03-18 10:39:23'
        ],
        [
            'id' => 2,
            'thread_id' => 1,
            'user_id' => 2,
            'created' => '2007-03-18 10:39:23'
        ],
        [
            'id' => 3,
            'thread_id' => 2,
            'user_id' => 3,
            'created' => '2007-03-18 10:39:23'
        ],
        [
            'id' => 4,
            'thread_id' => 2,
            'user_id' => 4,
            'created' => '2007-03-18 10:39:23'
        ],
        [
            'id' => 5,
            'thread_id' => 3,
            'user_id' => 2,
            'created' => '2007-03-18 10:39:23'
        ],
        [
            'id' => 6,
            'thread_id' => 3,
            'user_id' => 5,
            'created' => '2007-03-18 10:39:23'
        ],
        [
            'id' => 7,
            'thread_id' => 2,
            'user_id' => 1,
            'created' => '2007-03-18 10:39:23'
        ]
    ];

}
