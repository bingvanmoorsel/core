<?php namespace VictoryCms\Core\Resources\Form\Elements;

/**
 * Class Text.
 */
class Text extends Input
{
    /**
     * @param array $name
     * @param null  $value
     * @param array $attributes
     */
    public function __construct($name, $value = null, array $attributes = [])
    {
        parent::__construct('text', $name, $value, $attributes);
    }

    /**
     * @return string
     */
    public function render()
    {
        return (string) view('victory.core::resource.form.elements.text', [
            'attributes' => $this->buildAttributes(),
        ]);
    }
}
