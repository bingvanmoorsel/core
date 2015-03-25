<?php namespace VictoryCms\Core\Form\Elements;

/**
 * Class Text
 * @package VictoryCms\Core\Form\Elements
 */
class Text extends Input
{
    /**
     * @param array $name
     * @param null $value
     * @param array $attributes
     */
    public function __construct($name, $value = null, array $attributes = [])
    {
        parent::__construct('text', $name, $value, $attributes);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return (string) view('resource.form.elements.text', [
            'attributes' => $this->buildAttributes()
        ]);
    }
}