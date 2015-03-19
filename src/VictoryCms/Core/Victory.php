<?php namespace VictoryCms\Core;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Collection;
use VictoryCms\Core\Scopes\Scope;

/**
 * Class Victory
 * @package VictoryCms\Core
 */
class Victory
{
    /**
     * @var string
     */
    const VERSION = '0.1.0';

    /**
     *
     */
    const PACKAGE = 'victory-cms/core';

    /**
     * @var Application
     */
    protected $app;

    /**
     * @var string
     */
    protected $storagePath;

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;

        $this->storagePath = $this->app->storagePath().'/victory';
        $this->corePath = $this->app->basePath().'/vendor/'.self::PACKAGE;
    }

    /**
     * @return string
     */
    public function version()
    {
        return self::VERSION;
    }

    /**
     * @return bool
     */
    public function isInstalled()
    {
        return file_exists($this->storagePath.'/installed');
    }

    /**
     * @return string
     */
    public function storagePath()
    {
        return $this->storagePath;
    }

    /**
     * @return string
     */
    public function corePath()
    {
        return $this->corePath;
    }

    /**
     * @return string
     */
    public function getPackageName()
    {
        return self::PACKAGE;
    }

    /**
     * @param $name
     * @return Scope
     */
    public function scope($name)
    {
        return $this->app->make('VictoryCms\Core\Scopes\\'.studly_case($name));
    }

    public function routes($name, Closure $closure)
    {
        return \Route::group(['prefix' => 'victory/'.$name], $closure);
    }
}