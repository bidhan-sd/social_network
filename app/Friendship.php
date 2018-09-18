<?php

namespace SocialNetwork;

use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{
    protected $fillable = ['requester_sender','requester_receiver','status'];
}
