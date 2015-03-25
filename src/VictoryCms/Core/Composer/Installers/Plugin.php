<?php namespace VictoryCms\Core\Composer\Installers;

use Composer\Package\PackageInterface;
use Composer\Repository\InstalledRepositoryInterface;

/**
 * Class Plugin.
 */
class Plugin extends Base
{
    /**
     *
     */
    const SUPPORTS = 'composer-plugin';

    /**
     *
     */
    const PROVIDER = 'CoreServiceProvider';

    /**
     * @param string $type
     *
     * @return bool
     */
    public function supports($type)
    {
        return $type === self::SUPPORTS;
    }

    /**
     * @param InstalledRepositoryInterface $repo
     * @param PackageInterface             $initial
     * @param PackageInterface             $target
     */
    public function update(InstalledRepositoryInterface $repo, PackageInterface $initial, PackageInterface $target)
    {
        if ($initial->getPrettyName() === self::NAME) {
            return;
        }

        parent::update($repo, $initial, $target);

        $this->process($initial, 'update');
    }

    /**
     * @param InstalledRepositoryInterface $repo
     * @param PackageInterface             $package
     */
    public function uninstall(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        if ($package->getPrettyName() === self::NAME) {
            return;
        }

        parent::uninstall($repo, $package);

        $this->process($package, 'destroy');
    }

    /**
     * @param PackageInterface $package
     * @param $hook
     */
    protected function process(PackageInterface $package, $hook)
    {
        $provider = $this->resolve($package, self::PROVIDER, [self::$app]);

        $this->call($provider, $hook);
    }
}
