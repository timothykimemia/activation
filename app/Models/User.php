<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use App\Models\Activation\ActivationToken;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'active', 'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /******************************************************************************************************************/

    /**
     * @param $email
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public static function byEmail($email)
    {
        return static::where('email', $email)->firstOrFail();
    }

    /******************************************************************************************************************/

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function activationToken()
    {
        return $this->hasOne(ActivationToken::class);
    }

    /******************************************************************************************************************/

    /**
     * @return bool
     */
    public function hasActivationToken()
    {
        return (bool) $this->activationToken;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createActivationToken()
    {
        return $this->activationToken()->create([ 'token' => str_random(200)]);
    }

    /**
     * @return mixed
     */
    public function deleteActivationToken()
    {
        return $this->activationToken()->delete();
    }

    /******************************************************************************************************************/
}
