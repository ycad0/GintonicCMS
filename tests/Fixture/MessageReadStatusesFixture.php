<?php

namespace GintonicCMS\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class MessageReadStatusesFixture extends TestFixture
{
    public $fields = [
        'id' => ['type' => 'integer'],
        'message_id' => ['type' => 'integer'],
        'user_id' => ['type' => 'integer'],
        'status' => ['type' => 'integer'],
        'created' => 'datetime',
        'modified' => 'datetime',
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']]
        ]
    ];
    public $records = [
        [
            'id' => 1,
            'message_id' => 1,
            'user_id' => 1,
            'status' => 1,
            'created' => '2010-04-18 15:50:00',
        ],
        [
            'id' => 2,
            'message_id' => 2,
            'user_id' => 2,
            'status' => 1,
            'created' => '2010-04-18 15:50:00',
        ],
        [
            'id' => 3,
            'message_id' => 3,
            'user_id' => 3,
            'status' => 0,
            'created' => '2010-04-18 15:50:00',
        ],
        [
            'id' => 4,
            'message_id' => 4,
            'user_id' => 4,
            'status' => 1,
            'created' => '2010-04-18 15:50:00',
        ],
        [
            'id' => 5,
            'message_id' => 5,
            'user_id' => 2,
            'status' => 0,
            'created' => '2010-04-18 15:50:00',
        ],
        [
            'id' => 6,
            'message_id' => 6,
            'user_id' => 5,
            'status' => 2,
            'created' => '2010-04-18 15:50:00',
        ],
        [
            'id' => 7,
            'message_id' => 7,
            'user_id' => 1,
            'status' => 0,
            'created' => '2010-04-18 15:50:00',
        ]
    ];

}
