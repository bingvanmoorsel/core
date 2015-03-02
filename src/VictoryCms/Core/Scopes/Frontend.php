<?php namespace VictoryCms\Core;

use Closure;

/**
 * Class Frontend
 * @package VictoryCms\Core
 */
class Frontend extends Scope implements \VictoryCms\Core\Contracts\Scope\Frontend
{
    /**
     *
     */
    function __construct()
    {
        $this->setPrefix('/');
    }

    /**
     * @param callable $closure
     * @return mixed
     */
    public function map(Closure $closure)
    {
        // TODO: Implement map() method.
    }
}