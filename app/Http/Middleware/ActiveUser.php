<?php

namespace SocialNetwork\Http\Middleware;

use Illuminate\Support\Carbon;
use Cache;
use Closure;
use Auth;

class ActiveUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check()){
            $expireTime = Carbon::now()->addMinutes(1);
            Cache::put('active-user' . Auth::user()->id, true, $expireTime);
        }
        return $next($request);
    }
}
