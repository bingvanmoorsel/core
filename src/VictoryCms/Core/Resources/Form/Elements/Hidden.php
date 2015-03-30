<?php namespace VictoryCms\Core\Resources\Form\Elements;

/**
 * Class Hidden.
 */
class Hidden extends Input
{
    /**
     * @param string $name
     * @param int    $value
     * @param array  $attributes
     */
    public function __construct($name, $value = 1, array $attributes = [])
    {
        parent::__construct('hidden', $name, $value, $attributes);
    }

    /**
     * @return string
     */
    public function render()
    {
        return (string) view('victory.core::resource.form.elements.hidden', [
            'attributes' => $this->buildAttributes(),
        ]);
    }
}
