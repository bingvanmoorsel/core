<?php namespace VictoryCms\Core;

use Artisan;
use Illuminate\Bus\Dispatcher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use VictoryCms\Core\Models\Package;

/**
 * Class CoreServiceProvider
 * @package VictoryCms\Core
 */
class PackageServiceProvider extends ServiceProvider
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

    /**
     * @var array
     */
    protected $commands = [
        'VictoryCms\Core\Console\Commands\Installer'
    ];

    /**	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->commands($this->commands);

        // Bind the main entry point of Victory CMS
        $this->app->singleton('victory', function(Application $app) {
            return new Victory($app);
        });

        $this->loadViewsFrom(__DIR__.'/../../../resources/views/', 'victory.core');

        // Core Providers
        $this->app->register('VictoryCms\Core\Providers\RouteServiceProvider');
        $this->app->register('VictoryCms\Core\Providers\ComposerServiceProvider');
        $this->app->register('VictoryCms\Core\Providers\HeroesServiceProvider');

        // External Providers
        $this->app->register('Zizaco\Entrust\EntrustServiceProvider');
        $this->app->register('TwigBridge\ServiceProvider');
	}

    /**
     * @param Victory $victory
     * @param Dispatcher $dispatcher
     */
    public function boot(Victory $victory, Dispatcher $dispatcher)
    {
        if(!$victory->isInstalled()) {
            $this->app->call([$this, 'install']);
        }

        // Bind some command handlers
        $dispatcher->pipeThrough($this->pipeTrough);

        $dispatcher->mapUsing(function($command) {
            return Dispatcher::simpleMapping(
                $command, 'VictoryCms\Core\Commands', 'VictoryCms\Core\Handlers\Commands'
            );
        });

        // Register and boot all the Victory packages
        // We simulate the Laravel registration process
        $providers = [];

        // Create the provider instances
        foreach(Package::all() as $package) {
            $provider = $package->provider;
            $providers[] = new $provider($this->app);
        };

        // Run the provider register logic
        foreach($providers as $provider) {
            $provider->register();
        }

        // Run the provider boot logic
        foreach($providers as $provider) {
            if(method_exists($provider, 'boot')) {
                $this->app->call([$provider, 'boot']);
            }
        }
    }

    /**
     *
     */
    public function install(Victory $victory)
    {
        $storage = $victory->storagePath();

        if(!is_dir($storage)) {
            mkdir($storage, 0777);
        }

        Artisan::call('migrate', [
            '--path' => 'vendor/victory-cms/core/database/migrations'
        ]);

        touch($storage.'/installed');
    }

    /**
     *
     */
    public function update()
    {
        echo '[CORE UPDATE]';
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