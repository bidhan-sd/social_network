@extends('dashboard.master')
@section('content')
<div class="container">
    <div class="row">

        <div style="background-color:#fff;min-height: 520px;;" class="col-md-3 pull-left">
            <div class="row" style="padding:10px;border-bottom:1px solid #ddd;" >
                <div class="col-md-4"></div>
                <div class="col-md-6"><h5>Messenger</h5></div>
                <div class="col-md-2">
                    <a href="{{url('/newMessage')}}">
                        <img src="{{Config::get('app.url')}}/bookLara/public/img/compose.png" title="Send New Messages">
                    </a>
                </div>
            </div>
            <div v-for="privateMsg in privateMsgs">
                <li v-if="privateMsg.status == 1" style="list-style:none; margin-top:10px;background-color:#F3F3F3" @click="message(privateMsg.id)">
                    <div class="row">
                        <div class="col-md-3 pull-left">
                            <img :src="'{{Config::get('app.url')}}/bookLara/public/img/' + privateMsg.pic" style="width:50px;border-radius:100%; margin:5px;">
                        </div>
                        <div class="col-md-9 pull-left" style="margin-top:5px;">
                            <b> @{{ privateMsg.name }} </b> <br/>
                            <small>id: @{{privateMsg.id}}</small>
                            <small>Gender: @{{privateMsg.gender}}</small>
                        </div>
                    </div>
                </li>
                <li v-else style="list-style:none; margin-top:10px;background-color:#fff" @click="message(privateMsg.id)">
                    <div class="row">
                        <div class="col-md-3 pull-left">
                            <img :src="'{{Config::get('app.url')}}/bookLara/public/img/' + privateMsg.pic" style="width:50px;border-radius:100%; margin:5px;">
                        </div>
                        <div class="col-md-9 pull-left" style="margin-top:5px;">
                            <b> @{{ privateMsg.name }} </b> <br/>
                            <small>id: @{{privateMsg.id}}</small>
                            <small>Gender: @{{privateMsg.gender}}</small>
                        </div>
                    </div>
                </li>
            </div>
        </div>

        <div class="col-md-6 pull-left">
            <div style="background-color:#fff; min-height:520px; border-left:5px solid #F5F8FA">
                <h5 align="center" style="padding:14px;border-bottom:1px solid #ddd;"> Messages </h5>
                <p class="alert alert-success">@{{msg}}</p>
                <div v-for="singleMsg in singleMsgs">

                    <div class="row" v-if="singleMsg.user_from == <?php echo Auth::user()->id; ?>">
                        <div class="col-md-12" style="margin-top:10px">
                            <img :src="'{{Config::get('app.url')}}/bookLara/public/img/' + singleMsg.pic"
                                 style="width:30px;border-radius:100%; margin-left:5px;float:right">
                            <div class="fromDirection" style="margin-top:-15px;float:right;background-color:#0084ff;padding:5px 15px 5px 15px ; margin-right:10px;color:#333;border-radius:10px;color:#fff">
                                @{{ singleMsg.msg }}
                            </div>
                        </div>
                    </div>

                    <div class="row" v-else>
                        <div class="col-md-12 pull-right" style="margin-top:10px">
                            <img :src="'{{Config::get('app.url')}}/bookLara/public/img/' + singleMsg.pic"
                                 style="width:30px;border-radius:100%; margin-left:5px; float:left">
                            <div class="toDirection" style="margin-top:-15px;float:left;background-color:#F0F0F0;padding:5px 15px 5px 15px;border-radius:10px;text-align:right; margin-left:5px;">
                                @{{ singleMsg.msg }}
                            </div>
                        </div>
                    </div>
                </div>
                    <input type="hidden" v-model="conID"/>
                    <textarea v-model="msgFrom" @keydown="inputHandler" style="border: none;margin-top:15px;resize: none;" class="form-control"></textarea>
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