<?php namespace VictoryCms\Core\Providers;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use VictoryCms\Core\Models\Package;
use VictoryCms\Core\Traits\PackageTrait;

/**
 * Class PackageServiceProvider.
 */
abstract class PackageServiceProvider extends ServiceProvider
{
    use PackageTrait;

    /**
     * @var Package
     */
    protected $model;

    /**
     * @var string
     */
    protected $basePath;

    /**
     * @param Application $app
     * @param Package     $model
     */
    public function __construct(Application $app, Package $model)
    {
        parent::__construct($app);

        $this->model    = $model;
        $this->basePath = base_path('vendor/'.$this->model->name);
    }

    /**
     * @param Closure $callback
     */
    public function routes(Closure $callback)
    {
        return $this->app['router']->group([
            'prefix' => 'victory/'.$this->model->name,
        ], $callback);
    }

    /**
     */
    public function install()
    {
        $this->update();
    }

    /**
     */
    public function update()
    {
        $this->publish(null, true);
        $this->migrate($this->getDatabasePath('migrations'));
    }

    /**
     */
    public function destroy()
    {
        return;
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public function getBasePath($path = '')
    {
        return base_path('vendor/'.$this->model->name.($path ? '/'.$path : $path));
    }
}
