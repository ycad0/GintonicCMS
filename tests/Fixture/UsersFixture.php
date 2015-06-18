<?php

namespace GintonicCMS\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class UsersFixture extends TestFixture
{
    public $fields = [
        'id' => ['type' => 'integer'],
        'email' => ['type' => 'string', 'length' => 255],
        'password' => ['type' => 'string', 'length' => 255],
        'first' => ['type' => 'string', 'length' => 255],
        'last' => ['type' => 'string', 'length' => 255],
        'verified' => ['type' => 'integer'],
        'token' => ['type' => 'string', 'length' => 255],
        'token_creation' => ['type' => 'datetime'],
        'created' => 'datetime',
        'modified' => 'datetime',
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']]
        ]
    ];
    
    public $records = [
        [
            'id' => 1,
            'email' => 'blackhole@blackhole.io',
            'password' => '123456',
            'first' => 'Philippe',
            'last' => 'Lafrance',
            'verified' => 1,
            'token' => 'jhfkjd456d4sgdsg',
            'token_creation' => '2007-05-18 10:39:23',
            'created' => '2007-03-18 10:39:23',
            'modified' => '2007-04-18 15:50:00',
        ],
        [
            'id' => 2,
            'email' => 'blackhole@blackhole.io',
            'password' => '123456',
            'first' => 'Test2',
            'last' => 'Test2',
            'verified' => 1,
            'token' => 'jhsfkjd456d4sgdsg',
            'token_creation' => '2008-05-18 10:39:23',
            'created' => '2008-04-18 10:39:23',
            'modified' => '2008-09-18 15:50:00',
        ],
        [
            'id' => 3,
            'email' => 'blackhole@blackhole.io',
            'password' => '123456',
            'first' => 'Test3',
            'last' => 'Test3',
            'verified' => 1,
            'token' => 'jhfkjdygh456d4sgdsg',
            'token_creation' => '2009-03-18 10:39:23',
            'created' => '2009-03-18 10:39:23',
            'modified' => '2009-04-18 15:50:00',
        ],
        [
            'id' => 4,
            'email' => 'blackhole@blackhole.io',
            'password' => '123456',
            'first' => 'Test4',
            'last' => 'Test4',
            'verified' => 1,
            'token' => 'jhfkjd456d4sgdsg',
            'token_creation' => '2010-03-18 10:39:23',
            'created' => '2010-03-18 10:39:23',
            'modified' => '2010-04-18 15:50:00',
        ],
        [
            'id' => 5,
            'email' => 'blackhole@blackhole.io',
            'password' => '123456',
            'first' => 'Test5',
            'last' => 'Test5',
            'verified' => 1,
            'token' => 'jhfkjd456d4sgdsg',
            'token_creation' => '2010-03-18 10:39:23',
            'created' => '2010-03-18 10:39:23',
            'modified' => '2010-04-18 15:50:00',
        ]
    ];

}
