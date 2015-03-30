<?php namespace VictoryCms\Core\Composer\Installers;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Util\Filesystem;
use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Console\Kernel;
use VictoryCms\Core\CoreServiceProvider;
use VictoryCms\Core\Victory;

/**
 * Class Base.
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
     * @param IOInterface     $io
     * @param Composer        $composer
     * @param string          $type
     * @param null|Filesystem $filesystem
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
        $this->io->write('[<info>Victory</info>] Booting Laravel ' . Application::VERSION . ' framework');

        // Make sure the vendor directory exists
        $this->initializeVendorDir();

        $basePath = realpath($this->vendorDir.DIRECTORY_SEPARATOR.'..');

        // Require the composer autoloader
        require $basePath.'/bootstrap/autoload.php';

        /** @var Application $app */
        $app = require $basePath.'/bootstrap/app.php';

        /** @var Kernel $kernel */
        $kernel = $app->make('Illuminate\Contracts\Console\Kernel');

        $kernel->bootstrap();

        $this->io->write('[<info>Victory</info>] Register core service provider');

        $app->register(CoreServiceProvider::class);

        return $app;
    }

    /**
     * @param $object
     * @param string $method
     * @param array $parameters
     *
     * @return mixed
     */
    protected function call($object, $method, $parameters = [])
    {
        if (!method_exists($object, $method)) {
            return;
        }

        $this->io->write('[<info>Victory</info>] Calling ' . get_class($object) . '@' . $method . '');

        return self::$app->call([$object, $method], $parameters);
    }

    /**
     * @param PackageInterface $package
     * @param $class
     * @param array            $params
     *
     * @return object
     */
    protected function resolve(PackageInterface $package, $class, $params = [])
    {
        $name = $package->getPrettyName();

        list($vendor, $project) = explode('/', $name);

        // Get the package namespace
        $namespace = studly_case($vendor).'\\'.studly_case($project);

        // Build the provider class name
        $class = sprintf('%s\%s', $namespace, $class);

        // Make sure the class exists
        if (!class_exists($class)) {
            $file = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $class);

            require_once $this->vendorDir.'/'.$name.'/src/'.$file.'.php';
        }

        return $this->instantiate($class, $params);
    }

    /**
     * @param string $class
     * @param array $params
     *
     * @return object
     */
    protected function instantiate($class, $params = [])
    {
        return (new \ReflectionClass($class))->newInstanceArgs($params);
    }
}
