@extends('dashboard.master')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ url('/profile') }}/{{ Auth::user()->slug }}">Profile</a></li>
            <li><a href="{{ url('/editProfile') }}">Edit Profile</a></li>
        </ol>
        <div class="row">
            @include('dashboard.include.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">My Friends List : <b> {{ Auth::user()->name }} </b></div>
                    <hr/>
                    <div class="panel-body">
                        <div class="col-sm-12 col-md-12">

                            @if(session()->has('msg'))
                                <p class="alert alert-success">{{ session()->get('msg') }}</p>
                            @endif
                            @foreach($friends as $uList)

                                <div class="row" style="border-bottom:1px solid #ccc;margin-bottom:15px;">
                                    <div class="col-md-2 pull-left">
                                        <img class="rounded mx-auto d-block" src="{{asset('/')}}/img/{{$uList->pic}}" alt="Friend Image" width="80px" height="80px"/>
                                    </div>
                                    <div class="col-md-7 pull-left">
                                        <h3 style="margin:0px;"><a href="{{ route('/profile',['slue'=>$uList->slug]) }}">{{ ucwords($uList->name) }}</a></h3>
                                        <b>Gender :</b> {{ $uList->gender }}
                                        <p><b>Email :</b> {{ $uList->email }}</p>
                                    </div>
                                    <div class="col-md-3 pull-right">
                                        <p>
                                            <a href="{{ route('/unfriend',['id'=>$uList->id] ) }}" class="btn btn-danger btn-sm">Unfriend</a>
                                        </p>
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
