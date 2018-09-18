<?php

namespace SocialNetwork;
use SocialNetwork\Traits\Friendable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Cache;

class User extends Authenticatable
{
    use Notifiable;
    use Friendable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','gender','slug','email','pic','role', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    public function isRole(){
        return $this->role;// mysql table column
    }
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function profile(){
        return $this->hasOne('SocialNetwork\Profile');
    }

    public function isOnline(){
        return Cache::has('active-user' . $this->id);
    }
}
