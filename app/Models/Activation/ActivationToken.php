<?php

namespace App\Models\Activation;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ActivationToken extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'token'
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'token';
    }

    /******************************************************************************************************************/

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /******************************************************************************************************************/

    /**
     * @param $token
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public static function byToken($token)
    {
        return static::where('token', $token)->firstOrFail();
    }

    /******************************************************************************************************************/
}
