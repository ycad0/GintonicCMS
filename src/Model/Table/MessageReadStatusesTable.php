<?php

namespace GintonicCMS\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

class MessageReadStatusesTable extends Table
{
    /**
     * TODO: docbloc
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->addAssociations([
            'belongsTo' => ['GintonicCMS.Messages']
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
}
