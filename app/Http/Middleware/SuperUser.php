<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Session;

class SuperUser
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
        if(Auth::user()->hasRole('SuperUser'))
            return $next($request);  
        
        else
        {
             Session::flash('warning', 'Tried to enter restricted area!');
              return redirect()->intended('/home'); 
        }
    }
}
