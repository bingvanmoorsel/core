<?php namespace VictoryCms\Core\Composer;

use Illuminate\Console\Application;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

/**
 * Class Kernel
 * @package VictoryCms\Core\Composer
 */
class Kernel extends ConsoleKernel
{
    /**
     * @var array
     */
    protected $commands = [];

    /**
     * Overwrite the provider registration provider
     * @var array
     */
    protected $bootstrappers = [
        'Illuminate\Foundation\Bootstrap\DetectEnvironment',
        'Illuminate\Foundation\Bootstrap\LoadConfiguration',
        'Illuminate\Foundation\Bootstrap\ConfigureLogging',
        'Illuminate\Foundation\Bootstrap\HandleExceptions',
        'Illuminate\Foundation\Bootstrap\RegisterFacades',
        'Illuminate\Foundation\Bootstrap\SetRequestForConsole',
        'VictoryCms\Core\Composer\Bootstrap\RegisterProviders',
        'Illuminate\Foundation\Bootstrap\BootProviders',
    ];

    /**
     * Make this function public so it is possible to call
     * commands without bootstrapping
     *
     * @return Application
     */
    public function getArtisan()
    {
        return parent::getArtisan();
    }
}