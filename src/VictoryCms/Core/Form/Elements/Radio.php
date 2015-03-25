<?php namespace VictoryCms\Core\Form\Elements;

use VictoryCms\Core\Form\Contracts\Behavior\Checkable;
use VictoryCms\Core\Form\Contracts\Element;

/**
 * Class Radio
 * @package VictoryCms\Core\Form\Elements
 */
class Radio extends Input implements Checkable
{
    /**
     * @var
     */
    protected $checked;

    /**
     * @var
     */
    protected $initialState;

    /**
     * @param string $name
     * @param null $value
     * @param bool $checked
     * @param array $attributes
     */
    public function __construct($name, $value = null, $checked = false, array $attributes = [])
    {
        $value = $value ?: $name;

        parent::__construct('radio', $name, $value, $attributes);

        // Set the initial checkbox state
        $this->initialState = $checked;
    }

    /**
     * @param Element $parent
     * @return void
     */
    public function register(Element $parent)
    {
        parent::register($parent);

        // Determine the checkbox state. If the model attribute and old
        // input are missing, use the initial state of the element
        $this->checked = $this->determineIsChecked($this->initialState);

        if($this->checked) {
            $this->setAttribute('checked', 'checked');
        }
    }

    /**
     * @param bool $default
     * @return bool|mixed
     */
    protected function determineIsChecked($default = false)
    {
        if($this->getOldValue() == $this->initialValue) {
            return true;
        }

        return value($default);
    }

    /**
     *
     */
    public function isChecked()
    {
        return $this->checked;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return (string) view('resource.form.elements.radio', [
            'attributes' => $this->buildAttributes(),
        ]);
    }
}