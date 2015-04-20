<?php

namespace GintonicCMS\Model\Table;

use Cake\ORM\Table;
use Cake\Core\Configure;
use Cake\I18n\Time;

class AlbumPhotosTable extends Table {
    
    public function initialize(array $config)
    {
        //for the default add the created and modified
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
    
    public function testr(){
        debug('df');
        exit;
    }
}
