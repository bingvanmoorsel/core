<?php  namespace VictoryCms\Core\Providers;

use Illuminate\Support\ServiceProvider;
use VictoryCms\Core\Models\Package;

class ComposerServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->app['view']->composer('victory.core::layout.partials.header', function($view)
        {
           $view->user = \Auth::user();
        });

        $this->app['view']->composer('victory.core::layout.partials.menu', function($view)
        {
            $view->items = Package::all();
        });
    }
}