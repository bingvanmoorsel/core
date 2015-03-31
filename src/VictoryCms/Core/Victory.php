<?php namespace VictoryCms\Core;

use Closure;
use Illuminate\Contracts\Foundation\Application;

/**
 * Class Victory.
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
     * @var
     */
    protected $installed;

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
        $this->storagePath = storage_path('victory');
    }

    /**
     * @return mixed
     */
    public function getPackages()
    {
        return $this->app['victory.packages'];
    }

    /**
     * @return bool
     */
    public function isInstalled()
    {
        if ($this->installed) {
            return $this->installed;
        }

        return $this->installed = file_exists($this->storagePath.DIRECTORY_SEPARATOR.'installed');
    }

    /**
     * @param $name
     * @param callable $closure
     */
    public function routes($name, Closure $closure)
    {
        return $this->app['router']->group([
            'prefix' => 'victory/'.$name,
        ], $closure);
    }

    /**
     * @param string $path
     * @return string
     */
    public function getStoragePath($path = '')
    {
        return $this->storagePath.($path ? '/'.$path : $path);
    }
}
