<?php namespace VictoryCms\Core\Traits;

use Illuminate\Database\Migrations\Migrator;
use Illuminate\Database\Seeder;

/**
 * Class PackageTrait.
 */
trait PackageTrait
{
    /**
     * @param bool $pretend
     */
    public function migrate($paths, $pretend = false)
    {
        /** @var Migrator $migrator */
        $migrator = \App::make('Illuminate\Database\Migrations\Migrator');

        foreach ((array) $paths as $path) {
            $migrator->run($path, $pretend);
        }
    }

    /**
     *
     */
    public function publish($tag = null, $force = false)
    {
        $provider = get_called_class();

        /** @var \Illuminate\Contracts\Console\Application $artisan */
        $artisan = \App::make('artisan');

        $artisan->call('vendor:publish', [
            '--provider' => $provider,
            '--force' => $force,
            '--tag' => $tag,
        ]);
    }

    /**
     * @param string|array $seeders
     */
    public function seed($seeders)
    {
        /** @var Seeder $seeder */
        foreach ((array) $seeders as $seeder) {
            $seeder->run();
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
     * @return string
     */
    abstract public function getBasePath($path = '');
}
