<?php namespace VictoryCms\Core\Form\Traits;

/**
 * Class AttributesTrait
 * @package VictoryCms\Core\Form\Traits
 */
trait AttributeTrait
{
    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed
     */
    public function getAttribute($key, $default = null)
    {
        if($this->hasGetMutator($key)) {
            return $this->{'get'.studly_case($key).'Attribute'}($key);
        }

        return isset($this->attributes[$key]) ? $this->attributes[$key] : value($default);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasGetMutator($key)
    {
        return method_exists($this, 'get'.studly_case($key).'Attribute');
    }

    /**
     * @param string $key
     * @param $value
     */
    public function setAttribute($key, $value)
    {
        if($this->hasSetMutator($key)) {
            return $this->{'set'.studly_case($key).'Attribute'}($value);
        }

        $this->attributes[$key] = $value;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasSetMutator($key)
    {
        return method_exists($this, 'set'.studly_case($key).'Attribute');
    }

    /**
     * @param array $attributes
     */
    public function setAttributes(array $attributes)
    {
        foreach($attributes as $key => $value) {
            $this->setAttribute($key, $value);
        }
    }

    /**
     * @return string
     */
    protected function buildAttributes()
    {
        return \Html::attributes($this->attributes);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }
}