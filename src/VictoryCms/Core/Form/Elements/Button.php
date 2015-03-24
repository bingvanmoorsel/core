<?php namespace VictoryCms\Core\Form\Elements;

/**
 * Class Button
 * @package VictoryCms\Core\Form\Elements
 */
class Button extends Input
{
    /**
     * @param string $name
     * @param null $value
     * @param array $attributes
     */
    public function __construct($name = 'button', $value = null, array $attributes = [])
    {
        // @todo Add translations
        $name = $name ?: 'Button';
        $value = $value ?: 'Button';

        parent::__construct('button', $name, $value, $attributes);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return (string) view('victory.resource.form.elements.button', [
            'attributes' => $this->buildAttributes()
        ]);
    }
}