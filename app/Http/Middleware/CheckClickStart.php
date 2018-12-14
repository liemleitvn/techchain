<?php

namespace App\Http\Middleware;

use Closure;
use Auth,Lang;
class CheckClickStart
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
        if (Auth::user()->start_time != NULL && !$request->is('user/*')) {
            return redirect('user/start');
        } else if(Auth::user()->start_time == NULL){
            return redirect()->back()->with(['error'=>Lang::get('messages.exam.error.start')]);
        } 
        else { 
            return $next($request);
        }
    }
}
