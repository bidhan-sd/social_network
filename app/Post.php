<?php

namespace SocialNetwork;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable =['user_id','content','image','status'];

    // Create relation users and posts.
    public function user(){
        return $this->belongsTo(user::class);
    }
    public function likes(){
        //post_id is likes table column name
        //id is posts table column name.
        //Now here post_id is relation with post id
        return $this->hasMany(Like::class,'post_id');
    }
    public function comments(){
        //post_id is likes table column name
        //id is posts table column name.
        //Now here post_id is relation with post id
        return $this->hasMany(Comment::class,'post_id');
    }
}
