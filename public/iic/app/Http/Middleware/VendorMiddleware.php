<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Response;
use App\User;
use DB;

class VendorMiddleware
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
            $user = User::find(Auth::user()->id);
            if ($request->user() && $user->role != '3')
            {
                return redirect('checklogin');
            }
            $address = DB::table('user_address')->where('user_id',$user->id)->first();
            if(($user->verify!=1 && $user->role == 3) || empty($address))
            {
                return redirect('contributor/verification');
            }

            return $next($request);
        }else{
            return redirect('/')->with('error','Something went wrong!');
        }
    }
}
