<?php

namespace SocialNetwork\Http\Middleware;

use Closure;
use Auth;
class Company
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
        //check user if login and this user is Company or not
        if(Auth::check() && Auth::user()->isRole()=="Company") {
            //if this user really company then redirect to their home
            return $next($request);
        }
        //if this is not company the redirect to login
        return redirect('login');
    }
}
