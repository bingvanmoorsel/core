<?php  namespace VictoryCms\Core\Providers;

use Illuminate\Support\ServiceProvider;

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
    }
}