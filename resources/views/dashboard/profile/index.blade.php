@extends('dashboard.master')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('/home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('/profile',['slug' => Auth::user()->slug] ) }}">Profile</a></li>
            </ol>
        </nav>
        <div class="row">
            @include('dashboard.include.sidebar')
            @foreach($userData as $udata)
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="card">
                                <div class="card-header">
                                    User Name :{{ ucwords($udata->name) }}
                                </div>
                                <div class="card-body">
                                    <img class="rounded mx-auto d-block" src="{{asset('/')}}img/{{$udata->pic}}"  alt="User Image" width="120px" height="120px">
                                </div>
                                <div class="card-footer">
                                    <h3 align="center">{{ ucwords($udata->name) }}</h3>
                                    <p align="center">{{ $udata->city }} - {{ $udata->country }}</p>
                                    @if( $udata->user_id == Auth::user()->id)
                                        <p align="center"><a href="{{ route('/editProfile') }}" class="btn btn-primary">Edit Profile</a></p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="card bg-light">
                                <div class="card-header">About</div>
                                <div class="card-body">
                                    <p class="card-text">{{ $udata->about }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
