<?php namespace VictoryCms\Core\Composer\Installers;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Util\Filesystem;
use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;
use Composer\Repository\InstalledRepositoryInterface;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use VictoryCms\Core\PackageServiceProvider;
use VictoryCms\Core\Victory;

/**
 * Class Base
 * @package VictoryCms\Core\Composer\Installers
 */
abstract class Base extends LibraryInstaller
{
    /**
     *
     */
    const NAME = 'victory-cms/core';

    /**
     * @var Application
     */
    protected static $app;

    /**
     * @param IOInterface $io
     * @param Composer $composer
     * @param string $type
     * @param Filesystem $filesystem
     */
    public function __construct(IOInterface $io, Composer $composer, $type = 'library', Filesystem $filesystem = null)
    {
        parent::__construct($io, $composer, $type, $filesystem);

        // Boot a stripped Laravel application
        self::$app = self::$app ?: $this->boot();
    }

    /**
     * @return Application
     */
    protected function boot()
    {
        // Make sure the vendor directory exists
        $this->initializeVendorDir();

        // Require the composer autoloader
        require $this->vendorDir.'/../bootstrap/autoload.php';

        /** @var Application $app */
        $app = require $this->vendorDir.'/../bootstrap/app.php';

        $app->bootstrapWith([
            'Illuminate\Foundation\Bootstrap\DetectEnvironment',
            'Illuminate\Foundation\Bootstrap\LoadConfiguration',
            'Illuminate\Foundation\Bootstrap\ConfigureLogging',
            'Illuminate\Foundation\Bootstrap\HandleExceptions',
            'Illuminate\Foundation\Bootstrap\RegisterFacades',
            'Illuminate\Foundation\Bootstrap\SetRequestForConsole',
            'Illuminate\Foundation\Bootstrap\RegisterProviders'
        ]);

        $app->register(PackageServiceProvider::class);
        $app->boot();

        return $app;
    }

    /**
     * @param InstalledRepositoryInterface $repo
     * @param PackageInterface $package
     */
    public function install(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        parent::install($repo, $package);

        $this->call($package, 'install');
    }

    /**
     * @param InstalledRepositoryInterface $repo
     * @param PackageInterface $initial
     * @param PackageInterface $target
     */
    public function update(InstalledRepositoryInterface $repo, PackageInterface $initial, PackageInterface $target)
    {
        parent::update($repo, $initial, $target);

        $this->call($initial, 'update');
    }

    /**
     * @param InstalledRepositoryInterface $repo
     * @param PackageInterface $package
     */
    public function uninstall(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        parent::uninstall($repo, $package);

        $this->call($package, 'destroy');
    }

    /**
     * @param PackageInterface $package
     * @param $method
     * @param array $parameters
     * @return mixed
     */
    protected function call(PackageInterface $package, $method, $parameters = [])
    {
        $provider = $this->resolve($package);

        $this->io->write('[<comment>'.get_class($provider).'</comment>] -> <info>'.$method.'</info>');

        if(!method_exists($provider, $method)) return false;

        return self::$app->call([$provider, $method], $parameters);
    }

    /**
     * @param PackageInterface $package
     * @return bool
     */
    protected function resolve(PackageInterface $package)
    {
        $name = $package->getPrettyName();

        list($vendor, $project) = explode('/', $name);

        // Get the package namespace
        $namespace = studly_case($vendor) . '\\' . studly_case($project);

        // Build the provider class name
        $class = sprintf('%s\%s', $namespace, 'PackageServiceProvider');

        // Make sure the class exists
        if(!class_exists($class)) {
            require $this->vendorDir.'/'.$name.'/PackageServiceProvider.php';
        }

        return new $class(self::$app);
    }
}