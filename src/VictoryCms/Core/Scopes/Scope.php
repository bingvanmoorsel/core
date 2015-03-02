<?php namespace VictoryCms\Core\Scopes;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Routing\Router;

/**
 * Class Scope
 * @package VictoryCms\Core
 */
abstract class Scope
{
    /**
     * @var string
     */
    protected $prefix;

    /**
     * @var array
     */
    protected $middleware = [];

    /**
     * @var Router
     */
    protected $router;

    /**
     * @param Application $app
     * @param Router $router
     */
    public function __construct(Application $app, Router $router)
    {
        $this->router = $router;

        foreach($this->middleware as $name => $middleware)
        {
            $this->router->middleware($name, $middleware);
        }
    }

    /**
     * @param callable $closure
     */
    public function map(Closure $closure)
    {
        $this->router->group([
            'prefix' => $this->prefix,
            'middleware' => array_keys($this->middleware)
        ], $closure);
    }

    /**
     * @param $value
     */
    public function setPrefix($value)
    {
        $this->prefix = trim($value, '/');
    }

    /**
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

}