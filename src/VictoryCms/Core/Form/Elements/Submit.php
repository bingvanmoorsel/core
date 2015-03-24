<?php namespace VictoryCms\Core\Form\Elements;

/**
 * Class Submit
 * @package VictoryCms\Core\Form\Elements
 */
class Submit extends Input
{
    /**
     * @param null $value
     * @param array $attributes
     */
    public function __construct($name = null, $value = null, array $attributes = [])
    {
        // @todo Add translations
        $name = $name ?: 'Submit';
        $value = $value ?: 'Submit';

        parent::__construct('submit', $name, $value, $attributes);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return (string) view('victory.resource.form.elements.submit', [
            'attributes' => $this->buildAttributes()
        ]);
    }
}