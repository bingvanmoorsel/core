<?php namespace VictoryCms\Core\Composer;

use Composer\Composer;
use Composer\Installer\InstallerInterface;
use Composer\Installer\LibraryInstaller;
use Composer\IO\IOInterface;
use Composer\Util\Filesystem;
use Composer\Package\PackageInterface;
use Composer\Repository\InstalledRepositoryInterface;
use Illuminate\Console\Application as Artisan;
use Illuminate\Foundation\Application;
use VictoryCms\Core\Models\Package;
use VictoryCms\Core\Providers\CoreServiceProvider;

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
        'Illuminate\Foundation\Bootstrap\RegisterProviders',
        'Illuminate\Foundation\Bootstrap\BootProviders',
    ];

    /**
     * @var string
     */
    protected $provider = CoreServiceProvider::class;

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
        return $type === 'victory-package';
    }

    /**
     * Installs specific package.
     *
     * @param InstalledRepositoryInterface $repo repository in which to check
     * @param PackageInterface $package package instance
     */
    public function install(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        parent::install($repo, $package);

        // Get the package name
        $name = $package->getPrettyName();

        // Split the name to get the vendor and project name
        list($vendor, $project) = explode('/', $name);

        Package::unguard();

        Package::create([
            'name'        => $name,
            'vendor'      => $vendor,
            'project'     => $project,
            'version'     => $package->getPrettyVersion(),
            'source'      => $package->getSourceUrl(),
            'released_at' => $package->getReleaseDate()->getTimestamp(),
        ]);

        // Run the custom install logic
        if($this->call($this->getProviderClass($package), 'install') !== false)
        {
            $this->io->write('Calling '.$package->getPrettyName().' -> install [<info>OK</info>]');
        }
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
        parent::update($repo, $initial, $target);

        // Get the first package record by name
        $record = Package::where('name', $initial->getName())
            ->first();

        // Update the updated_at field
        $record->touch();

        // Run the custom update logic
        if($this->call($this->getProviderClass($initial), 'update') !== false)
        {
            $this->io->write('Calling '.$initial->getPrettyName().' -> update [<info>OK</info>]');
        }
    }

    /**
     * @param InstalledRepositoryInterface $repo
     * @param PackageInterface $package
     */
    public function uninstall(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        $name = $package->getPrettyName();

        // Run the custom update logic
        if($this->call($this->getProviderClass($package), 'destroy') !== false)
        {
            $this->io->write('Calling '.$name.' -> destroy [<info>OK</info>]');
        }

        // Get the first package record by name
        $record = Package::where('name', $name)
            ->first();

        $record->delete();

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
        require $this->vendorDir.'/autoload.php';

        // Get the application
        $app = new Application(
            realpath($this->vendorDir.'/../')
        );

        // Bind the Laravel bootstrappers
        $app->bootstrapWith($this->bootstrappers);

        // Register the Victory Core service provider
        $app->register($this->provider, [
            'victory.boot' => false
        ]);

        $app->loadDeferredProviders();

        // Boot the application (Laravel)
        $app->boot();

        $artisan = new Artisan($app, $app['events']);

        // Create the missing artisan binding
        $app->singleton('Illuminate\Contracts\Console\Kernel', function() use ($artisan)
        {
            return $artisan;
        });

        // Run the installer migrations
        $artisan->call('migrate', [
            '--path' => 'vendor/victory-cms/core/database/migrations'
        ]);

        return (self::$laravel = $app);
    }

    /**
     * @param $class
     * @param $method
     * @param array $parameters
     * @return bool|mixed
     */
    protected function call($class, $method, $parameters = [])
    {
        if(method_exists($class, $method))
        {
            return $this->app->call([$class, $method], $parameters);
        }

        return false;
    }

    /**
     * @param PackageInterface $package
     * @return string
     */
    protected function getProviderFile(PackageInterface $package)
    {
        $base = $this->getPackageBasePath($package);
        $namespace = $this->getProviderNamespace($package);

        return $base.'/src/'.str_replace('\\', '/', $namespace).'/PackageServiceProvider.php';
    }

    /**
     * @param PackageInterface $package
     * @return mixed
     * @throws \Illuminate\Container\BindingResolutionException
     */
    protected function getProviderClass(PackageInterface $package)
    {
        $namespace = $this->getProviderNamespace($package);
        $file      = $this->getProviderFile($package);
        $class     = $namespace.'\\PackageServiceProvider';

        if(!class_exists($class))
        {
            if(!file_exists($file))
            {
                return false;
            }

            // Require the service provider
            require $file;
        }

        if(!class_exists($class))
        {
            return false;
        }

        // Build the provider instance
        return new $class($this->app);
    }

    /**
     * @param PackageInterface $package
     * @return string
     */
    protected function getProviderNamespace(PackageInterface $package)
    {
        list($vendor, $project) = explode('/', $package->getPrettyName());

        return studly_case($vendor).'\\'.studly_case($project);
    }
}