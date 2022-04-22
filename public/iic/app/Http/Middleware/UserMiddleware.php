<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Response;

class UserMiddleware
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
            $user = Auth::user(); 
            if ($request->user() && $request->user()->role != '2')
            {
                return redirect('checklogin');
            }
            return $next($request);
        }else{
            return redirect('/')->with('error','Something went wrong!');
        }
    }
}
