<?php namespace VictoryCms\Core\Console\Commands;

use Illuminate\Console\Command;

/**
 * Class Install
 * @package VictoryCms\Core\Console\Commands
 */
class Installer extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'victory:installer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Victory CMS package installer';

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

        dd('Install ' . $package);
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