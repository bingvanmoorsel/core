<?php
/**
 * Created by PhpStorm.
 * User: jrantwijk
 * Date: 26-3-2015
 * Time: 11:00
 */

namespace VictoryCms\Core\Contracts\Resources\Grid;

use Illuminate\Http\Request;
use VictoryCms\Core\Contracts\Resources\Behavior\CanRender;

interface Filter extends CanRender
{
    public function apply(Request $request, \Closure $next);
}