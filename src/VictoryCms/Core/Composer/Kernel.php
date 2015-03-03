<?php
/**
 * Created by PhpStorm.
 * User: jrantwijk
 * Date: 3-3-2015
 * Time: 11:40
 */

namespace VictoryCms\Core\Composer;

use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

/**
 * Class Kernel
 * @package VictoryCms\Core\Composer
 */
class Kernel extends ConsoleKernel
{
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
}