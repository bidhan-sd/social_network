@extends('dashboard.master')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('/home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="">Notification</a></li>
        </ol>
        <div class="row">
            @include('dashboard.include.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ Auth::user()->name }}, Your Notification</div>

                    <div class="panel-body">
                        <div class="col-sm-12 col-md-12">

                            @if(session()->has('msg'))
                                <p class="alert alert-success">{{ session()->get('msg') }}</p>
                            @endif
                            @foreach($notes as $note)
                                <div class="row" style="border-bottom:1px solid #ccc;margin-bottom:15px;">
                                    <ul>
                                        <li>
                                            <p>
                                                <a style="font-weight: bold; color:green;" href="{{ url('/profile-view') }}/{{ $note->slug }}"> {{ $note->name }} </a>
                                                {{ $note->note }}</p>
                                        </li>
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
