@extends('dashboard.master')
@section('content')
    <div class="container">
        <div class="row">

            <div style="background-color:#fff;min-height: 520px;;" class="col-md-3 pull-left">
                <div class="row" style="padding:10px;border-bottom:1px solid #ddd;" >
                    <div class="col-md-7">Friend List</div>
                    <div class="col-md-5 pull-right">
                        <a href="{{url('/messages')}}" class="btn btn-sm btn-info">All messages</a>
                    </div>
                </div>
                @foreach($friends as $friend)
                    <li style="list-style:none;margin-top:10px; background-color:#F3F3F3" @click="friendID({{$friend->id}})" v-on:click="seen = true"  class="row">
                        <div class="col-md-3 pull-left">
                            <img src="{{Config::get('app.url')}}/bookLara/public/img/{{$friend->pic}}"
                                 style="width:50px; border-radius:100%; margin:5px">
                        </div>
                        <div class="col-md-9 pull-left" style="margin-top:5px">
                            <b> {{$friend->name}}</b><br>
                            <small>Gender: {{$friend->gender}}</small>
                        </div>
                    </li>
                @endforeach
            </div>

            <div class="col-md-6 pull-left">
                <div style="background-color:#fff; min-height:520px; border-left:5px solid #F5F8FA">
                    <h5 align="center" style="padding:14px;border-bottom:1px solid #ddd;"> Messages </h5>
                    <p class="alert alert-success">@{{msg}}</p>
                    <div v-if="seen">
                        <input type="text" v-model="friend_id">
                        <textarea class="col-md-12 form-control" v-model="newMsgFrom"></textarea><br>
                        <input type="button" value="send message" @click="sendNewMsg()">
                    </div>
                </div>
            </div>

            <div class="col-md-3 pull-right">
                <div style="background-color:#fff; min-height:520px;border-left:5px solid #F5F8FA">
                    <h5 align="center" style="padding:14px;border-bottom:1px solid #ddd;"> User Information </h5>
                </div>
            </div>

        </div>
    </div>
@endsection