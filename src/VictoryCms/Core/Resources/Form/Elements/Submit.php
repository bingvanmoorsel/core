<?php namespace VictoryCms\Core\Resources\Form\Elements;

/**
 * Class Submit.
 */
class Submit extends Input
{
    /**
     * @param null|string $name
     * @param null        $value
     * @param array       $attributes
     */
    public function __construct($name = null, $value = null, array $attributes = [])
    {
        // @todo Add translations
        $name = $name ?: 'Submit';
        $value = $value ?: 'Submit';

        parent::__construct('submit', $name, $value, $attributes);
    }

    /**
     * @return string
     */
    public function render()
    {
        return (string) view('victory.core::resource.form.elements.submit', [
            'attributes' => $this->buildAttributes(),
        ]);
    }
}
