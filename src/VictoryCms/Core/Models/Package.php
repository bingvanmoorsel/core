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

    /**
     * @return string
     */
    public function getVendorAttribute()
    {
        return head(explode('/', $this->name));
    }

    /**
     * @return string
     */
    public function getProjectAttribute()
    {
        return last(explode('/', $this->name));
    }

    /**
     * @return string
     */
    public function getProviderAttribute()
    {
        return studly_case($this->vendor) . '\\' . studly_case($this->project) . '\\PackageServiceProvider';
    }
}