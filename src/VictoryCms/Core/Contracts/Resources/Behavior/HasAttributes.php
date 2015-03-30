<?php namespace VictoryCms\Core\Contracts\Resources\Behavior;

/**
 * Interface Attribute.
 */
interface HasAttributes
{
    /**
     * @param string $key
     * @param mixed  $value
     */
    public function setAttribute($key, $value);

    /**
     * @param array $attributes
     */
    public function setAttributes(array $attributes);

    /**
     * @param string $key
     * @param null   $default
     *
     * @return mixed
     */
    public function getAttribute($key, $default = null);

    /**
     * @return array
     */
    public function getAttributes();
}
