<?php namespace VictoryCms\Core;

use Closure;

/**
 * Class Backend
 * @package VictoryCms\Core
 */
class Backend extends Scope implements \VictoryCms\Core\Contracts\Scope\Backend
{
    /**
     *
     */
    function __construct()
    {
        $this->setPrefix('admin');
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