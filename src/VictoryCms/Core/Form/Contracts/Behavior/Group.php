<?php namespace VictoryCms\Core\Form\Contracts\Behavior;

use VictoryCms\Core\Form\Contracts\Element;

/**
 * Interface Group
 * @package VictoryCms\Core\Form\Contracts\Behavior
 */
interface Group
{
    /**
     * @param Element $element
     * @return Element
     */
    public function add(Element $element);

    /**
     * @param $name
     * @param null $default
     * @return Element
     */
    public function find($name, $default = null);

    /**
     * @return array
     */
    public function getElements();
}