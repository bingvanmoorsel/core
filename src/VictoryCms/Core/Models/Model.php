<?php namespace VictoryCms\Core\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Model.
 */
abstract class Model extends Eloquent
{
    /**
     * @var string
     */
    protected $prefix = 'victory_';

    /**
     * @return string
     */
    public function getTable()
    {
        return $this->prefix.parent::getTable();
    }
}
