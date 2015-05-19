<?php

namespace GintonicCMS\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

class MessagesTable extends Table
{

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
    
    public function findWithMessages(Query $query, array $options)
    {
        return $query
            ->where(['Messages.id IN' => $options['ids']])
            ->contain(['Users' => ['Files'], 'MessageReadStatuses']);
    }
}
