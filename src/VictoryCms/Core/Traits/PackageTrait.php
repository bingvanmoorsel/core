<?php namespace VictoryCms\Core\Traits;

use Illuminate\Console\Application;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Database\Migrations\MigrationRepositoryInterface;
use Illuminate\Database\Migrations\Migrator;
use Illuminate\Database\Seeder;

/**
 * Class PackageTrait.
 */
trait PackageTrait
{
    /**
     * @param bool $pretend
     *
     * @return void
     */
    public function migrate($paths, $pretend = false)
    {
        /** @var Migrator $migrator */
        $migrator = \App::make('migrator');

        /** @var MigrationRepositoryInterface $repository */
        $repository = \App::make('migration.repository');

        if (!$repository->repositoryExists()) {
            $repository->createRepository();
        }

        foreach((array) $paths as $path) {
            $migrator->run($path, $pretend);
        }
    }

    /**
     * @param null|string $tag
     * @param bool        $force
     *
     * @return void
     */
    public function publish($tag = null, $force = false)
    {
        $provider = get_called_class();

        var_dump($provider);

        /** @var Kernel $artisan */
        $artisan = \App::make('Illuminate\Contracts\Console\Kernel');

        $artisan->call('vendor:publish', [
            '--provider' => $provider,
        ]);
    }

    /**
     * @param string|array $seeders
     *
     * @return void
     */
    public function seed($seeders)
    {
        /** @var Seeder $seeder */
        foreach ((array) $seeders as $seeder) {
            with(new $seeder)->run();
        }
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public function getDatabasePath($path = '')
    {
        return $this->getBasePath('database'.($path ? '/'.$path : $path));
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public function getResourcePath($path = '')
    {
        return $this->getBasePath('resources'.($path ? '/'.$path : $path));
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public function getConfigPath($path = '')
    {
        return $this->getBasePath('config'.($path ? '/'.$path : $path));
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public function getSourcePath($path = '')
    {
        return $this->getBasePath('src'.($path ? '/'.$path : $path));
    }

    /**
     * @param string $path
     *
     * @return string
     */
    abstract public function getBasePath($path = '');
}
