<?php

namespace GintonicCMS\Model\Table;

use Cake\ORM\Table;
use Cake\Network\Session;
use Cake\Validation\Validator;
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;
use Cake\Network\Email\Email;
use Cake\I18n\Time;
use Cake\Auth\DefaultPasswordHasher;

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
        
        $this->addAssociations([
            'belongsTo' => ['Files'=>[
                'className' => 'GintonicCMS.Files',
                'foreignKey' => 'file_id',
                'propertyName' => 'file'
            ]],
        ]);
    }
}
