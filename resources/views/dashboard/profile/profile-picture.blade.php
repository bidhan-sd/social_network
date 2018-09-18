@extends('dashboard.master')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('/home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('/profile',['slug' => Auth::user()->slug] ) }}">Profile</a></li>
            <li class="breadcrumb-item"><a href="{{ route('/editProfile') }}">Edit Profile</a></li>
            <li class="breadcrumb-item"><a href="{{ route('/changePhoto') }}">Change Picture</a></li>
        </ol>
        <div class="row">
            @include('dashboard.include.sidebar')
            <div class="col-md-5 col-md-offset-2">

                <div class="card">
                    <div class="card-header">User Name :<b> {{ ucwords(Auth::user()->name) }} </b></div>
                    <div class="card-body">
                        <img class="rounded mx-auto d-block" src="{{asset('/')}}img/{{Auth::user()->pic}}"  alt="User Image" width="100px" height="100px">
                    </div>
                    <div class="card-footer">
                        {{ Form::open(['route'=>'/upload-photo','method'=>'POST','enctype'=>'multipart/form-data']) }}
                        <div class="col-xs-4">
                            <input class="form-control" type="file" name="pic" class="input-md"/>
                        </div>
                        <br/>
                        <input type="submit" class="btn-success" name="btn" value="Change image"/>
                        {{ Form::close() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
