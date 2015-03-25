<?php namespace VictoryCms\Core\Form\Elements;

use VictoryCms\Core\Form\Contracts\Behavior\Checkable;
use VictoryCms\Core\Form\Contracts\Element;

/**
 * Class Checkbox.
 */
class Checkbox extends Input implements Checkable
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
     * @param string  $name
     * @param mixed   $value
     * @param boolean $checked
     * @param array   $attributes
     */
    public function __construct($name, $value = 1, $checked = false, array $attributes = [])
    {
        $value = $value ?: $name;

        parent::__construct('checkbox', $name, $value, $attributes);

        // Set the initial checkbox state
        $this->initialState = $checked;
    }

    /**
     * @param Element $parent
     */
    public function register(Element $parent)
    {
        parent::register($parent);

        // Determine the checkbox state. If the model attribute and old
        // input are missing, use the initial state of the element
        $this->checked = $this->determineIsChecked($this->initialState);

        if ($this->checked) {
            $this->setAttribute('checked', 'checked');
        }
    }

    /**
     * @param bool $default
     *
     * @return bool|mixed
     */
    protected function determineIsChecked($default = false)
    {
        if ($this->getOldValue() == $this->initialValue) {
            return true;
        }

        return value($default);
    }

    /**
     * @return bool
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
        return (string) view('victory.core::resource.form.elements.checkbox', [
            'attributes' => $this->buildAttributes(),
        ]);
    }
}