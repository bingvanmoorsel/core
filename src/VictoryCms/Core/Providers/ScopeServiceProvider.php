<?php namespace VictoryCms\Core\Providers;

use Illuminate\Contracts\Console\Application;
use Illuminate\Support\ServiceProvider;

/**
 * Class ScopeServiceProvider
 * @package VictoryCms\Core\Providers
 */
class ScopeServiceProvider extends ServiceProvider
{
    /**
     *
     */
    public function register()
    {
        $this->app->singleton(
            'VictoryCms\Core\Contracts\Scope\Backend',
            'VictoryCms\Core\Scopes\Backend'
        );

        $this->app->singleton(
            'VictoryCms\Core\Contracts\Scope\Frontend',
            'VictoryCms\Core\Scopes\Frontend'
        );
    }
}