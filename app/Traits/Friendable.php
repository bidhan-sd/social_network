<?php
namespace SocialNetwork\Traits;
use SocialNetwork\Friendship;
use DB;
trait Friendable{

    public function addFriend($id){

        $friendship = Friendship::create([
            'requester_sender' => $this->id,//who is logged in
            'requester_receiver' => $id,
            'status' => 0,
        ]);
        if($friendship){
            return $friendship;
        }
        return 'Failed';
    }
}