<?php namespace VictoryCms\Core\Form\Elements;

use VictoryCms\Core\Form\Contracts\Element as Contract;
use VictoryCms\Core\Form\Traits\AttributeTrait;

/**
 * Class Element.
 */
abstract class Element implements Contract
{
    /**
     * @var mixed
     */
    protected $app;

    use AttributeTrait;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->app = \App::make('app');
        $this->setAttributes($attributes);
    }

    /**
     * @param Contract $parent
     */
    public function register(Contract $parent)
    {
        $method = 'setParent';

        if (method_exists($this, $method)) {
            $this->{$method}($parent);
        }
    }

    /**
     * @return mixed
     */
    abstract public function render();

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->render();
    }
}
