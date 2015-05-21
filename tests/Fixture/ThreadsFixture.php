<?php

namespace GintonicCMS\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class ThreadsFixture extends TestFixture
{

      // Optional. Set this property to load fixtures to a different test datasource
      // public $connection = 'test';

      public $fields = [
          'id' => ['type' => 'integer'],
          'created' => 'datetime',
          'modified' => 'datetime',
          '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']]
          ]
      ];
      public $records = [
          [
              'id' => 1,
              'created' => '2007-03-18 10:39:23',
              'modified' => '2007-03-18 10:41:31'
          ],
          [
              'id' => 2,
              'created' => '2007-03-18 10:41:23',
              'modified' => '2007-03-18 10:43:31'
          ],
          [
              'id' => 3,
              'created' => '2007-03-18 10:43:23',
              'modified' => '2007-03-18 10:45:31'
          ]
      ];
 }
