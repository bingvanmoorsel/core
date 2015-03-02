<?php namespace VictoryCms\Core\Providers;

use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
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
	 * Register the service provider.
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

        $this->app->register(BusServiceProvider::class);
        $this->app->register(ScopeServiceProvider::class);
        $this->app->register(PackageServiceProvider::class);

        $this->app['victory.boot'] = $this->app['victory.boot'] ?: true;
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