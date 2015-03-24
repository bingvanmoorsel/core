<?php namespace VictoryCms\Core\Form\Traits;

use VictoryCms\Core\Form\Contracts\Element;
use VictoryCms\Core\Form\Contracts\Behavior\Posting;

/**
 * Class GroupTrait
 * @package VictoryCms\Core\Form\Traits
 */
trait GroupTrait
{
    /**
     * @var array
     */
    protected $elements = [];

    /**
     * @param Element $element
     * @return Posting|Element
     */
    public function add(Element $element)
    {
        $element->register($this);

        if($element instanceof Posting) {
            return $this->elements[$element->getName()] = $element;
        }

        return $this->elements[] = $element;
    }

    /**
     * @param $name
     * @param null $default
     * @return mixed
     */
    public function find($name, $default = null)
    {
        return isset($this->elements[$name]) ? $this->elements[$name] : value($default);
    }

    /**
     * @return array
     */
    public function getElements()
    {
        return $this->elements;
    }
}