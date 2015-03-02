<?php namespace VictoryCms\Core\Providers;

use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Support\ServiceProvider;

/**
 * Class RoutesServiceProvider
 * @package VictoryCms\Core\Providers
 */
class BusServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $pipeTrough = [];

    /**
     * @param Dispatcher $dispatcher
     */
    public function boot(Dispatcher $dispatcher)
    {
        // Bind some command handlers
        $dispatcher->pipeThrough($this->pipeTrough);

        $dispatcher->mapUsing(function($command)
        {
            return Dispatcher::simpleMapping(
                $command, 'VictoryCms\Core\Commands', 'VictoryCms\Core\Handlers\Commands'
            );
        });
    }

    /**
     *
     */
    public function register()
    {

    }
}