<?php namespace VictoryCms\Core\Form\Elements;

use VictoryCms\Core\Form\Traits\ChildTrait;
use VictoryCms\Core\Form\Contracts\Element as Contract;

/**
 * Class Label.
 */
class Label extends Element
{
    use ChildTrait;

    /**
     * @var
     */
    protected $label;

    /**
     * @param string $for
     * @param string $label
     * @param array  $attributes
     */
    public function __construct($for, $label, array $attributes = [])
    {
        parent::__construct(array_merge($attributes, compact('for')));

        $this->label = $label;
    }

    /**
     * @param Contract $parent
     */
    public function register(Contract $parent)
    {
        $this->setParent($parent);
    }

    /**
     * @return string
     */
    public function render()
    {
        return (string) view('resource.form.elements.label', [
            'attributes' => $this->buildAttributes(),
            'label'      => $this->label,
        ]);
    }
}
