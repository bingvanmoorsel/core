<?php namespace VictoryCms\Core;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Collection;
use VictoryCms\Core\Scopes\Scope;

/**
 * Class Victory
 * @package VictoryCms\Core
 */
class Victory
{
    /**
     * @var string
     */
    const VERSION = '0.1.0';

    /**
     * @var Application
     */
    protected $app;

    /**
     * @var string
     */
    protected $storagePath;

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->storagePath = $this->app->storagePath().'/victory';
    }

    /**
     * @return string
     */
    public function version()
    {
        return self::VERSION;
    }

    /**
     * @return void
     */
    public function install()
    {
//        if($this->isInstalled()) return;
//
//        // Check if the storage directory exists
//        if(!is_dir($this->storagePath)) {
//            mkdir($this->storagePath, 0777)
//        }
//
//        /** @var \Illuminate\Console\Application $artisan */
//        $artisan = $this->app->make('Illuminate\Contracts\Console\Kernel')->getArtisan();
//
//        // Run the installer migrations
//        $artisan->call('migrate', [
//            '--path' => 'vendor/victory-cms/core/database/migrations'
//        ]);
//
//        touch($this->storagePath.'/installed');
    }

    /**
     * @return bool
     */
    public function isInstalled()
    {
        return file_exists($this->storagePath.'/installed');
    }

    /**
     * @param $name
     * @return Scope
     */
    public function scope($name)
    {
        return $this->app->make('VictoryCms\Core\Scopes\\'.studly_case($name));
    }
}