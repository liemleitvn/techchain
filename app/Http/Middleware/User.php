<?php

namespace App\Http\Middleware;

use Closure;
use Auth,Lang;

class User
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
        if(Auth::check() && Auth::user()->is_disable == config('constant.active')){
            return $next($request);
        } else {
            return redirect('/')->with(['error'=>Lang::get('messages.login.error')]);
        }
    }
}
