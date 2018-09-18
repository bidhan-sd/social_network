<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('try',function(){
    /*$uid = Auth::user()->id;
    $friendships = DB::table('friendships')
        ->where('requester_sender', $uid)
        ->orWhere('requester_receiver', $uid)
        ->get();*/
    $frnd = User::join('friendships','friendships.requester_sender','users.id')
                ->where('users.id','!=','friendships.requester_sender')
                ->where('users.id','!=','friendships.requester_receiver')
                ->get();
    dd($frnd);
    //return $friendships;
});

Route::get('/getMessages', function(){
    $allUsers1 = DB::table('users')
        ->join('conversations','users.id','conversations.user_one')
        ->where('conversations.user_two', Auth::user()->id)
        ->get();

    $allUsers2 = DB::table('users')
        ->join('conversations','users.id','conversations.user_two')
        ->where('conversations.user_one', Auth::user()->id)
        ->get();

    return array_merge($allUsers1->toArray(), $allUsers2->toArray());
});

Route::get('/getMessages/{id}', function($id){
    // if click conversation user id then update

    $update_status = DB::table('conversations')->where('id',$id)
        ->update([
            'status' => 0  // now read by user
        ]);

    $userMsg = DB::table('messages')
        ->leftjoin('users','users.id','messages.user_from')
        ->where('messages.conversation_id', $id)
        ->get();
    return $userMsg;
});

Route::get('/', function(){
    /*$posts = DB::table('users')
        ->leftJoin('profiles','profiles.user_id','users.id')
        ->leftJoin('posts','posts.user_id','users.id')
        ->orderBy('posts.created_at','desc')
        ->take(3)
        ->get();
    return view('welcome',compact('posts'));*/
    $posts = SocialNetwork\Post::with('user','likes','comments')->orderBy('created_at','DESC')->get();
    return view('welcome',compact('posts'));
});


Route::get('/posts', function(){
    /*$posts_jsons = DB::table('users')
        ->leftJoin('profiles','profiles.user_id','users.id')
        ->leftJoin('posts','posts.user_id','users.id')
        ->orderBy('posts.created_at','desc')
        ->take(20)
        ->get();
    return $posts_jsons;*/
    //user hoche Post model ar akta method same likes ar jonno
    //App\Post::with('user','likes')->get();
    return SocialNetwork\Post::with('user','likes','comments')->orderBy('created_at','DESC')->get();
});
Route::post('addPost', 'PostController@addPost');

Route::get('posts/{id}',function($id){
     $pData = SocialNetwork\Post::where('id',$id)->get();
    echo $pData[0]->content;
});
Route::post('updatePost/{id}','PostController@updatePost');

Route::get('newMessage','ProfileController@newMessage');
Route::post('sendNewMessage', 'ProfileController@sendNewMessage');
Route::post('sendMessage', 'ProfileController@sendMessage');

Route::get('/likes',function(){
    return SocialNetwork\Like::all();
});
Route::get('/',function(){
    $likes =  SocialNetwork\Like::all();
    return view('welcome',compact('likes'));
});
Route::post('search','PostController@search');
Auth::routes();

Route::group(['middleware' => 'auth'], function(){
    //Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/home',[
        'uses' => 'HomeController@index',
        'as'   => '/home'
    ]);
    Route::get('/profile-view/{slug}',[
        'uses' => 'ProfileController@index',
        'as'   => '/profile'
    ]);

    Route::get('/profile-edit',[
        'uses' => 'ProfileController@editProfileForm',
        'as'   => '/editProfile'
    ]);
    Route::get('/profile-picture-change',[
        'uses' => 'ProfileController@changeProfilePhoto',
        'as'   => '/changePhoto'
    ]);
    Route::post('/profile-picture-update',[
        'uses' => 'ProfileController@uploadProfilePhoto',
        'as'   => '/upload-photo'
    ]);
    Route::post('/profile-info-update',[
        'uses' => 'ProfileController@uploadProfileInfo',
        'as'   => '/updateProfile'
    ]);

    Route::get('/find-friends',[
        'uses' => 'ProfileController@findFriends',
        'as'   => '/findFriends'
    ]);
    Route::get('/add-friends/{id}',[
        'uses' => 'ProfileController@sendFriendRequest',
        'as'   => '/addFriend'
    ]);
    Route::get('/friend-requests',[
        'uses' => 'ProfileController@friendRequests',
        'as'   => '/friendRequest'
    ]);
    Route::get('/request-accept/{name}/{id}',[
        'uses' => 'ProfileController@friendRequestAccept',
        'as'   => '/requestAccept'
    ]);
    Route::get('/request-remove/{id}',[
        'uses' => 'ProfileController@friendRequestRemove',
        'as'   => '/requestRemove'
    ]);
    Route::get('/friend-list',[
        'uses' => 'ProfileController@myFriendList',
        'as'   => '/friendsList'
    ]);
    Route::get('/unfriend/{id}',[
        'uses' => 'ProfileController@unFriend',
        'as'   => '/unfriend'
    ]);
    Route::get('/notifications/{id}','ProfileController@notifications');
    Route::get('/messages', function(){
        return view('message');
    });
    //jobs for users
    Route::get('jobs', 'ProfileController@jobs');
    Route::get('job/{id}','ProfileController@job');

    //Delete Post
    Route::get('/deletePost/{id}','PostController@deletePost');

    //Like post
    Route::get('/likePost/{id}','PostController@likePost');

    //Add Comment
    Route::post('addComment','PostController@addComment');

    //Save Image
    Route::post('saveImg','PostController@saveImg');

});

Route::group(['prefix'=>'company','middleware' =>['auth','Company']], function(){
    Route::get('/','CompanyController@index');
    Route::get('/addJob', function(){
        return view('dashboard.company.addJob');
    });
    Route::post('addJobSubmit', 'companyController@addJobSubmit');
    Route::get('/jobs','companyController@viewJobs');
});

Route::group(['prefix'=>'admin','middleware' =>['auth','Admin']], function(){
    Route::get('/','AdminController@index');
});











