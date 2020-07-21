<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelFavorite\Traits\Favoriter;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use Favoriter;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phonenumber',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function ogloszenia(){
        return $this->hasMany('App\Ogloszenie');
    }

    public function messages_sent()
    {
        return $this->hasMany('App\Message', 'sender_id');
    }

    public function messages_received()
    {
        return $this->hasMany('App\Message', 'receiver_id');
    }


}
