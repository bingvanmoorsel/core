<?php
/**
 * Created by PhpStorm.
 * User: bvanmoorsel
 * Date: 17-3-2015
 * Time: 15:29
 */

namespace VictoryCms\Core\Providers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use VictoryCms\Core\Models\Package;

abstract class PackageServiceProvider extends ServiceProvider {

    protected $model;

    public function __construct(Application $app, Package $model)
    {
        parent::__construct($app);
        $this->model = $model;
    }

    public function routes(\Closure $callback)
    {
        return \Route::group(['prefix' => 'victory/'.$this->model->name], $callback);
    }
}