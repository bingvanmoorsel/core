<?php namespace VictoryCms\Core;

use Artisan;
use Illuminate\Bus\Dispatcher;
use Illuminate\Support\ServiceProvider;
use VictoryCms\Core\Models\Package;

/**
 * Class CoreServiceProvider.
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
    protected $commands = [
        'VictoryCms\Core\Console\Commands\Installer',
    ];

    /**
     * @var array
     */
    protected $providers = [
        'VictoryCms\Core\Providers\RouteServiceProvider',
        'VictoryCms\Core\Providers\ComposerServiceProvider',
        'VictoryCms\Core\Providers\HeroesServiceProvider',
        'Zizaco\Entrust\EntrustServiceProvider',
        'TwigBridge\ServiceProvider',
    ];

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->commands($this->commands);

        $victory = new Victory($this->app);

        // Bind the main entry point of Victory CMS
        $this->app->instance('victory', $victory);

        $this->app->singleton('victory.packages', function () {
            return Package::all();
        });

        if ($victory->isInstalled()) {
            foreach ($this->providers as $provider) {
                $this->app->register($provider);
            }
        }
    }

    /**
     * @param Victory    $victory
     * @param Dispatcher $dispatcher
     */
    public function boot(Victory $victory, Dispatcher $dispatcher)
    {
        if (!$victory->isInstalled()) {
            $this->app->call([$this, 'install']);
        }

        $this->loadViewsFrom(__DIR__.'/../../../resources/views/', 'victory.core');

        // Register and boot all the Victory packages
        // We simulate the Laravel registration process
        $providers = [];

        // Create the provider instances
        foreach ($victory->getPackages() as $package) {

            // Instantiate the package provider
            $providers[] = $provider = new $package->provider($this->app, $package);

            // Run the register logic
            $provider->register();
        }

        // Run the provider boot logic
        foreach ($providers as $provider) {
            if (method_exists($provider, 'boot')) {
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

        if (!is_dir($storage)) {
            mkdir($storage, 0777);
        }

        Artisan::call('migrate', [
            '--path' => 'vendor/victory-cms/core/database/migrations',
        ]);

        touch($storage.'/installed');
    }

    /**
     *
     */
    public function update()
    {
        return;
    }

    /**
     *
     */
    public function destroy()
    {
        return;
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
