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
            Config::set('auth.table', 'victory_heroes');
            Config::set('auth.model', 'Hero');

            Config::set('entrust.role', 'Zizaco\Entrust\EntrustRole');
            Config::set('entrust.permission', 'Zizaco\Entrust\EntrustPermission');
            Config::set('entrust.roles_table', 'victory_roles');
            Config::set('entrust.permissions_table', 'victory_permissions');
            Config::set('entrust.permission_role_table', 'victory_permission_role');
            Config::set('entrust.role_user_table', 'victory_role_hero');
        }
    }
}