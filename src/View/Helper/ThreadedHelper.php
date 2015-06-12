<?php

namespace GintonicCMS\View\Helper;

use Cake\Core\Configure;
use Cake\View\Helper;

class ThreadedHelper extends Helper
{
    /**
     * TODO: doc comment
     *
     */
    public function ul(array $items, $key)
    {
        $output = '<ul>';
        foreach ($items as $item) {
            $output .= '<li>' . $item[$key];

            if (!empty($item['children'])) {
                $output .= $this->ul($item['children'], $key);
            }

            $output .= '</li>';
        }
        $output .= '</ul>';
        return $output;
    }
}
