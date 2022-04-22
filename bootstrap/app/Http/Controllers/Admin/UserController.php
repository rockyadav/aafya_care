<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Validator;
use App\User;
use Image;
use Input;
use Auth;
use DB;
use Carbon\Carbon;
use File;


class UserController extends Controller
{

    public function users(Request $request)
    {
        $data['list'] = DB::table('users')
                        ->where('role',2)
                        ->where('is_delete',0)
                        ->orderBy('id','DESC')
                        ->paginate(15);
          
        return view('admin.users.list',compact('data'));    
    }


    public function user_add(Request $request)
    {
         return view('admin.users.add');
    }
   
     public function add_user_action(Request $request)
    {
       $validator = Validator::make($request->all(), [
        'name'             => 'required',
        'mobile'           => 'required|unique:users|min:10|max:10',
        'email'            => 'required|string|email|unique:users',
        'city'             => 'required',
        'password'         => 'required|min:6'
        ]);
 
        if ($validator->fails()) 
        {
            return redirect()->back() ->withErrors($validator)->withInput(); 
        }
  
          $catdata = new User;  
          $catdata->password           = trim($request['password']); 
          $catdata->name               = trim($request['name']);
          $catdata->mobile             = trim($request['mobile']);
          $catdata->email              = trim($request['email']); 
          $catdata->city               = trim($request['city']);
          $catdata->role               = 2 ;

        $result =  $catdata->save();  
        if($result)
        {
            return redirect('admin/users')->with('success','User details has been saved successfully.');
        }else{
            return back()->with('error','Try again.');
        }               
        
        
    }

    
    
    public function user_edit($id)
    {
         $user = User::select(['*'])->where('id' ,$id)->first();
         return view('admin.users.edit',compact('user'));

           
    }

   
    public function update_user(Request $request)
    {
         $validator = Validator::make($request->all(), [
          'name'     => 'required',
          'mobile'   => 'required|min:10|max:10',
          'email'    => 'required|string|email',
          'city'     => 'required'
          ]);

        if ($validator->fails()) 
        {
            return redirect()->back() ->withErrors($validator)->withInput(); 
        }
          $id = trim($request['user_id']); 
          $catdata = User::findOrFail($id); 
         
          $catdata->name     = trim($request['name']);
          $catdata->mobile   = trim($request['mobile']);
          $catdata->email    = trim($request['email']); 
          $catdata->city     = trim($request['city']);

          if(trim($request['password'])!='')
          {   
            $validator  = Validator::make($request->all(), [
             'password' =>'required|min:6',
            ]);

            if($validator->fails()) 
            {
               return redirect()->back() ->withErrors($validator)->withInput(); 
            }
               $catdata->password = bcrypt(trim($request['password']));
          }

        $result =  $catdata->save();  
        if($result)
        {
            return back()->with('success','Details has been updated successfully.');
        }else{
            return back()->with('error','Try again.');
        } 
    }

    
    public function user_destroy(Request $request,$id)
    {
        $item = User::findOrFail($id);

        $res =  DB::table('users')
                ->where('id', $id)
                ->update(['is_delete' => 1]);
        if($res>0)
        {
           echo 'success'; 
        }else{
                echo 'error';  
        }
    }
	
	
    //class end
}
