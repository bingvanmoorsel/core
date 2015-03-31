<?php namespace VictoryCms\Core;

use Illuminate\Contracts\Foundation\Application;
use VictoryCms\Core\Models\Package;
use VictoryCms\Core\Providers\ServiceProvider;
use VictoryCms\Core\Seeders\DatabaseSeeder;
use VictoryCms\Core\Traits\PackageTrait;

/**
 * Class CoreServiceProvider.
 */
class CoreServiceProvider extends ServiceProvider
{
    use PackageTrait;

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
     * @var string
     */
    protected $basePath;

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        parent::__construct($app);

        $this->basePath = realpath(__DIR__ .str_repeat('../', 4));
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $victory = new Victory($this->app);

        // Bind the main entry point of Victory CMS
        $this->app->instance('victory', $victory);

        $this->app->singleton('victory.packages', function () {
            return Package::all();
        });

        if(!$victory->isInstalled()) {
            return;
        }

        foreach ($this->providers as $provider) {
            $this->app->register($provider);
        }

        // publish public files to victory-cms folder
        $this->publishes([
            $this->getBasePath('public') => public_path('victory-cms/core'),
        ], 'victory.core.public');
    }

    /**
     * @param Victory $victory
     */
    public function boot(Victory $victory)
    {
        if (!$victory->isInstalled()) {
            $this->app->call([$this, 'install']);
        }

        $this->commands($this->commands);

        $this->loadViewsFrom($this->getResourcePath('views'), 'victory.core');
        $this->loadTranslationsFrom($this->getResourcePath('lang'), 'victory.core');

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
     * @param Victory $victory
     */
    public function install(Victory $victory)
    {
        $storagePath = $victory->getStoragePath();

        if (!is_dir($storagePath)) {
            mkdir($storagePath, 0777);
        }

        $this->update();

        \Artisan::call('db:seed', [
            '--class' => DatabaseSeeder::class
        ]);

        touch($storagePath.'/installed');
    }

    /**
     * @return void
     */
    public function update()
    {
        \Artisan::call('migrate', [
            '--path' => $this->getDatabasePath('migrations')
        ]);

        \Artisan::call('vendor:publish', [
            '--provider' => self::class
        ]);
    }

    /**
     * @return void
     */
    public function destroy()
    {
        return;
    }

    /**
     * @return string
     */
    public function getBasePath($path = '')
    {
        return $this->basePath.($path ? '/'.$path : $path);
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
