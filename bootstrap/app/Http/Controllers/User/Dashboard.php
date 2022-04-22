<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Validator;
use App\User;
use Image;
use Input;
use Auth;
use Session;
use DB;
use Excel;
use Carbon\Carbon;
class Dashboard extends Controller
{

    //home page load
    public function index(Request $request)
    {
      
       $userid = Auth::user()->id ;
       $mymanual = DB::table('user_manuals')
                       ->where('user_id',$userid)
                       ->first();
      if($mymanual!='')
      {
            $manualid = explode(',', $mymanual->manual_id); 
      }else{                 
            $manualid = array();  
      }   

        $data['manuals']  = DB::table('manuals')->whereIn('id',$manualid)->where('is_delete',0)->count();
        return view('user.dashboard',compact('data'));
    } 


    //profile image update
    public function changeImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'mimes:jpeg,jpg,png|max:10240',
            'rowid' =>'required'
        ]); 
        if ($request->hasFile('image')) {
            $updata = User::findOrFail($request['rowid']);   

            $file = Input::file('image');
            $destinationPath = 'photos/'; 
            $extension = Input::file('image')->getClientOriginalExtension(); 
            $fileName = date('m-d-Y_hia').rand(1,99999).'.'.$extension;
            $image_resize = Image::make($file->getRealPath());              
            $image_resize->resize(300, 300);
            $image_resize->save(public_path($destinationPath.'/' .$fileName));
            $updata->image = $fileName;
            $res = $updata->save();
            if($res)
            {
               return back()->with('success','Image updated successfully');
            }else{
               return back()->with('error','Try again!'); 
            } 
        }else{
            return back()->with('error','Try again!'); 
        } 
    }

    //profile page load
    public function profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',         
            'name'  => 'required',         
            'mobile'     => 'required',      
            'rowid'      => 'required',      
            'email'      => 'required'      
        ]); 

        if ($validator->fails()) {
        $userdata = Auth::user();
        $data['user'] = User::findOrFail($userdata->id);
        return view('user.profile',compact('data'));
        }else{
               $updata = User::findOrFail($request['rowid']);
               $updata->username   = trim($request['username']);
               $updata->name       = trim($request['name']);
               $updata->email      = trim($request['email']);
               $updata->mobile     = trim($request['mobile']);

               if($request['password']!=''){
                $updata->password       = bcrypt($request['password']);
               }

               $updata->address    = trim($request['address']);
               $res = $updata->save();
               if($res)
               {
                   return back()->with('success','Profile updated successfully');
               }else{
                   return back()->with('error','Try again!'); 
               } 
        }
    }

   

    //class end
}