<?php

namespace VictoryCms\Core\Providers;

use VictoryCms\Core\Models\Package;

/**
 * Class ComposerServiceProvider.
 */
class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        //
    }

    /**
     *
     */
    public function boot()
    {
        $this->app['view']->composer('victory.core::layout.partials.header', function ($view) {
           $view->user = \Auth::user();
        });

        $this->app['view']->composer('victory.core::layout.partials.menu', function ($view) {
            $view->items = Package::all();
        });
    }
}
