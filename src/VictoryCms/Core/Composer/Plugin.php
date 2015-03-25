<?php namespace VictoryCms\Core\Composer;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use VictoryCms\Core\Composer\Installers\Plugin as PluginInstaller;
use VictoryCms\Core\Composer\Installers\Package as PackageInstaller;

/**
 * Class Plugin.
 */
class Plugin implements PluginInterface
{
    /**
     * @param Composer    $composer
     * @param IOInterface $io
     */
    public function activate(Composer $composer, IOInterface $io)
    {
        $manager = $composer->getInstallationManager();

        $manager->addInstaller(new PluginInstaller($io, $composer));
        $manager->addInstaller(new PackageInstaller($io, $composer));
    }
}
