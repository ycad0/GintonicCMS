<?php

namespace GintonicCMS\Model\Table;

use Cake\Core\Configure;
use Cake\I18n\Time;
use Cake\ORM\Table;

class AlbumPhotosTable extends Table
{
    /**
     * TODO: docblock
     */
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                ]
            ]
        ]);
        
        $this->belongsTo('GintonicCMS.Files', [
            'className' => 'GintonicCMS.Files',
            'foreignKey' => 'file_id',
            'propertyName' => 'file',
        ]);
    }
}
