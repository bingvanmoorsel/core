<?php namespace VictoryCms\Core\Form\Elements;

/**
 * Class Reset.
 */
class Reset extends Input
{
    /**
     * @param string $name
     * @param null   $value
     * @param array  $attributes
     */
    public function __construct($name = null, $value = null, array $attributes = [])
    {
        // @todo Add translations
        $name = $name ?: 'Reset';
        $value = $value ?: 'Reset';

        parent::__construct('reset', $name, $value, $attributes);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return (string) view('victory.core::resource.form.elements.reset', [
            'attributes' => $this->buildAttributes(),
        ]);
    }
}
