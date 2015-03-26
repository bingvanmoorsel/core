<?php namespace VictoryCms\Core\Resources;

use VictoryCms\Core\Contracts\Resources\Element as Contract;
use VictoryCms\Core\Resources\Traits\HasAttributesTrait;

/**
 * Class Element.
 */
abstract class Element implements Contract
{
    /**
     * @var mixed
     */
    protected $app;

    use HasAttributesTrait;

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
     * @return void
     */
    public function register(Contract $parent)
    {
        $method = 'setParent';

        if (method_exists($this, $method)) {
            $this->{$method}($parent);
        }
    }

    /**
     * @return string
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
