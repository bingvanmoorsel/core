<?php namespace VictoryCms\Core\Composer\Bootstrap;

use Illuminate\Contracts\Foundation\Application;
use VictoryCms\Core\Providers\CoreServiceProvider;

/**
 * Class RegisterProviders
 * @package VictoryCms\Core\Composer\Bootstrap
 */
class RegisterProviders
{
    /**
     * @param Application $app
     */
    public function bootstrap(Application $app)
    {
        $providers = $app['config']['app.providers'];

        if(!in_array(CoreServiceProvider::class, $providers)) {
            array_push($providers, CoreServiceProvider::class);
        }

        var_dump($app['config']['app.providers']);

        $app->registerConfiguredProviders();
    }
}