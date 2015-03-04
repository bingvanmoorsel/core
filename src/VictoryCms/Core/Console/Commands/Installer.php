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
        $action  = strtolower($this->argument('action'));
        $package = strtolower($this->argument('package'));

        switch($action)
        {
            case 'install':
                $this->install($package);
                break;

            case 'update':
                $this->update($package);
                break;

            default:
                $this->error('Invalid action: ' . $action);
        }
    }

    /**
     * @param $package
     * @return mixed
     */
    protected function install($package)
    {
        return $this->invoke($package, 'install');
    }

    /**
     * @param $package
     * @return mixed
     */
    protected function update($package)
    {
        return $this->invoke($package, 'update');
    }

    /**
     * @param $package
     * @param $method
     * @param array $parameters
     * @return mixed
     */
    protected function invoke($package, $method, $parameters = [])
    {
        if(($provider = $this->getProviderClass($package)) === false)
        {
            $this->error('Unable to instantiate package service provider');
        }

        $result =  $this->laravel->call([$provider, $method], $parameters);

        $this->comment(sprintf('[%s] -> %s', $package, $method));

        return $result;
    }

    /**
     * @param $package
     * @return bool
     */
    protected function getProviderClass($package)
    {
        $class = vsprintf('%s\%s', [
            $this->getNamespace($package),
            'PackageServiceProvider'
        ]);

        if(!class_exists($class)) return false;

        return new $class($this->laravel);
    }

    /**
     * @param $package
     * @return string
     */
    protected function getProviderNamespace($package)
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