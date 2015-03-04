<?php namespace VictoryCms\Core\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

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
    public function fire()
    {
//        $package = $this->argument();
//
//        $class = vsprintf('%s\%s', [
//            $this->getNamespace($package),
//            'PackageServiceProvider'
//        ]);

        var_dump($this->argument('action'), $this->argument('package'));
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


    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['action', InputArgument::REQUIRED, 'The action [install|update|destroy]'],
            ['package', InputArgument::REQUIRED, 'The package [vendor/project]'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }
}