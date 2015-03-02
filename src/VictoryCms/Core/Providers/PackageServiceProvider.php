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
    public function register()
    {
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
}
