<?php namespace VictoryCms\Core\Resources\Form\Elements;

use VictoryCms\Core\Resources\Element;
use VictoryCms\Core\Resources\Traits\HasParentElementTrait;
use VictoryCms\Core\Contracts\Resources\Element as Contract;

/**
 * Class Label.
 */
class Label extends Element
{
    use HasParentElementTrait;

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
        return (string) view('victory.core::resource.form.elements.label', [
            'attributes' => $this->buildAttributes(),
            'label'      => $this->label,
        ]);
    }
}
