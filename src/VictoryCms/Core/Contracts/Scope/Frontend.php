<?php namespace VictoryCms\Core\Contracts\Scope;

use Closure;

/**
 * Interface Backend
 * @package VictoryCms\Core\Contracts\Scope
 */
interface Frontend
{
    /**
     * @param callable $closure
     * @return mixed
     */
    public function map(Closure $closure);
}