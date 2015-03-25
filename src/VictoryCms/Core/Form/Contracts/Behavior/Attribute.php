<?php namespace VictoryCms\Core\Form\Contracts\Behavior;

/**
 * Interface Attribute.
 */
interface Attribute
{
    /**
     * @param $key
     * @param $value
     */
    public function setAttribute($key, $value);

    /**
     * @param array $attributes
     */
    public function setAttributes(array $attributes);

    /**
     * @param $key
     * @param null $default
     *
     * @return mixed
     */
    public function getAttribute($key, $default = null);

    /**
     * @return array
     */
    public function getAttributes();
}
