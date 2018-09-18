<div class="col-md-3">
    <div class="card">
        <div class="card-header">Sidebar - Quick Links</div>

        <div class="card-body cardBodyPaddingRemove">
            <div class="list-group">
                @if(Auth::check())
                    <ul class="sidebarMenu">
                        <li>
                            <a href="{{ url('/profile-view') }}/{{Auth::user()->slug}}">
                                <img src="{{Config::get('app.url')}}/bookLara/public/img/{{Auth::user()->pic}}" width="32" style="margin:5px"  />
                                {{Auth::user()->name}}
                            </a>
                        </li>
                        <li>
                            <a href="{{url('/')}}">
                                <img src="{{Config::get('app.url')}}/bookLara/public/img/news_feed.png" width="32" style="margin:5px"/>
                                News Feed
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('/friendsList') }}"> <img src="{{Config::get('app.url')}}/bookLara/public/img/friends.png"width="32" style="margin:5px"/>
                                Friends
                            </a>
                        </li>
                        <li>
                            <a href="{{url('/messages')}}"> <img src="{{Config::get('app.url')}}/bookLara/public/img/msg.png" width="32" style="margin:5px"/>
                                Messages
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('/findFriends') }}"> <img src="{{Config::get('app.url')}}/bookLara/public/img/friends.png" width="32" style="margin:5px"/>
                                Find Friends
                            </a>
                        </li>
                        @if(Auth::user()->role == "Company")
                        <li>
                            <a href="{{url('company/addJob')}}"> <img src="{{Config::get('app.url')}}/bookLara/public/img/jobs.png" width="32" style="margin:5px"/>
                                Add Job
                            </a>
                        </li>
                        @endif
                        <li>
                            <a href="{{url('/jobs')}}"> <img src="{{Config::get('app.url')}}/bookLara/public/img/jobs.png" width="32" style="margin:5px"/>
                                Find Jobs
                            </a>
                        </li>
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>