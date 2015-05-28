<?php

namespace GintonicCMS\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;

class AlbumsTable extends Table
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
    
    /**
     * TODO: Write Document
     */
    public function findWithFileIds(Query $query, array $options)
    {
        return $query
            ->where(['Albums.file_id IN' => $options['fileIds']])
            ->contain([
                'Files' => [
                    'fields' => ['Files.id', 'Files.filename']
                ]
            ]);
    }
    
    /**
     * TODO: Write Document
     */
    public function findWithUserId(Query $query, array $options)
    {
        return $query
            ->where(['Albums.user_id' => $options['userId']])
            ->contain([
                'Files' => [
                    'fields' => ['Files.id', 'Files.filename']
                ]
            ]);
    }
}
