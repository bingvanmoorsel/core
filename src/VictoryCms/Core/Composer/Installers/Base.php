<?php namespace VictoryCms\Core\Composer\Installers;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Util\Filesystem;
use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;
use Composer\Repository\InstalledRepositoryInterface;

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

        return $app;
    }

    /**
     * @param InstalledRepositoryInterface $repo
     * @param PackageInterface $package
     */
    public function install(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        parent::install($repo, $package);

        $this->call('install', $package->getPrettyName());
    }

    /**
     * @param InstalledRepositoryInterface $repo
     * @param PackageInterface $initial
     * @param PackageInterface $target
     */
    public function update(InstalledRepositoryInterface $repo, PackageInterface $initial, PackageInterface $target)
    {
        parent::update($repo, $initial, $target);

        $this->call('update', $initial->getPrettyName());
    }

    /**
     * @param InstalledRepositoryInterface $repo
     * @param PackageInterface $package
     */
    public function uninstall(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        parent::uninstall($repo, $package);

        $this->call('destroy', $package->getPrettyName());
    }

    /**
     * @param $action
     * @return mixed
     */
    protected function call($action, $package)
    {
        /** @var Kernel $kernel */
        $kernel = self::$app->make('Illuminate\Contracts\Console\Kernel');

        $this->io->write('[victory:installer] -> <info>'.$action.'</info>');

        return $kernel->call('victory:installer', [
            'action'    => $action,
            'package'   => $package
        ]);
    }
}