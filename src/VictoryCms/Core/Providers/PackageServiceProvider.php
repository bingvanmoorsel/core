<?php namespace VictoryCms\Core\Providers;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Migrations\Migrator;
use Illuminate\Database\Seeder;
use Illuminate\Support\ServiceProvider;
use VictoryCms\Core\Models\Package;
use VictoryCms\Core\Seeds\VictoryDatabaseSeeder;

/**
 * Class PackageServiceProvider.
 */
abstract class PackageServiceProvider extends ServiceProvider
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
    public function migrate($pretend = false)
    {
        /** @var Migrator $migrator */
        $migrator = $this->app->make('Illuminate\Database\Migrations\Migrator');
        $migrator->run($this->databasePath().DIRECTORY_SEPARATOR.'migrations', $pretend);
    }

    /**
     *
     */
    public function publish($force = false)
    {
        $provider = get_called_class();

        /** @var \Illuminate\Contracts\Console\Application $artisan */
        $artisan = $this->app->make('artisan');

        $artisan->call('vendor:publish', [
            '--provider' => $provider,
            '--force' => $force
        ]);
    }

    /**
     * @param string|array $seeder
     */
    public function seed($seeder)
    {
        $seeders = (array)$seeder;

        /** @var Seeder $seeder */
        foreach($seeders as $seeder) {
            $seeder->run();
        }
    }

    /**
     * @param Package $model
     */
    public function setModel(Package $model)
    {
        $this->model = $model;
    }

    /**
     * @return Package
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return string
     */
    public function databasePath()
    {
        return $this->basePath().DIRECTORY_SEPARATOR.'database';
    }

    /**
     * @return string
     */
    public function resourcePath()
    {
        return $this->basePath().DIRECTORY_SEPARATOR.'resources';
    }

    /**
     * @return string
     */
    public function configPath()
    {
        return $this->basePath().DIRECTORY_SEPARATOR.'config';
    }

    /**
     * @return string
     */
    public function basePath()
    {
        return base_path('vendor/'.$this->model->name);
    }
}
