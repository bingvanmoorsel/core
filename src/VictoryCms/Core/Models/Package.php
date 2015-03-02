<?php namespace VictoryCms\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Package
 * @package VictoryCms\Core
 */
class Package extends Model
{
    /**
     * @var string
     */
    protected $table = 'victory_packages';

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @param Builder $query
     * @param $name
     */
    public function scopeFilter(Builder $query, $name)
    {
        $query->where('name', 'LIKE', "%$name%");
    }
}