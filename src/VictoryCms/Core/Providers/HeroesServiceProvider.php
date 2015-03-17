<?php namespace VictoryCms\Core\Providers;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use VictoryCms\Core\Models\Hero;
use VictoryCms\Core\Providers\Guard\HeroGuard;

class HeroesServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        \Auth::extend('eloquent.hero', function($app)
        {
            return new HeroGuard(new EloquentUserProvider($app['hash'], Hero::class), $app['session.store']);
        });

        if ($this->app['request']->is('victory*'))
        {
            Config::set('auth.driver', 'eloquent.hero');
            Config::set('auth.model', 'Hero');
        }
    }
}