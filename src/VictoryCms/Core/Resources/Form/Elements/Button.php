<?php namespace VictoryCms\Core\Resources\Form\Elements;

/**
 * Class Button.
 */
class Button extends Input
{
    /**
     * @param string $name
     * @param null   $value
     * @param array  $attributes
     */
    public function __construct($name = 'button', $value = null, array $attributes = [])
    {
        // @todo Add translations
        $name = $name ?: 'Button';
        $value = $value ?: 'Button';

        parent::__construct('button', $name, $value, $attributes);
    }

    /**
     * @return string
     */
    public function render()
    {
        return (string) view('victory.core::resource.form.elements.button', [
            'attributes' => $this->buildAttributes(),
        ]);
    }
}
