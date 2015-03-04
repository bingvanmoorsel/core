<?php namespace VictoryCms\Core\Composer;

use Composer\Composer;
use Composer\Installer\InstallerInterface;
use Composer\Installer\LibraryInstaller;
use Composer\IO\IOInterface;
use Composer\Util\Filesystem;
use Composer\Package\PackageInterface;
use Composer\Repository\InstalledRepositoryInterface;
use Illuminate\Foundation\Application;
use VictoryCms\Core\Console\Kernel;
use VictoryCms\Core\Models\Package;
use VictoryCms\Core\PackageServiceProvider;

/**
 * Class Installer
 * @package VictoryCms\Core
 */
class Installer extends LibraryInstaller implements InstallerInterface
{
    /**
     * @var void
     */
    protected $app;

    /**
     * @var string
     */
    private $logo = '
 _    ___      __                      ________  ________
| |  / (_)____/ /_____  _______  __   / ____/  |/  / ___/
| | / / / ___/ __/ __ \/ ___/ / / /  / /   / /|_/ /\__ \
| |/ / / /__/ /_/ /_/ / /  / /_/ /  / /___/ /  / /___/ /
|___/_/\___/\__/\____/_/   \__, /   \____/_/  /_//____/
                          /____/
                          ';

    /**
     * @var array
     */
    protected $bootstrappers = [
        'Illuminate\Foundation\Bootstrap\DetectEnvironment',
        'Illuminate\Foundation\Bootstrap\LoadConfiguration',
        'Illuminate\Foundation\Bootstrap\ConfigureLogging',
        'Illuminate\Foundation\Bootstrap\HandleExceptions',
        'Illuminate\Foundation\Bootstrap\RegisterFacades',
        'Illuminate\Foundation\Bootstrap\SetRequestForConsole',
        'Illuminate\Foundation\Bootstrap\RegisterProviders',
    ];

    /**
     * @var Application
     */
    private static $laravel;

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
        $this->app = self::$laravel ?: $this->boot();
    }

    /**
     * Decides if the installer supports the given type
     *
     * @param  string $type
     * @return bool
     */
    public function supports($type)
    {
        return $type === 'victory-package' || $type === 'composer-plugin';
    }

    /**
     * @param PackageInterface $package
     * @return bool
     */
    public function isCore(PackageInterface $package)
    {
        return $package->getPrettyName() === 'victory-cms/core';
    }

    /**
     * @param PackageInterface $package
     * @return bool
     */
    public function isComposerPlugin(PackageInterface $package)
    {
        return $package->getType() === 'composer-plugin';
    }

    /**
     * Installs specific package.
     *
     * @param InstalledRepositoryInterface $repo repository in which to check
     * @param PackageInterface $package package instance
     */
    public function install(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        // Only install the Victory core (composer-plugin) and packages
        if($this->isComposerPlugin($package) && !$this->isCore($package)) return;

        parent::install($repo, $package);

        // Get the package name
        $name = $package->getPrettyName();

        // Split the name to get the vendor and project name
        list($vendor, $project) = explode('/', $name);

        if(!$this->isCore($package)) {
            // Temporarily unguard the model
            Package::unguard();

            Package::create([
                'name'        => $name,
                'vendor'      => $vendor,
                'project'     => $project,
                'version'     => $package->getPrettyVersion(),
                'source'      => $package->getSourceUrl(),
                'released_at' => $package->getReleaseDate()->getTimestamp(),
            ]);
        }

        // Run the custom install logic
        $this->call('install', $name);
    }

    /**
     * Updates specific package.
     *
     * @param InstalledRepositoryInterface $repo repository in which to check
     * @param PackageInterface $initial already installed package version
     * @param PackageInterface $target updated version
     *
     * @throws InvalidArgumentException if $initial package is not installed
     */
    public function update(InstalledRepositoryInterface $repo, PackageInterface $initial, PackageInterface $target)
    {
        // Only update the Victory core (composer-plugin) and packages
        if($this->isComposerPlugin($initial) && !$this->isCore($initial)) return;

        parent::update($repo, $initial, $target);

        $name = $initial->getPrettyName();

        // Run the custom update logic
        $this->call('update', $name);

        if(!$this->isCore($initial)) {
            // Get the package model
            $package = Package::where('name', $name)->first();

            // Update the version
            $package->version = $target->getPrettyVersion();

            // Save the model
            $package->save();
        }
    }

    /**
     * @param InstalledRepositoryInterface $repo
     * @param PackageInterface $package
     */
    public function uninstall(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        // Only remove the Victory core (composer-plugin) and packages
        if($this->isComposerPlugin($package) && !$this->isCore($package)) return;

        // Get the package name
        $name = $package->getPrettyName();

        // Call the installer destroy command
        $this->call('destroy', $name);

        if(!$this->isCore($package)) {
            // Get the first package record by name
            Package::where('name', $name)->delete();
        }

        parent::uninstall($repo, $package);
    }

    /**
     * Boot a simplified Laravel application
     * @return void
     */
    public function boot()
    {
        $this->io->write($this->logo);

        // Make sure the vendor directory exists
        $this->initializeVendorDir();

        // Require the composer autoloader
        require $this->vendorDir.'/../bootstrap/autoload.php';

        /** @var Application $app */
        $app = require $this->vendorDir.'/../bootstrap/app.php';

        /** @var Kernel $kernel */
        $kernel = $app->make('Illuminate\Contracts\Console\Kernel');

        // Bootstrap the kernel
        $kernel->bootstrap();

        // Register the core provider
        $app->register(PackageServiceProvider::class);

        return (self::$laravel = $app);
    }

    /**
     * @param $action
     * @return mixed
     */
    protected function call($action, $package)
    {
        /** @var Kernel $kernel */
        $kernel = $this->app->make('Illuminate\Contracts\Console\Kernel');

        $this->io->write('[victory:installer] -> <info>'.$action.'</info>');

        return $kernel->call('victory:installer', [
            'action'    => $action,
            'package'   => $package
        ]);
    }
}