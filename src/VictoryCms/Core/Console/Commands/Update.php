<?php
/**
 * Created by PhpStorm.
 * User: jrantwijk
 * Date: 4-3-2015
 * Time: 13:01
 */

namespace VictoryCms\Core\Console\Commands;

use Illuminate\Console\Command;

/**
 * Class Install
 * @package VictoryCms\Core\Console\Commands
 */
class Update extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'victory:package-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display an inspiring quote';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $package = $this->argument();

        $class = vsprintf('%s\%s', [
            $this->getNamespace($package),
            'PackageServiceProvider'
        ]);

        dd('Update ' . $package);
    }
    
    /**
     * @param $package
     * @return string
     */
    protected function getNamespace($package)
    {
        list($vendor, $project) = explode('/', $package);

        return studly_case($vendor) . '\\' . studly_case($project);
    }

}