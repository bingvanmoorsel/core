<?php namespace VictoryCms\Core\Composer\Installers;

use Composer\Package\PackageInterface;
use Composer\Repository\InstalledRepositoryInterface;
use VictoryCms\Core\Models\Package as Model;

/**
 * Class Package
 * @package VictoryCms\Core\Composer\Installers
 */
class Package extends Base
{
    /**
     *
     */
    const SUPPORTS = 'victory-package';

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
        parent::install($repo, $package);

        $this->packageSave($package);
    }

    /**
     * @param InstalledRepositoryInterface $repo
     * @param PackageInterface $initial
     * @param PackageInterface $target
     */
    public function update(InstalledRepositoryInterface $repo, PackageInterface $initial, PackageInterface $target)
    {
        parent::update($repo, $initial, $target);

        $this->packageSave($target);
    }

    /**
     * @param InstalledRepositoryInterface $repo
     * @param PackageInterface $package
     */
    public function uninstall(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        parent::uninstall($repo, $package);

        $this->packageDelete($package);
    }

    /**
     * @param PackageInterface $package
     * @return mixed
     */
    public function packageSave(PackageInterface $package)
    {
        $record = Model::firstOrNew([
            'name' => $package->getPrettyName()
        ]);

        $record->version = $package->getPrettyVersion();
        $record->source  = $package->getSourceUrl();

        // Format the release date
        $record->released_at = $package->getReleaseDate()
            ->format('Y-m-d H:i:s');

        return $record->save();
    }

    /**
     * @param PackageInterface $package
     * @return mixed
     */
    public function packageDelete(PackageInterface $package)
    {
        return Model::where('name', $package->getPrettyName())->delete();
    }
}