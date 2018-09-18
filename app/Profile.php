<?php

namespace SocialNetwork;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['user_id','city','country','about'];

    public function user(){
        return $this->belongsTo('SocialNetwork\User');
    }
}
