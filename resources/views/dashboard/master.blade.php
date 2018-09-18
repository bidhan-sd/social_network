<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .toDirection{
            position: relative;
        }
        .toDirection::before {
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-bottom: 12px solid #f0f0f0;
            content: "";
            position: absolute;
            left: -5px;
            transform: rotate(230deg);
            bottom: -6px;
        }
        .fromDirection{
            position: relative;
        }
        .fromDirection::before {
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-bottom: 12px solid #0084FF;
            content: "";
            position: absolute;
            right: -5px;
            transform: rotate(125deg);
            bottom: -5px;
        }
        .sidebarMenu {
            padding: 0;
            margin: 0;
            list-style: none;
        }
        .sidebarMenu li {
            border-bottom: 1px solid #ddd;
        }
        .sidebarMenu li a {
            display:block;
             padding:5px;
             text-decoration: none;
             color: #333;
         }
        .cardBodyPaddingRemove{
            padding:0;
        }
        .msgDiv li:hover{
            cursor:pointer;
        }
        .jobDiv li {
             list-style: none;
        }
        .jobDiv{border:1px solid #ddd; margin:10px; width:30%; float:left; padding:10px; color:#000}
        .caption li {list-style:none !important; padding:5px}
        .jobDiv .company_pic{width:50px; height:50px; margin:5px}
        .jobDiv a{text-decoration: none;}
        .jobDetails h4{border:1px solid green; width:60%;
            padding:5px; margin:0 auto; text-align:center; color:green}
        .jobDetails .job_company{padding-bottom:10px; border-bottom:1px solid #ddd; margin-top:20px}
        .jobDetails .job_point{color:green; font-weight:bold}
        .jobDetails .email_link{padding:5px; border:1px solid green; color:green}
        .customClass a i{font-size:25px;}
        .customClass a> span {
            position: absolute;
            top: 0;
            left: 25px;
            background: red;
            border-radius: 5px;
            text-align: center;
            font-size: 11px;
            color: #fff;
            font-weight: bold;
            width: 18px;
            height: 17px;
        }
        .dropdown-toggle::after {
            display: none;
        }
    </style>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container">
            <a class="navbar-brand nav-link" href="{{ url('/') }}">
                Social Network
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    @if (Auth::check())
                        <li class="nav-item px-2"><a class="nav-link" href="{{ route('/findFriends') }}"> Find Friends </a></li>
                        <li class="nav-item px-2">
                            <a class="nav-link" href="{{ route('/friendRequest') }}"> My Request
                                <?php
                                    $count =  SocialNetwork\Friendship::where('status',0)->where('requester_receiver', Auth::user()->id)->count();
                                    if($count){
                                        echo '('.$count.')';
                                    }
                                 ?>
                            </a>
                        </li>
                    @endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                    @else
                    <li class="nav-item px-2 customClass"><a title="friend list" class="nav-link" href="{{ route('/friendsList') }}"> <i class="fa fa-user-friends"></i> </a></li>
                    <li class="nav-item dropdown customClass">
                        <a title="messages" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-envelope"></i> <span>@include('dashboard.profile.unread')</span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="width:400px;left:-360px;" >
                            <a class="dropdown-item" style="display: block;border-bottom: 1px dashed #ddd; margin-bottom: 2px; " href="">
                                <div class="row">
                                    <div class="col-md-2">
                                        <img  style="background:#fff;padding:5px;border:1px solid #eee;" src="" alt="Accepter image" width="50px" class="img-circle"/>
                                    </div>
                                    <div class="col-md-10">
                                        <b style="color:green;"></b> <span style="color:#000;font-size:90%;"></span>
                                        </br>
                                        <span style="color:#90949c"> <i class="fa fa-users" aria-hidden="true"></i></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown customClass">
                        <a title="notification" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bell"></i>
                                <?php
                                    $countNotification = SocialNetwork\Notification::where('requestor', Auth::user()->id)->where('status',1)->count();
                                    if($countNotification != 0) { ?>
                                <span>
                                        <?php echo $countNotification; ?>
                                    </span>
                                    <?php
                                    }
                                ?>
                        </a>
                        <?php
                        $notes = DB::table('users')
                                ->leftJoin('notifications','users.id','notifications.acceptor')
                                ->where('requestor',Auth::user()->id)
                                ->where('status',1) // Unread notice // if not use this condition all notification will show
                                ->orderBy('notifications.created_at','desc')
                                ->get();
                        ?>
                        @if($countNotification != 0)
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="width:400px;left:-360px;" >
                                @foreach($notes as $note)

                                    <a class="dropdown-item" style="display: block;border-bottom: 1px dashed #ddd; margin-bottom: 2px; " href="{{ url('/notifications') }}/{{$note->id}}">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <img  style="background:#fff;padding:5px;border:1px solid #eee;" src="{{ asset('/')}}img/{{$note->pic }}" alt="Accepter image" width="50px" class="img-circle"/>
                                            </div>
                                            <div class="col-md-10">
                                                <b style="color:green;">{{ $note->name }}</b> <span style="color:#000;font-size:90%;">{{ $note->note }}</span>
                                                </br>
                                                <span style="color:#90949c">
                                                    <i class="fa fa-users" aria-hidden="true"></i>
                                                    {{ date('F j,Y',strtotime($note->created_at))}} at
                                                    {{ date('H: i',strtotime($note->created_at))}}
                                                </span>
                                            </div>
                                        </div>
                                    </a>

                                @endforeach
                            </div>
                        @endif
                    </li>
                    <li class="nav-item dropdown">
                        <a  title="profile" id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <img src="{{url('../')}}/public/img/{{Auth::user()->pic}}" alt="boy image" width="30px" height="30px" style="border-radius:100%"/> <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('/profile',['slug' => Auth::user()->slug] ) }}">Profile </a>
                            <a class="dropdown-item" href="{{ route('/editProfile') }}">Edit Profile</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</div>
<!-- Scripts -->
<script src="{{ asset('js/profile.js') }}" defer></script>
</body>
</html>
