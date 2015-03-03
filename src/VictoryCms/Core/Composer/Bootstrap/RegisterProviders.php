<?php namespace VictoryCms\Core\Composer\Bootstrap;

use Illuminate\Contracts\Config\Repository;
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
     * @param Repository $config
     */
    public function bootstrap(Application $app, Repository $config)
    {
        echo 'bootstrap';
        $providers = $config['app.providers'];

        if(!in_array(CoreServiceProvider::class, $providers)) {
            $providers[] = CoreServiceProvider::class;
        }

        $app->registerConfiguredProviders();
    }
}