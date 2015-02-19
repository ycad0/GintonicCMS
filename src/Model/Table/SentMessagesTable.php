<?php
namespace GintonicCMS\Model\Table;

use Cake\ORM\Table;

class SentMessagesTable extends Table
{

    public function initialize(array $config) 
    {
        parent::initialize($config);
        $this->primaryKey('id');
        
        $this->belongsTo('Users', [
            'className' => 'GintonicCMS.Users',
            'foreignKey' => 'user_id',
            'propertyName' => 'sent',
        ]);
    }
    
}
?>
