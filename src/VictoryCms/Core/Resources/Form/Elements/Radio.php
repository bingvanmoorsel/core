<?php namespace VictoryCms\Core\Resources\Form\Elements;

use VictoryCms\Core\Contracts\Resources\Form\Behavior\IsCheckable;
use VictoryCms\Core\Contracts\Resources\Element;

/**
 * Class Radio.
 */
class Radio extends Input implements IsCheckable
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
     * @param null   $value
     * @param bool   $checked
     * @param array  $attributes
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
     *
     * @return void
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
     * @return bool
     */
    protected function determineIsChecked($default = false)
    {
        if ($this->getOldValue() == $this->initialValue) {
            return true;
        }

        return (bool) value($default);
    }

    /**
     * @return bool
     */
    public function isChecked()
    {
        return $this->checked;
    }

    /**
     * @return string
     */
    public function render()
    {
        return (string) view('victory.core::resource.form.elements.radio', [
            'attributes' => $this->buildAttributes(),
        ]);
    }
}
