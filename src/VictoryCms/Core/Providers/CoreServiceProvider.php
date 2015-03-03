<?php namespace VictoryCms\Core\Providers;

use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use VictoryCms\Core\Models\Package;
use VictoryCms\Core\Victory;

/**
 * Class CoreServiceProvider
 * @package VictoryCms\Core
 */
class CoreServiceProvider extends ServiceProvider
{
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

    /**
     * @var array
     */
    protected $pipeTrough = [];

	/**	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        // Bind the main entry point of Victory CMS
        $this->app->singleton('victory', function(Application $app)
        {
            return new Victory($app);
        });
	}

    /**
     * @param Victory $victory
     * @param Dispatcher $dispatcher
     */
    public function boot(Victory $victory, Dispatcher $dispatcher)
    {
        if($this->app->runningInConsole() && $victory->isInstalled())
        {
            $victory->install();
        }

        // Bind some command handlers
        $dispatcher->pipeThrough($this->pipeTrough);

        $dispatcher->mapUsing(function($command)
        {
            return Dispatcher::simpleMapping(
                $command, 'VictoryCms\Core\Commands', 'VictoryCms\Core\Handlers\Commands'
            );
        });

        // Bind the CMS scopes
        $this->app->singleton(
            'VictoryCms\Core\Contracts\Scope\Backend',
            'VictoryCms\Core\Scopes\Backend'
        );

        $this->app->singleton(
            'VictoryCms\Core\Contracts\Scope\Frontend',
            'VictoryCms\Core\Scopes\Frontend'
        );

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
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return ['victory'];
	}
}