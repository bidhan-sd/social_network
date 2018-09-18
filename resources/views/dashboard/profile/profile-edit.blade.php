@extends('dashboard.master')
@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('/home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('/profile',['slug' => Auth::user()->slug] ) }}">Profile</a></li>
                <li class="breadcrumb-item"><a href="{{ route('/editProfile') }}">Edit Profile</a></li>
            </ol>
        </nav>
        <div class="row">
            @include('dashboard.include.sidebar')

            <div class="col-md-9">
                <div class="col-sm-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <img class="rounded mx-auto d-block" src="{{asset('/')}}img/{{Auth::user()->pic}}"  alt="User Image" width="120px" height="120px">
                        </div>
                        <div class="card-footer">
                            <p align="center">Username : <b> {{ Auth::user()->name }}</b></p>
                            <p align="center">{{ $data->city }} - {{ $data->country }}</p>
                            <p align="center"><a href="{{ route('/changePhoto') }}" class="btn btn-primary">Change Photo</a></p>
                        </div>
                    </div>
                </div>
                <div style="margin-bottom:20px"></div>
                <div class="col-sm-12 col-md-12">
                    <h3><span class="label label-primary">Update Profile</span></h3>

                    {{ Form::open(['route'=>'/updateProfile','method'=>'POST']) }}
                    <div class="row">
                        <div class="col-md-6">
                            <div style="margin-bottom: 15px">
                                <label>City Name</label>
                                <input type="text" class="form-control" placeholder="City Name" name="city" value="{{ $data->city }}">
                            </div>
                            <div style="margin-bottom: 15px">
                                <label>Country Name</label>
                                <input type="text" class="form-control" placeholder="Country Name" name="country" value="{{ $data->country }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div style="margin-bottom: 15px">
                                <label>About</label>
                                <textarea name="about" class="form-control">{{ $data->about }}</textarea>
                            </div>
                            <div style="margin-bottom: 15px" class="input-group">
                                <input type="submit" class="btn btn-success pull-right">
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}

                </div>

            </div>
        </div>
    </div>
@endsection