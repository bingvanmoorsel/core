<?php namespace VictoryCms\Core\Commands;

use Closure;

/**
 * Class RegisterEntryCommand
 * @package VictoryCms\Core\Commands
 */
class AddControllerCommand extends Command
{
    /**
     * @var
     */
    public $name;

    /**
     * Route mapping
     * @var callable
     */
    public $mapping;

    /**
     * @param $name
     * @param callable $mapping
     */
    public function __construct($name, Closure $mapping)
    {
        $this->name = $name;
        $this->mapping = $mapping;
    }
}