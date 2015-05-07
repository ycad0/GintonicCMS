<?php

namespace GintonicCMS\Model\Entity;

use Cake\ORM\Entity;

class File extends Entity
{
    // Make all fields mass assignable for now.
    protected $_accessible = ['*' => true];

    protected function _getFilepath()
    {
        if (isset($this->_properties['filename'])) {
            return 'files/uploads/' . $this->_properties['filename'];
        }
    }
}