<?php

namespace App\Http\Controllers\Admin;

use App\Model\Centres;
use App\Model\States;
use App\Model\Cities;
use App\Model\Question;
use App\Model\Sections;
use App\Model\Student_Results;
use App\Model\Student_Levels;
use App\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $title = 'Dashboard';
        return view('admin.dashboard', compact('title'));
    }

    public function checkLogin(Request $request)
    {
        $user = Auth::user();
        $u = User::findOrFail($user->id);
        if ($u->isLogin == 1) {
            if ($user->role == 1) {
                return redirect('dashboard');
            }elseif($user->role == 3){
                if($user->status==2)
                {
                    Auth::logout();
                    return redirect('/')->with('front_error', 'Your account under review');
                }
                return redirect('contributor/my-profile');
            }
            return redirect('/');

        } elseif ($u->isLogin == 0) {
            Auth::logout();
            return redirect('/')->with('front_error', 'Your account disabled');
        }
    }

/* end of class*/

}
