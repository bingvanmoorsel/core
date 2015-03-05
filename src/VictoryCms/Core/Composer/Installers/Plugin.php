<?php namespace VictoryCms\Core\Composer\Installers;


use Composer\Package\PackageInterface;
use Composer\Repository\InstalledRepositoryInterface;

/**
 * Class Plugin
 * @package VictoryCms\Core\Composer\Installers
 */
class Plugin extends Base
{
    const SUPPORTS = 'composer-plugin';

    /**
     * @param string $type
     * @return bool
     */
    public function supports($type)
    {
        return $type === self::SUPPORTS;
    }

    /**
     * @param InstalledRepositoryInterface $repo
     * @param PackageInterface $package
     */
    public function install(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        if(!$this->isCore($package)) return;

        parent::install($repo, $package);
    }

    /**
     * @param InstalledRepositoryInterface $repo
     * @param PackageInterface $initial
     * @param PackageInterface $target
     */
    public function update(InstalledRepositoryInterface $repo, PackageInterface $initial, PackageInterface $target)
    {
        if(!$this->isCore($initial)) return;

        parent::update($repo, $initial, $target);
    }

    /**
     * @param InstalledRepositoryInterface $repo
     * @param PackageInterface $package
     */
    public function uninstall(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        if(!$this->isCore($package)) return;

        parent::uninstall($repo, $package);
    }

    /**
     * @param PackageInterface $package
     * @return bool
     */
    protected function isCore(PackageInterface $package)
    {
        return $package->getPrettyName() === self::NAME;
    }
}