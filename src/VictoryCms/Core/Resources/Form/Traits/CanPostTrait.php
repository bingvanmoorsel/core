<?php namespace VictoryCms\Core\Resources\Form\Traits;

/*
 * Class PostingTrait
 * @package VictoryCms\Core\Resources\Form\Traits
 */
use Illuminate\Session\SessionManager;

/**
 * Class PostingTrait.
 */
trait CanPostTrait
{
    /**
     * @var
     */
    protected $name;

    /**
     * @var
     */
    protected $value;

    /**
     * @var
     */
    protected $model;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param null $default
     *
     * @return mixed
     */
    protected function determineValue($default = null)
    {
        if (($old = $this->getOldValue()) !== null) {
            return $old;
        }

        if (($value = $this->getModelAttribute()) !== null) {
            return $value;
        }

        return value($default);
    }

    /**
     * @param null $default
     *
     * @return mixed|null
     */
    protected function getModelAttribute($default = null)
    {
        if (is_object($this->model)) {
            return object_get($this->model, $this->transformKey($this->name));
        }

        if (is_array($this->model)) {
            return array_get($this->model, $this->transformKey($this->name));
        }

        return $default;
    }

    protected function transformKey($key)
    {
        return str_replace(array('.', '[]', '[', ']'), array('_', '', '.', ''), $key);
    }

    /**
     *
     */
    public function hasModelAttribute()
    {
        return $this->getModelAttribute() !== null;
    }

    /**
     * @return mixed
     */
    protected function getOldValue()
    {
        /** @var SessionManager $session */
        $session = \App::make('session');

        return $session->getOldInput($this->transformKey($this->name));
    }

    /**
     * @return bool
     */
    public function hasOldValue()
    {
        return $this->getOldValue() !== null;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
