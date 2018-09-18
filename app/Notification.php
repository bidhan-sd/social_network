<?php

namespace SocialNetwork;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['requestor','acceptor','status','note'];
}
