<?php namespace VictoryCms\Core\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // TODO: Implement register() method.
    }

    public function boot(Router $router)
    {
//        $router->whenRegex('/victory(?!\/login).*/i', 'victory.auth');

        $router->filter('victory.auth', 'VictoryCms\Core\Filters\Authenticate');
        $router->when('victory*', 'victory.auth');

        $router->get('victory', [
            'as' => 'victory.auth.home',
            'uses' => 'VictoryCms\Core\Http\Controllers\LoginController@index'
            ]);

        $router->get('victory/login', [
            'as' => 'victory.auth.login',
            'uses' => 'VictoryCms\Core\Http\Controllers\LoginController@getLogin'
            ]);

        $router->post('victory/login',
            [
                'as' => 'victory.auth.login',
                'uses' => 'VictoryCms\Core\Http\Controllers\LoginController@postLogin'
            ]);

        $router->get('victory/logout', [
                'as' => 'victory.auth.logout',
                'uses' => 'VictoryCms\Core\Http\Controllers\LoginController@getLogout'
            ]);

    }
}
