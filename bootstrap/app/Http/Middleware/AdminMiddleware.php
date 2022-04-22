<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(!empty($request->user()))
        {
			
            if($request->user()->status == '1' && ($request->user()->role=='1'))  
    		{
				return $next($request);
    		    
    		}elseif($request->user()->status == '1' && ($request->user()->role=='2'))
            {
               return $next($request);
               
            }else{
                Auth::logout();
                return redirect('login')->with('error_message','Your Account Deactivated'); 
			}
        }else{
            return redirect('login')->with('error_message','Something went wrong!');
        }
    }
}
