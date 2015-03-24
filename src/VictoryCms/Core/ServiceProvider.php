<?php
/**
 * Created by PhpStorm.
 * User: jrantwijk
 * Date: 10-3-2015
 * Time: 9:35
 */

namespace VictoryCms\Core;

use Illuminate\Database\Migrations\Migrator;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Class ServiceProvider
 * @package VictoryCms\Core
 */
abstract class ServiceProvider extends BaseServiceProvider
{
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
     * @param bool $pretend
     */
    protected function migrate($pretend = false)
    {
        /** @var Migrator $migrator */
        $migrator = $this->app->make('Illuminate\Database\Migrations\Migrator');

        $migrator->run($this->databasePath() . DIRECTORY_SEPARATOR . 'migrations', $pretend);
    }

    /**
     * @return string
     */
    protected function databasePath()
    {
        return $this->basePath() . DIRECTORY_SEPARATOR . 'database';
    }

    /**
     * @return string
     */
    protected function resourcePath()
    {
        return $this->basePath() . DIRECTORY_SEPARATOR . 'resources';
    }

    /**
     * @return string
     */
    protected function configPath()
    {
        return $this->basePath() . DIRECTORY_SEPARATOR . 'config';
    }

    /**
     * @return string
     */
    protected function basePath()
    {
        return realpath(__DIR__ . '/' . str_repeat('../', 3));
    }
}