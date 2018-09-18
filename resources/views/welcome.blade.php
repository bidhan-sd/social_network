<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>LaraBook</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/js/') }}/moment.js"></script>
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>--}}
    <style>
        html, body {
            background-color: #ddd;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            margin: 0;
        }
        .top_bar{
            position:relative; width:99%; top:0; padding:5px; margin:0 5
        }
        .full-height {
            margin-top:50px
        }
        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }
        .position-ref {
            position: relative;
        }
        .top-right {
            position: absolute;
            right:5px; top:15px
        }
        .top-left {
            position: absolute;
            width:40%

        }
        .content {
            text-align: center;
        }
        .title {
            font-size: 84px;
        }
        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }
        .m-b-md {
            margin-bottom: 30px 0;
        }
        .head_har{
            background-color: #f6f7f9;
            border-bottom: 1px solid #dddfe2;
            border-radius: 2px 2px 0 0;
            font-weight: bold;
            padding: 8px 6px;

        }
        .left-sidebar, .right-sidebar{
            background-color:#fff;
            height:600px;

        }
        .posts_div{margin-bottom:10px;}
        .posts_div h3{
            margin-top:4px !important;

        }
        #postText{
            border:none;
            height:120px
        }
        .sideBarMenu{
            padding:0;
            margin:0;
            list-style: none;
        }
        .sideBarMenu li a{
            display:block;
            border-bottom:1px solid #ddd;
            padding:5px;
            text-decoration: none;
        }
        .postStyle {
            box-shadow: 0 3px 0px #999;
            border-radius: 5px;
            padding: 11px;
            margin-bottom: 10px;
        }
        .user_name{
            font-size:18px;
            font-weight:bold;
            text-transform:capitalize;
            margin:3px
        }
        .likeBtn{
            color: #4b4f56; font-weight:bold; cursor: pointer;
        }
        #commentBox{
            background-color:#ddd;
            padding:10px;
            width:99%; margin:0 auto;
            background-color:#F6F7F9;
            padding:10px;
            margin-bottom:10px
        }
        #commentBox li { list-style:none; padding:10px; border-bottom:1px solid #ddd}
        .commet_form{ padding:10px; margin-bottom:10px}
        .commentHand{color:blue}
        .commentHand:hover{cursor:pointer}
        .upload_wrap{
            position:relative;
            display:inline-block;
            width:100%
        }
        .commentHand{color:blue}
        .commentHand:hover{cursor:pointer}
        .upload-wrap{
            position:relative;;
            display:inline-block;
            width:100%;
        }
        .ImageRemoveIcon{
            position: relative;
        }
        .ImageRemoveIcon img {
            width: 100px;
            border-radius: 10px;
            background: #ddd;
            padding: 10px;
        }
        .ImageRemoveIcon b{
            top: -5px;
            left: -2px;
            position: absolute;
            cursor: pointer;
            color: #333;
            font-weight: bold;
            transform: rotate(-35deg);
        }
        .booklara-top-left {
            margin-bottom: 20px;
            margin-top: 20px;
            position:fixed;
            left:0;
            width:65%;
            padding-left:10px;
        }
        .booklara-top-right {
            margin-top: 20px;
            margin-bottom: 15px;
            text-align: right;
            padding: 7px 17px;
            position: fixed;
            right: 0;
        }
        .panel-footer {
            position: absolute;
            z-index: 999999999999;
            background: #ccc;
            padding: 10px;
            font-weight: bold;
            width: 100%;
        }
    </style>

</head>
<body>



    @if(Auth::check())
    <div class="container">
        <div class="row" id="app">
            <div class="col-md-6">
                <div class="booklara-top-left">
                    <input type="text" placeholder="What are you looking for?" v-model="qry" v-on:Keyup="autoComplete" class="form-control"/>
                    <div style="backckground:white;color:#333;" class="panel-footer" v-if="results.length">
                        <p v-for="result in results">
                            <a href="{{ url('/profile-view') }}/{{ Auth::user()->slug }}">@{{ result.name }}</a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="booklara-top-right">
                    @if (Auth::check())
                        <a href="{{url('jobs')}}" style="text-decoration:none;background-color:#283E4A; color:#fff; padding:5px 15px 5px 15px; border-radius:5px; margin:8px">Find Job</a>
                        <a style="text-decoration:none;background-color:#283E4A; color:#fff; padding:5px 15px 5px 15px; border-radius:5px; margin:8px" href="{{ url('/home') }}">Dashboard
                            (<span style="text-transform:capitalize; color:white ; font-weight:bold">{{ucwords(Auth::user()->name)}}</span>)
                        </a>

                        <a style="text-decoration:none;background-color:#283E4A; color:#fff; padding:5px 15px 5px 15px; border-radius:5px; margin:8px" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>

                    @else
                        <a href="{{ url('/login') }}">Login</a>
                        <a href="{{ url('/register') }}">Register</a>
                    @endif
                </div>
            </div>
            <!-- left side start -->
            <div style="position:fixed;left:10px;top:80px" class="col-md-3 left-sidebar">
                <h3 align="center" style="padding:10px 10px 0;margin:0;font-weight:bold;font-size:20px;"> Menu </h3>
                <hr/>
                <ul class="sideBarMenu">
                    <li>
                        <a href="{{ url('/profile-view') }}/{{Auth::user()->slug}}">
                            <img src="{{Config::get('app.url')}}/bookLara/public/img/{{Auth::user()->pic}}" width="32" style="margin:5px"  />{{Auth::user()->name}}
                        </a>
                    </li>
                    <li>
                        <a href="{{url('/')}}"> <img src="{{Config::get('app.url')}}/bookLara/public/img/news_feed.png" width="32" style="margin:5px"/>News Feed</a>
                    </li>
                    <li>
                        <a href="{{url('/friendsList')}}">
                            <img src="{{Config::get('app.url')}}/bookLara/public/img/friends.png"width="32" style="margin:5px"/>Friends
                        </a>
                    </li>
                    <li>
                        <a href="{{url('/messages')}}">
                            <img src="{{Config::get('app.url')}}/bookLara/public/img/msg.png" width="32" style="margin:5px"  />Messages
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('/findFriends') }}">
                            <img src="{{Config::get('app.url')}}/bookLara/public/img/friends.png" width="32" style="margin:5px"/>Find Friends
                        </a>
                    </li>

                    <li>
                        <a href="{{url('/jobs')}}">
                            <img src="{{Config::get('app.url')}}/bookLara/public/img/jobs.png" width="32" style="margin:5px"/>Find Jobs
                        </a>
                    </li>
                </ul>
            </div>
            <!-- left side end -->

            <!-- center content start -->
            <div style="position:absolute;max-height:550px;top:80px;left:calc(25%);overflow-y: scroll;"class="col-md-6 center-con">
                    <div class="posts_div">
                        <div class="head_har">
                            @{{msg}}
                        </div>
                        <div style="background-color:#fff;">
                            <div class="row">
                                <div class="col-md-1 pull-left">
                                    <img src="{{ url('../')}}/public/img/{{Auth::user()->pic}}" style="width:50px; margin:5px;  border-radius:100%">
                                </div>
                                <div class="col-md-11 pull-right">
                                    <div>
                                        <div v-if="!image">
                                            <form method="post" enctype="multipart/form-data" v-on:submit.prevent="addPost">
                                                <textarea v-model="content" id="postText" class="form-control" placeholder="what's on your mind ?"></textarea>
                                                <button type="submit" class="btn btn-sm btn-info pull-right" style="margin:10px; padding:10px;" id="postBtn">Post</button>
                                            </form>
                                        </div>
                                        <div v-if="!image" style="position:relative;display:inline-block;">
                                            <div style="border:1px solid #ddd; border-radius: 10px;background-color:#efefef;padding:3px 15px 3px 10px;margin-bottom:10px;">
                                                <i class="fa fa-file-image-o"></i><b> photo</b>
                                                <input type="file" @change="onFileChange" style="position:absolute;left:0;top:0;opacity:0;cursor:pointer;"/>
                                            </div>
                                        </div>
                                        <div v-else>
                                            <div class="upload-wrap">
                                                <textarea class="form-control" v-model="content" id="postText" class="form-control" placeholder="what's on your mind ?"></textarea>
                                                <div class="ImageRemoveIcon">
                                                    <img :src="image"/>
                                                    <b @click="removeImg"> X </b>
                                                </div>
                                            </div>
                                            <div>
                                            <button @click="uploadImg" class="btn btn-sm btn-success">Upload</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="posts_div">
                    <div v-for="post,key in posts" >
                        <div class="col-md-12 postStyle" style="background-color:#fff ">
                            <div class="row">
                                <div class="col-md-1 pull-left">
                                    <img :src="'{{Config::get('app.url')}}/bookLara/public/img/' + post.user.pic" style="width:50px; border-radius:100%">
                                </div>
                                <div class="col-md-9">
                                    <p style="margin-left:15px;">
                                        <a :href="'{{url('profile-view')}}/' +  post.slug" class="user_name"> @{{post.user.name}}</a> <br>
                                            <span style="color:#AAADB3">  @{{ post.created_at | myOwnTime}}
                                                <i class="fa fa-globe"></i></span>
                                    </p>
                                </div>
                                <div v-if="post.user_id == '{{ Auth::user()->id }}'" class="col-md-2" style="text-align: right">
                                    <a href="#" data-toggle="dropdown" aria-haspopup="true">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <li><a class="nav-link" data-toggle="modal" :data-target="'#myModal' + post.id" @click="openModal(post.id)">Edit</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li>
                                            <a class="nav-link" @click="deletePost(post.id)"><i class="fa fa-trash"></i> Delete</a>
                                        </li>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" :id="'myModal'+ post.id" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Edit Post</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <textarea v-model="updatedContent" class="form-control">@{{ post.content }}</textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-success" data-dismiss="modal" @click="updatePost(post.id)">Save Changes</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- Modal -->
                            <p  style="color:#333;text-align: justify">
                                @{{post.content}}
                                <br/>
                                <img v-if="post.image" :src="'<?php echo Config::get('app.url');?>/bookLara/public/img/' + post.image" width="200"/>
                            </p>
                            <div class="row">
                                <div class="col-md-4">
                                    @if(Auth::check())
                                        <p v-if="post.likes.length>0">
                                            liked by <b style="color:green"> @{{post.likes.length}} </b> persons
                                        </p>
                                        <p v-else>
                                            <i class="fa fa-thumbs-up likeBtn" @click="likePost(post.id)"> Like</i>
                                        </p>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <p class="commentHand" @click="commentBoxSeen =! commentBoxSeen">Comments <b> ( @{{ post.comments.length }} ) </b> </p>
                                </div>
                                <div class="col-md-4">

                                </div>

                            </div>


                            <div id="commentBox" v-if="commentBoxSeen">
                                <div class="comment_form">
                                    <textarea class="form-control" v-model="commentData[key]"></textarea><br/>
                                    <!-- Here addComment(post,key) aikhane hole post ta send kora hoche-->
                                    <button class="btn btn-success" @click="addComment(post,key)">Send</button>
                                </div>
                                <ul v-for="comment in post.comments">
                                    <li v-if="comment.user_id == {{ Auth::user()->id }}">
                                        <a :href="'{{ url('/profile-view') }}/' + post.user.slug">You</a>  @{{ comment.comment }}
                                    </li>
                                    <li v-else>
                                        <a :href="'{{ url('/profile-view') }}/' + post.user.slug">@{{ post.user.name }}</a>
                                        @{{ comment.comment }}
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- center content end -->

            <!-- right side start -->
            <div style="position:fixed;right:10px;top:80px" class="col-md-3 right-sidebar">
                <h3 align="center" style="padding:10px 10px 0;margin:0;font-weight:bold;font-size:20px;">Active Online User</h3>
                <hr/>
                @if(Auth::check())
                    @foreach(SocialNetwork\user::all() as $user)
                        @if($user->isOnline())
                            <p>{{ $user->name }}</p>
                        @endif
                    @endforeach
                @endif

            </div>
            <!-- right side end -->

        </div>
    </div>
    @else
        <h1>Please Login</h1>
    @endif



<script type="text/javascript" src="{{ asset('/') }}js/app.js"></script>
<script>
    $(document).ready(function(){

        $('#postBtn').hide();

        $("#postText").mouseover(function() {
            $('#postBtn').show();
        });
        /*$("#postText").mouseleave(function() {
         $('#postBtn').hide();
         });*/

    });
</script>
</body>
</html>
