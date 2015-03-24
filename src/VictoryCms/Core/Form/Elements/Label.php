<?php namespace VictoryCms\Core\Form\Elements;
use VictoryCms\Core\Form\Traits\ChildTrait;
use VictoryCms\Core\Form\Contracts\Element as Contract;

/**
 * Class Label
 * @package VictoryCms\Core\Form\Elements
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
     * @param array $attributes
     */
    public function __construct($for, $label, array $attributes = [])
    {
        parent::__construct(array_merge($attributes, compact('for')));

        $this->label = $label;
    }

    /**
     * @param Contract $parent
     */
    function register(Contract $parent)
    {
        $this->setParent($parent);
    }

    /**
     * @return string
     */
    public function render()
    {
        return (string) view('victory.resource.form.elements.label', [
            'attributes' => \Html::attributes($this->getAttributes()),
            'label' => $this->label
        ]);
    }
}