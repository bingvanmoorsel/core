<?php namespace VictoryCms\Core\Form\Elements;

use VictoryCms\Core\Form\Contracts\Element as ElementContract;
use VictoryCms\Core\Form\Traits\PostingTrait;
use VictoryCms\Core\Form\Traits\ChildTrait;

/**
 * Class Textarea
 * @package VictoryCms\Core\Form\Elements
 */
class Textarea extends Element
{
    use ChildTrait;
    use PostingTrait;

    protected $initialValue;

    /**
     * @param string $name
     * @param null $value
     * @param array $attributes
     */
    public function __construct($name, $value = null, array $attributes = [])
    {
        parent::__construct(array_merge($attributes, compact('name')));

        $this->name = $name;
        $this->initialValue = $value;
    }

    /**
     * @param ElementContract $parent
     */
    public function register(ElementContract $parent)
    {
        parent::register($parent);

        // Get the form model for the posting trait
        $this->model = $this->getForm()
            ->getModel();

        // Determine the input value. If the model value and old input
        // are not set, use the initial (default) value
        $this->value = $this->determineValue($this->initialValue);
    }

    /**
     * @return string
     */
    public function render()
    {
        return (string) view('victory.core::resource.form.elements.textarea', [
            'attributes' => $this->buildAttributes(),
            'value'      => $this->getValue()
        ]);
    }
}