<?php namespace VictoryCms\Core\Composer\Installers;

use Closure;
use Composer\Package\PackageInterface;
use Composer\Repository\InstalledRepositoryInterface;
use VictoryCms\Core\Models\Package as Model;
use VictoryCms\Core\Providers\PackageServiceProvider;

/**
 * Class Package.
 */
class Package extends Base
{
    /**
     *
     */
    const SUPPORTS = 'victory-package';

    /**
     *
     */
    const PROVIDER = 'PackageServiceProvider';

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
     * @param PackageInterface             $package
     */
    public function install(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        parent::install($repo, $package);

        $this->process($package, function (PackageServiceProvider $provider, Model $model) use ($package) {

            // Bind the release date of he package to the model
            $model->released_at = $package->getReleaseDate()->format('Y-m-d H:i:s');

            // Call the provider install hook
            $this->call($provider, 'install');

            $model->save();
        });
    }

    /**
     * @param InstalledRepositoryInterface $repo
     * @param PackageInterface             $initial
     * @param PackageInterface             $target
     */
    public function update(InstalledRepositoryInterface $repo, PackageInterface $initial, PackageInterface $target)
    {
        parent::update($repo, $initial, $target);

        $this->process($initial, function (PackageServiceProvider $provider, Model $model) {

            // Call the provider update hook
            $this->call($provider, 'update');

            $model->save();
        });
    }

    /**
     * @param InstalledRepositoryInterface $repo
     * @param PackageInterface             $package
     */
    public function uninstall(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        parent::uninstall($repo, $package);

        $this->process($package, function (PackageServiceProvider $provider, Model $model) {

            $this->call($provider, 'destroy');

            $model->delete();
        });
    }

    /**
     * @param PackageInterface $package
     * @param Closure          $callback
     */
    public function process(PackageInterface $package, \Closure $callback)
    {
        try {
            $model = Model::firstOrNew([
                'name' => $package->getPrettyName(),
            ]);

            $model->version = $package->getPrettyVersion();
            $model->source  = $package->getSourceUrl();

            // Resolve the service provider
            $provider = $this->resolve($package, self::PROVIDER, [self::$app, $model]);

            $callback = $callback->bindTo($this);
            $callback($provider, $model, $this->io);
        } catch (\Exception $error) {
            $this->io->writeError($error->getMessage());
        }
    }
}
