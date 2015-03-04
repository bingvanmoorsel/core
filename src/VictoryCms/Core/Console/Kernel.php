<?php namespace VictoryCms\Core\Console;

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
    protected $commands = [
        'VictoryCms\Core\Console\Commands\Install',
        'VictoryCms\Core\Console\Commands\Update',
    ];

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
        'Illuminate\Foundation\Bootstrap\RegisterProviders',
        'Illuminate\Foundation\Bootstrap\BootProviders',
    ];
}