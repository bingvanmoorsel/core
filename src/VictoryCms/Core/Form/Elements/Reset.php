<?php namespace VictoryCms\Core\Form\Elements;

/**
 * Class Reset
 * @package VictoryCms\Core\Form\Elements
 */
class Reset extends Input
{
    /**
     * @param string $name
     * @param null $value
     * @param array $attributes
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
        return (string) view('victory.resource.form.elements.reset', [
            'attributes' => \Html::attributes($this->getAttributes())
        ]);
    }
}