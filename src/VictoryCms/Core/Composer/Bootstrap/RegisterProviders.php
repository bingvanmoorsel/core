<?php namespace VictoryCms\Core\Composer\Bootstrap;

use Illuminate\Contracts\Foundation\Application;
use VictoryCms\Core\Providers\CoreServiceProvider;
use Illuminate\Foundation\Bootstrap\RegisterFacades as Provider;

/**
 * Class RegisterProviders
 * @package VictoryCms\Core\Composer\Bootstrap
 */
class RegisterProviders extends Provider
{
    /**
     * @param Application $app
     */
    public function bootstrap(Application $app)
    {
        parent::bootstrap($app);

        $app->register(CoreServiceProvider::class);
    }
}