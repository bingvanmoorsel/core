<?php namespace VictoryCms\Core\Form\Elements;

/**
 * Class Hidden
 * @package VictoryCms\Core\Form\Elements
 */
class Hidden extends Input
{
    /**
     * @param array $name
     * @param int $value
     * @param array $attributes
     */
    public function __construct($name, $value = 1, array $attributes = [])
    {
        parent::__construct('hidden', $name, $value, $attributes);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return (string) view('victory.core::resource.form.elements.hidden', [
            'attributes' => $this->buildAttributes(),
        ]);
    }
}