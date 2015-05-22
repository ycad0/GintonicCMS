<?php

namespace GintonicCMS\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class MessagesFixture extends TestFixture
{
    public $fields = [
        'id' => ['type' => 'integer'],
        'user_id' => ['type' => 'integer'],
        'thread_id' => ['type' => 'integer'],
        'title' => ['type' => 'string', 'length' => 255],
        'body' => ['type' => 'text'],
        'created' => 'datetime',
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']]
        ]
    ];
    
    public $records = [
        [
            'id' => 1,
            'user_id' => 1,
            'thread_id' => 1,
            'title' => 'test',
            'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:41:31'
        ],
        [
            'id' => 2,
            'user_id' => 2,
            'thread_id' => 1,
            'title' => 'test',
            'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:41:31'
        ],
        [
            'id' => 3,
            'user_id' => 3,
            'thread_id' => 2,
            'title' => 'test',
            'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:41:31'
        ],
        [
            'id' => 4,
            'user_id' => 4,
            'thread_id' => 2,
            'title' => 'test',
            'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:41:31'
        ],
        [
            'id' => 5,
            'user_id' => 2,
            'thread_id' => 3,
            'title' => 'test',
            'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:41:31'
        ],
        [
            'id' => 6,
            'user_id' => 5,
            'thread_id' => 3,
            'title' => 'test',
            'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:41:31'
        ],
        [
            'id' => 7,
            'user_id' => 1,
            'thread_id' => 2,
            'title' => 'test',
            'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-03-18 10:41:31'
        ]
    ];

}
