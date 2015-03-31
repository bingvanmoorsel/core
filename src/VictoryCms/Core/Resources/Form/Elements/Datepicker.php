<?php
/**
 * Created by PhpStorm.
 * User: bvanmoorsel
 * Date: 31-3-2015
 * Time: 10:49
 */

namespace VictoryCms\Core\Resources\Form\Elements;


class Datepicker extends Input {

    /**
     * @param string $name
     * @param null   $value
     * @param array  $attributes
     */
    public function __construct($name, $value = null, array $attributes = [])
    {
        if(!isset($attributes['class']))
        {
            $attributes['class'] = '';
        }

        $attributes['class'] = $attributes['class']." victory-form__datepicker";

        parent::__construct('text', $name, $value, $attributes);
    }

    /**
     * @return string
     */
    public function render()
    {
        return (string) view('victory.core::resource.form.elements.datepicker', [
            'attributes' => $this->buildAttributes(),
        ]);
    }
}