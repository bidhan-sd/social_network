<?php

namespace SocialNetwork\Http\Controllers;
use SocialNetwork\Friendship;
use SocialNetwork\Notification;
use Auth;
use DB;
use SocialNetwork\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index($slug){
        $userData = DB::table('users')
            ->leftjoin('profiles','profiles.user_id','users.id')
            ->where('slug',$slug)
            ->get();
        return view('dashboard.profile.index',compact('userData'));
    }
    public function editProfileForm(){
        return view('dashboard.profile.profile-edit')->with('data', Auth::user()->profile);
    }
    public function changeProfilePhoto(){
        return view('dashboard.profile.profile-picture');
    }
    public function uploadProfilePhoto(Request $request){
        $this->validate($request,[
            'pic' => 'required'
        ]);
        //dd($request->all());
        $file = $request->file('pic');
        $filename = $file->getClientOriginalName();
        $path = 'img/';
        $file->move($path, $filename);
        $user_id = Auth::user()->id;
        DB::table('users')->where('id',$user_id)->update(['pic' => $filename]);
        return back();
    }
    public function uploadProfileInfo(Request $request){
        //dd($request->all());
        $user_id = Auth::user()->id;
        DB::table('profiles')->where('user_id', $user_id)->update($request->except('_token'));
        return back();
    }

    public function findFriends(){

        $userId = Auth::user()->id;
        /*$first = DB::table('friendships')->where('requester_sender',$userId);
        $second = DB::table('friendships')->where('requester_receiver',$userId)->union($first)->get();

        $friendships = DB::table('friendships')
            ->where('requester_sender', $userId)
            ->orWhere('requester_receiver', $userId)
            ->distinct()
            ->get();
        $array = json_decode(json_encode($friendships), true);
        return $array;

        $users = DB::table('users')
            ->whereNull('last_name')
            ->union($first)
            ->get();

        $frnd = User::join('friendships','friendships.requester_sender','users.id')
                    ->whereNotIn('users.id',['friendships.requester_sender',
                                            'friendships.requester_receiver',
                                            Auth::user()->id])

                    ->selectRaw('DISTINCT users.id as user_id')
                    ->get();*/



        /*
        $friendships = DB::table('friendships')
            ->where('requester_sender', $uid)
            ->orWhere('requester_receiver', $uid)
            ->get();
        $array = json_decode(json_encode($friendships), true);
        $i = 0;
        foreach($array as $arr){
            $data[$i]  = $arr['requester_sender'];
            $i++;
        }*/

       $allUsers = DB::table('profiles')
            ->leftJoin('users', 'users.id', '=', 'profiles.user_id')
            ->where('users.id', '!=', $userId)
            ->get();
       return view('dashboard.profile.profile-findFriends',compact('allUsers'));
    }
    
    public function sendFriendRequest($id) {
        Auth::user()->addFriend($id);
        return back();
    }

    public function friendRequests() {
        $uid = Auth::user()->id;
        $friendRequests = DB::table('friendships')
            ->rightJoin('users','users.id','=','friendships.requester_sender')
            ->where('status', 0)//If status 0 than have request else 1 for acccept.
            ->where('friendships.requester_receiver','=',$uid)->get();
        //return $FriendRequests;
        return view('dashboard.profile.profile-friend-request', compact('friendRequests'));
    }
    public function friendRequestAccept($name, $id) {
        $uid = Auth::user()->id;
        $checkRequest = Friendship::where('requester_sender',$id)
            ->where('requester_receiver',$uid)
            ->first();
        if($checkRequest){
            $updateFriendship = DB::table('friendships')
                ->where('requester_receiver', $uid)
                ->where('requester_sender', $id)
                ->update(['status' => 1]);

            $notifications = new Notification();
            $notifications->requestor = $id; //who is requestor.
            $notifications->acceptor = $uid; //Who is acceptor
            $notifications->status = '1'; //Unread notifications
            $notifications->note = 'accepted your friend request'; //Unread notifications
            $notifications->save();

            if($notifications) {
                return back()->with('msg', "You are now Friends with ". $name);
            }
        }else{
            return back()->with('msg','Friend request not available here');
        }
    }

    public function friendRequestRemove($id){
        DB::table('friendships')
            ->where('requester_receiver',Auth::user()->id)
            ->where('requester_sender',$id)
            ->delete();
        return back()->with('msg','Request has been deleted.');
    }
    public function myFriendList(){
        $uid =  Auth::user()->id;
        $friends1 = DB::table('friendships')
            ->leftJoin('users','users.id', 'friendships.requester_receiver') // Who is not logedin but sent request to.
            ->where('status',1)
            ->where('requester_sender', $uid)
            ->get();      //Who send me request.

        $friends2 = DB::table('friendships')
            ->leftJoin('users','users.id', 'friendships.requester_sender') // Who is not logedin but sent request to.
            ->where('status',1)
            ->where('requester_receiver', $uid)
            ->get();       // I sent request to which user.

        $friends = array_merge($friends1->toArray(),$friends2->toArray());
        return view('dashboard.profile.profile-friend-list', compact('friends'));
    }
    public function unFriend($id){
        $loggedUser = Auth::user()->id;
        DB::table('friendships')
            ->whereIn('requester_sender', [$loggedUser, $id])
            ->whereIn('requester_receiver', [$loggedUser, $id])
            ->where('status',1)
            ->delete();
        return back()->with('msg','You are not friend with this person');

    }
    public function notifications($id){
        $notes = DB::table('notifications')
            ->leftJoin('users','users.id','notifications.acceptor')
            ->where('notifications.id',$id)
            ->where('notifications.requestor',Auth::user()->id)
            ->where('notifications.status',1) // Unread notice
            ->orderBy('notifications.created_at','desc')
            ->get();

        $updateNotification = DB::table('notifications')
            ->where('notifications.id', $id)
            ->update(['status' => 0]);

        return view('dashboard.profile.profile-notification', compact('notes'));
    }

    public function sendMessage(Request $request){
        $conID = $request->conID;
        $msg = $request->msg;
        $checkUserId = DB::table('messages')->where('conversation_id', $conID)->get();
        if($checkUserId[0]->user_from== Auth::user()->id){
            // fetch user_to
            $fetch_userTo = DB::table('messages')->where('conversation_id', $conID)
                ->get();
            $userTo = $fetch_userTo[0]->user_to;
        }else{
            // fetch user_to
            $fetch_userTo = DB::table('messages')->where('conversation_id', $conID)
                ->get();
            $userTo = $fetch_userTo[0]->user_to;
        }
        // now send message
        $sendM = DB::table('messages')->insert([
            'user_to' => $userTo,
            'user_from' => Auth::user()->id,
            'msg' => $msg,
            'status' => 1,
            'conversation_id' => $conID
        ]);
        if($sendM){
            $userMsg = DB::table('messages')
                ->join('users', 'users.id','messages.user_from')
                ->where('messages.conversation_id', $conID)->get();
            return $userMsg;
        }
    }

    public function newMessage(){

        $uid =  Auth::user()->id;
        $friends1 = DB::table('friendships')
            ->leftJoin('users','users.id', 'friendships.requester_receiver') // Who is not logedin but sent request to.
            ->where('status',1)
            ->where('requester_sender', $uid)
            ->get();      //Who send me request.

        $friends2 = DB::table('friendships')
            ->leftJoin('users','users.id', 'friendships.requester_sender') // Who is not logedin but sent request to.
            ->where('status',1)
            ->where('requester_receiver', $uid)
            ->get();       // I sent request to which user.

        $friends = array_merge($friends1->toArray(),$friends2->toArray());
        return view('dashboard.profile.profile-newMessage', compact('friends'));
    }

    public function sendNewMessage(Request $request){
        $msg = $request->msg;
        $friend_id = $request->friend_id;
        $myID = Auth::user()->id;

        //check if conversation already started or not
        $checkCon1 = DB::table('conversations')->where('user_one',$myID)
            ->where('user_two',$friend_id)->get(); // if loggedin user started conversation

        $checkCon2 = DB::table('conversations')->where('user_two',$myID)
            ->where('user_one',$friend_id)->get(); // if loggedin recviced message first
        $allCons = array_merge($checkCon1->toArray(),$checkCon2->toArray());
        //return count($allCons);

        if(count($allCons)!=0){
            //!=0 means 1 If return 1 conversation id have to conversation table.
            // old conversation
            $conID_old = $allCons[0]->id;
            //insert data into messages table
            $MsgSent = DB::table('messages')->insert([
                'user_from' => $myID,
                'user_to' => $friend_id,
                'msg' => $msg,
                'conversation_id' => $conID_old,
                'status' => 1
            ]);
        }else {
            // new conversation
            $conID_new = DB::table('conversations')->insertGetId([
                'user_one' => $myID,
                'user_two' => $friend_id
            ]);
            echo $conID_new;
            $MsgSent = DB::table('messages')->insert([
                'user_from' => $myID,
                'user_to' => $friend_id,
                'msg' => $msg,
                'conversation_id' =>  $conID_new,
                'status' => 1
            ]);
        }
    }

    public function jobs(){
        $jobs = DB::table('users')
            ->Join('jobs','users.id','jobs.company_id')
            ->get();
        return view('dashboard.profile.jobs', compact('jobs'));
    }
    public function job($id){
        $jobs = DB::table('users')
            ->leftJoin('jobs','users.id','jobs.company_id')
            ->where('jobs.id',$id)
            ->get();
        return view('dashboard.profile.job', compact('jobs'));
    }
}
