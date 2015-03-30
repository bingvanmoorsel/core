<?php namespace VictoryCms\Core\Resources\Form\Elements;

/**
 * Class Password.
 */
class Password extends Input
{
    /**
     * @param string $name
     * @param array  $attributes
     */
    public function __construct($name, array $attributes = [])
    {
        parent::__construct('password', $name, null, $attributes);
    }

    /**
     * @return string
     */
    public function render()
    {
        return (string) view('victory.core::resource.form.elements.password', [
            'attributes' => $this->buildAttributes(),
        ]);
    }
}
