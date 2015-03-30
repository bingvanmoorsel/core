<?php namespace VictoryCms\Core\Resources\Traits;

use VictoryCms\Core\Contracts\Resources\Element;

/**
 * Class GroupTrait.
 */
trait HasChildElementsTrait
{
    /**
     * @var array
     */
    protected $elements = [];

    /**
     * @param Element $element
     *
     * @return Element
     */
    public function add(Element $element)
    {
        $element->register($this);

        return $this->elements[] = $element;
    }

    /**
     * @return array
     */
    public function getElements()
    {
        return $this->elements;
    }
}
