<?php namespace VictoryCms\Core\Resources\Form\Elements;

use VictoryCms\Core\Resources\Element;
use VictoryCms\Core\Contracts\Resources\Element as ElementContract;
use VictoryCms\Core\Contracts\Resources\Form\Input as InputContract;
use VictoryCms\Core\Resources\Form\Traits\CanPostTrait;
use VictoryCms\Core\Resources\Traits\HasParentElementTrait;

/**
 * Class Input.
 */
class Input extends Element implements InputContract
{
    use HasParentElementTrait;
    use CanPostTrait;

    /**
     * @var array
     */
    protected $type;

    /**
     * @var null
     */
    protected $initialValue;

    /**
     * @param string $type
     * @param string $name
     * @param null   $value
     * @param array  $attributes
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
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function render()
    {
        return (string) view('victory.core::resource.form.elements.partials.input', [
            'attributes' => $this->buildAttributes(),
        ]);
    }
}
