<?php

namespace GintonicCMS\Controller\Component;

use Cake\Collection\Collection;
use Cake\Controller\Component;

class ErrorsComponent extends Component
{
    /**
     * Returns a single string with all validation errors of a single model,
     * with each error delimited by a <br>
     *
     * @param string $entity The entity to extract errors from
     * @return string the list of errors
     */
    public function toList($entity)
    {
        $errors = new Collection($entity->errors());
        $errors = $errors->unfold()->toList();
        return implode('<br/>', $errors);
    }
}
