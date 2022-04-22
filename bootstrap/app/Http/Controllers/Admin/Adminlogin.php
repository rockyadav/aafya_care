<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Auth;
use App\User;
class Adminlogin extends Controller
{

    //login page load
    public function index()
    {
    	if(AUTH::user())
    	{
    		return redirect('admin/dashboard');
    	}

        return view('admin.login');
    }

    //register page load
    public function register()
    {
        return view('admin.register');
    }
}