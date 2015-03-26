<?php namespace VictoryCms\Core\Contracts\Resources\Form\Behavior;

use VictoryCms\Core\Contracts\Resources\Element;

/**
 * Interface HasChildElements.
 */
interface HasChildElements
{
    /**
     * @param Element $element
     *
     * @return Element
     */
    public function add(Element $element);

    /**
     * @return array
     */
    public function getElements();
}
