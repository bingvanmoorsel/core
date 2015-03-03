<?php namespace VictoryCms\Core\Providers;

use Illuminate\Contracts\Console\Application;
use Illuminate\Support\ServiceProvider;

/**
 * Class ScopeServiceProvider
 * @package VictoryCms\Core\Providers
 */
class MigrationServiceProvider extends ServiceProvider
{
    /**
     * @param Application $artisan
     */
    public function boot(Application $artisan)
    {
        // Run the installer migrations
        $artisan->call('migrate', [
            '--path' => 'vendor/victory-cms/core/database/migrations'
        ]);
    }

    /**
     *
     */
    public function register()
    {
        //
    }
}