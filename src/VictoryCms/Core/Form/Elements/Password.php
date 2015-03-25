<?php namespace VictoryCms\Core\Form\Elements;

/**
 * Class Password.
 */
class Password extends Input
{
    /**
     * @param array $name
     * @param array $attributes
     */
    public function __construct($name, array $attributes = [])
    {
        parent::__construct('password', $name, null, $attributes);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return (string) view('resource.form.elements.password', [
            'attributes' => $this->buildAttributes(),
        ]);
    }
}
