<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Auth\Passwords\CanResetPassword;
use Kbwebs\MultiAuth\PasswordResets\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
//use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Kbwebs\MultiAuth\PasswordResets\Contracts\CanResetPassword as CanResetPasswordContract;
class Customer extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'customers';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function getGravatarAttribute()
    {
        $hash = md5(strtolower(trim($this->attributes['pic_email'])));
        return "http://www.gravatar.com/avatar/$hash";
    }


    // Customer ads relationship
    public function ads()
    {
        return $this->hasMany('App\Models\Ad', 'customer_id', 'id');
    }

    public function notifications()
    {
        return $this->hasMany('App\Models\Notification', 'user_id', 'id');
    }

    public function listings()
    {
        return $this->hasMany('App\Models\Listing', 'customer_id', 'customer_id');
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function($customer) {
            $customer->listings()->delete();
            $customer->ads()->delete();
        });
    }

    public function address()
    {
        return $this->hasOne('App\Models\Address', 'address_id', 'address_id');
    }
}