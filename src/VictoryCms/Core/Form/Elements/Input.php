<?php namespace VictoryCms\Core\Form\Elements;

use VictoryCms\Core\Form\Contracts\Element as ElementContract;
use VictoryCms\Core\Form\Contracts\Input as InputContract;
use VictoryCms\Core\Form\Traits\ChildTrait;
use VictoryCms\Core\Form\Traits\PostingTrait;

/**
 * Class Input
 * @package VictoryCms\Core\Form\Elements
 */
class Input extends Element implements InputContract
{
    use ChildTrait;
    use PostingTrait;

    /**
     * @var array
     */
    protected $type;

    /**
     * @var null
     */
    protected $initialValue;

    /**
     * @param array $type
     * @param $name
     * @param null $value
     * @param array $attributes
     */
    public function __construct($type, $name, $value = null, array $attributes = [])
    {
        parent::__construct(array_merge($attributes, compact('type', 'name')));

        $this->type          = $type;
        $this->name          = $name;
        $this->initialValue  = $value;
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

        $this->setAttribute('value', $this->value);
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return (string) view('victory.core::resource.form.elements.partials.input', [
            'attributes' => $this->buildAttributes()
        ]);
    }
}