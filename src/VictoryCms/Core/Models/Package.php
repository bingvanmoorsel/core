<?php namespace VictoryCms\Core\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class Package.
 */
class Package extends Model
{
    /**
     * @var string
     */
    protected $table = 'packages';

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'version', 'source',
    ];

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
        return studly_case($this->vendor).'\\'.studly_case($this->project).'\\PackageServiceProvider';
    }
}
