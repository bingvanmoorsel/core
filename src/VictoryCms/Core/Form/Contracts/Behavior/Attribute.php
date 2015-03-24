<?php namespace VictoryCms\Core\Form\Contracts\Behavior;

/**
 * Interface Attribute
 * @package VictoryCms\Core\Form\Contracts\Behavior
 */
interface Attribute
{
    /**
     * @param $key
     * @param $value
     * @return void
     */
    public function setAttribute($key, $value);

    /**
     * @param array $attributes
     * @return void
     */
    public function setAttributes(array $attributes);

    /**
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function getAttribute($key, $default = null);

    /**
     * @return array
     */
    public function getAttributes();
}