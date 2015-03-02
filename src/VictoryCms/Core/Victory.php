<?php
/**
 * Created by PhpStorm.
 * User: jrantwijk
 * Date: 26-2-2015
 * Time: 13:28
 */

namespace VictoryCms\Core;

use ArrayIterator;
use Traversable;
use Countable;
use IteratorAggregate;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Collection;
use VictoryCms\Core\Scopes\Scope;


/**
 * Class Victory
 * @package VictoryCms\Core
 */
class Victory implements Countable, IteratorAggregate
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
     * @var Collection
     */
    protected $scopes;

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->scopes = new Collection();
    }

    /**
     * @return string
     */
    public function version()
    {
        return self::VERSION;
    }

    /**
     * @param $name
     * @return Scope
     */
    public function scope($name)
    {
        return $this->app->make('VictoryCms\Core\Scopes\\'.studly_case($name));
    }

    /**
     * @return Collection
     */
    public function getScopes()
    {
        return $this->scopes;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     */
    public function getIterator()
    {
        new ArrayIterator($this->getScopes());
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     */
    public function count()
    {
        return $this->scopes->count();
    }
}