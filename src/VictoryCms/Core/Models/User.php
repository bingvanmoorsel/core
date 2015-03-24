<?php namespace VictoryCms\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class User extends Model
{
    /**
     * @var string
     */
    protected $table = 'victory_users';

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
    }
}