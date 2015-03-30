<?php namespace VictoryCms\Core\Providers;

use Illuminate\Routing\Router;

/**
 * Class RouteServiceProvider
 * @package VictoryCms\Core\Providers
 */
class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        // TODO: Implement register() method.
    }

    /**
     * @param Router $router
     */
    public function boot(Router $router)
    {
        $router->whenRegex('/victory(?!\/login).*/i', 'victory.auth');

//        $router->filter('victory.auth', 'VictoryCms\Core\Filters\Authenticate');
        $router->when('victory*', 'victory.auth');

        $router->group([
            'namespace' => 'VictoryCms\Core\Http\Controllers',
            'prefix' => 'victory',
        ], function (Router $router) {
            $router->get('/', ['as'   => 'victory.auth.home', 'uses' => 'LoginController@index']);
            $router->get('login', ['as'   => 'victory.auth.login', 'uses' => 'LoginController@getLogin']);
            $router->post('login', ['as' => 'victory.auth.login', 'uses' => 'LoginController@postLogin']);
            $router->get('logout', ['as' => 'victory.auth.logout', 'uses' => 'LoginController@getLogout']);

            $router->get('test', 'PackageController@index');
        });
    }
}
