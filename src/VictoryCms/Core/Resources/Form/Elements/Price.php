<?php namespace VictoryCms\Core\Resources\Form\Elements;

/**
 * Class Text.
 */
class Price extends Input
{

    /**
     * @var string
     */
    protected $currency = '&euro;';

    /**
     * @param string $name
     * @param null   $value
     * @param array  $attributes
     */
    public function __construct($name, $value = "000", $currency = '&euro;', array $attributes = [])
    {
        if(!isset($attributes['class']))
        {
            $attributes['class'] = '';
        }

        $attributes['class'] = $attributes['class']." victory-form__priceformat";

        parent::__construct('text', $name, $value, $attributes);

    }

    /**
     * @return string
     */
    public function render()
    {
        return (string) view('victory.core::resource.form.elements.price', [
            'attributes' => $this->buildAttributes(),
            'currency' => $this->currency
        ]);
    }
}
