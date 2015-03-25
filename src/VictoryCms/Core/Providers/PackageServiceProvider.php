<?php namespace VictoryCms\Core\Providers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use VictoryCms\Core\Contracts\Installer;
use VictoryCms\Core\Models\Package;

/**
 * Class PackageServiceProvider.
 */
abstract class PackageServiceProvider extends ServiceProvider implements Installer
{
    /**
     * @var Package
     */
    protected $model;

    /**
     * @param Application $app
     * @param Package     $model
     */
    public function __construct(Application $app, Package $model)
    {
        parent::__construct($app);

        $this->model = $model;
    }

    /**
     * @param callable $callback
     */
    public function routes(\Closure $callback)
    {
        return $this->app['router']->group([
            'prefix' => 'victory/'.$this->model->name,
        ], $callback);
    }

    /**
     *
     */
    public function install()
    {
        $this->migrate();
    }

    /**
     *
     */
    public function update()
    {
        $this->migrate();
    }

    /**
     *
     */
    public function destroy()
    {
        return;
    }

    /**
     * @param bool $pretend
     */
    protected function migrate($pretend = false)
    {
        /** @var Migrator $migrator */
        $migrator = $this->app->make('Illuminate\Database\Migrations\Migrator');

        $migrator->run($this->databasePath().DIRECTORY_SEPARATOR.'migrations', $pretend);
    }

    /**
     * @return string
     */
    protected function databasePath()
    {
        return $this->basePath().DIRECTORY_SEPARATOR.'database';
    }

    /**
     * @return string
     */
    protected function resourcePath()
    {
        return $this->basePath().DIRECTORY_SEPARATOR.'resources';
    }

    /**
     * @return string
     */
    protected function configPath()
    {
        return $this->basePath().DIRECTORY_SEPARATOR.'config';
    }

    /**
     * @return string
     */
    protected function basePath()
    {
        return base_path('vendor/'.$this->model->name);
    }
}
