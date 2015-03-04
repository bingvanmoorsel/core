<?php namespace VictoryCms\Core;

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

        // Bind the CMS scopes
        $this->app->singleton(
            'VictoryCms\Core\Contracts\Scope\Backend',
            'VictoryCms\Core\Scopes\Backend'
        );

        $this->app->singleton(
            'VictoryCms\Core\Contracts\Scope\Frontend',
            'VictoryCms\Core\Scopes\Frontend'
        );
	}

    /**
     * @param Victory $victory
     * @param Dispatcher $dispatcher
     */
    public function boot(Victory $victory, Dispatcher $dispatcher)
    {
        if(!$victory->isInstalled()) {
            return $this->install();
        }

        // Bind some command handlers
        $dispatcher->pipeThrough($this->pipeTrough);

        $dispatcher->mapUsing(function($command) {
            return Dispatcher::simpleMapping(
                $command, 'VictoryCms\Core\Commands', 'VictoryCms\Core\Handlers\Commands'
            );
        });

        // Register and boot all the Victory packages
        $packages = Package::all();

        foreach($packages as $package) {
            ///var_dump($packages->provider);
        }
    }

    /**
     *
     */
    public function install()
    {
        $path = $this->storagePath();

        if(!is_dir($path)) {
            mkdir($path, 0777);
        }

        $artisan = $this->app->make('Illuminate\Contracts\Console\Kernel');

        $artisan->call('migrate', [
            '--path' => 'vendor/victory-cms/core/database/migrations'
        ]);

        touch($path.'/installed');
    }

    /**
     *
     */
    public function update()
    {
        echo 'update!!!';
    }

    /**
     * @return bool
     */
    public function isInstalled()
    {
        return file_exists($this->storagePath().'/installed');
    }

    /**
     * @return string
     */
    public function storagePath()
    {
        return $this->app['path.storage'].'/victory/';
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