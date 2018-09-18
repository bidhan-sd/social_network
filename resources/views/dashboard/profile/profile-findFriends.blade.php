@extends('dashboard.master')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('/home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('/findFriends') }}">Find Friends</a></li>
            </ol>
        </nav>
        <div class="row">
            @include('dashboard.include.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading"><b> {{ Auth::user()->name }} </b> If you want, You Will Connect With them </div>

                    <div class="panel-body">
                        <div class="col-sm-12 col-md-12">
                            @foreach($allUsers as $uList)

                                <div class="row" style="border-bottom:1px solid #ccc;margin-bottom:15px;">
                                    <div class="col-md-2 pull-left">
                                        <img class="rounded mx-auto d-block" src="{{asset('/')}}img/{{$uList->pic}}" alt="boy image" width="80px" height="80px" class="img-rounded"/>
                                    </div>
                                    <div class="col-md-7 pull-left">
                                        <h3 style="margin:0px;"><a href="{{ route('/profile',['slue'=>$uList->slug]) }}">{{ ucwords($uList->name) }}</a></h3>
                                        <i class="fa fa-globe"></i> {{ $uList->city }} - {{ $uList->country }}
                                        <p>{{ $uList->about }}</p>
                                    </div>
                                    <div class="col-md-3 pull-right">
                                        <?php
                                        $check = DB::table('friendships')
                                                ->where('requester_receiver','=', $uList->id)
                                                ->where('requester_sender','=', Auth::user()->id)
                                                ->first();
                                        if($check == ''){
                                        ?>
                                        
                                        <p><a href="{{ route('/addFriend',['slug' => $uList->id] ) }}" class="btn btn-info btn-sm">Add to Friend</a></p>
                                        <?php } else { ?>
                                        <p><a href="" disable class="btn btn-info btn-sm">Friend request Sent</a></p>
                                        <?php } ?>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
