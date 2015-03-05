<?php namespace VictoryCms\Core\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use VictoryCms\Core\Models\Package;

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

            case 'destroy':
                $this->destroy($package);
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
        $this->invoke($this->resolve($package), 'install');
    }

    /**
     * @param $package
     * @return mixed
     */
    protected function update($package)
    {
        $this->invoke($this->resolve($package), 'update');
    }

    /**
     * @param $package
     */
    protected function destroy($package)
    {
        $this->invoke($this->resolve($package), 'destroy');
    }

    /**
     * @param ServiceProvider $provider
     * @param $method
     * @param array $parameters
     * @return mixed
     */
    protected function invoke(ServiceProvider $provider, $method, $parameters = [])
    {
        if(!method_exists($provider, $method)) return;

        call_user_func_array([$provider, $method], $parameters);
    }

    /**
     * @param $package
     * @return bool
     */
    protected function resolve($package)
    {
        list($vendor, $project) = explode('/', $package);

        // Get the package namespace
        $namespace = studly_case($vendor) . '\\' . studly_case($project);

        // Build the provider class name
        $class = sprintf('%s\%s', $namespace, 'PackageServiceProvider');

        // Make sure the class exists
        if(!class_exists($class)) return false;

        return new $class($this->laravel);
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