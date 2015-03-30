<?php namespace VictoryCms\Core\Contracts\Resources\Grid;

use Illuminate\Http\Request;
use VictoryCms\Core\Contracts\Resources\Behavior\CanRender;

/**
 * Interface Filter.
 */
interface Filter extends CanRender
{
    /**
     * @param Request  $request
     * @param callable $next
     *
     * @return mixed
     */
    public function apply(Request $request, \Closure $next);
}
