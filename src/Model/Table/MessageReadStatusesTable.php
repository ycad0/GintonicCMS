<?php

namespace GintonicCMS\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

class MessageReadStatusesTable extends Table
{
    /**
     * TODO: docbloc
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->addAssociations([
            'belongsTo' => ['Messages']
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
