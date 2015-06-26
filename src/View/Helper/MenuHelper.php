<?php

namespace GintonicCMS\View\Helper;

use Cake\Core\Configure;
use Cake\View\Helper;
use Cake\View\StringTemplateTrait;
use Cake\View\View;

class MenuHelper extends Helper
{

    use StringTemplateTrait;

    /**
     * List of helpers used by this helper
     *
     * @var array
     */
    public $helpers = ['Html'];

    protected $_defaultConfig = [
        'templates' => [
            'li' => '<li{{attrs}}>{{content}}</li>',
        ]
    ];

    /**
     * Allows to highlight menus by returning 'active' (the default class)
     * when the current menu item matches the current request url
     *
     * @param array $url Cake-URL that we compare against current request
     * @return string An `<a />` element.
     */
    public function active($url = null)
    {
        $urldiff = array_diff_assoc($url, $this->request->params);
        if (empty($urldiff)) {
            return ' active';
        }
        return '';
    }

    /**
     * Allows to create highlighted menus by creating <li> with class='active'
     * (the default class for bootstrap menus) containing a regular escaped link
     *
     * @param string $title The content to be wrapped by <a> tags.
     * @param string|array|null $url Cake-relative URL or array of URL parameters, or
     *   external URL (starts with http://)
     * @param array $options Array of options and HTML attributes.
     * @return string An `<a />` element.
     * @link http://book.cakephp.org/3.0/en/views/helpers/html.html#creating-links
     */
    public function li($title, $url = null, array $options = [])
    {
        if (empty(array_diff_assoc($url, $this->request->params))) {
            if (isset($options['class'])) {
                $options['class'] .= ' active';
            } else {
                $options['class'] = 'active';
            }
        }
        $templater = $this->templater();
        return $templater->format('li', [
            'attrs' => $templater->formatAttributes($options),
            'content' => $this->Html->link($title, $url, ['escape' => false])
        ]);
    }
}
