<?php namespace VictoryCms\Core\Providers;

use Illuminate\Support\ServiceProvider;
use VictoryCms\Core\Models\Package;

/**
 * Class PackageServiceProvider
 * @package VictoryCms\Installer
 */
class PackageServiceProvider extends ServiceProvider
{
    /**
     *
     */
    public function boot()
    {
        // Register and boot all the Victory packages
        foreach(Package::all() as $package)
        {
            $namespace = studly_case($package->vendor) . '\\' . studly_case($package->name);
            $provider = $namespace . '\\PackageServiceProvider';

            if(class_exists($provider))
            {
                $this->app->register($provider);
            }
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(){}
}
