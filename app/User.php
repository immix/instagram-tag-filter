<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\User
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $instagram_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereInstagramId($value)
 */
class User extends Model
{
    /**
     * @var array
     */
    protected $guarded = [
        'created_at', 'updated_at',
    ];
}
