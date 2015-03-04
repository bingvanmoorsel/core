<?php namespace VictoryCms\Core\Console;

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
        'VictoryCms\Core\Console\Commands\Installer'
    ];
}