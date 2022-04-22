<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Discount;
use Validator;
use App\User;
use Image;
use Input;
use Auth;
use DB;
use File;


class SampleCollectorController extends Controller
{

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

            'username'   => 'required',         

            'name'       => 'required',         

            'mobile'     => 'required|min:10|max:10',      

            'rowid'      => 'required',      

            'email'      => 'required|email'      

        ]); 



        if ($validator->fails()) {

        $userdata = Auth::user();

        $data['user'] = User::findOrFail($userdata->id);

        return view('samplecollector.profile',compact('data'));

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



     public function customers(Request $request)
    {
       
        $data['list'] = DB::table('customers')
                     ->leftJoin('cities', 'customers.city', '=', 'cities.id')
                         ->leftJoin('courses', 'customers.test_id', '=', 'courses.id')
                         ->where('customers.is_delete',1)
             ->select('customers.*','courses.course_name','cities.name as city_name')
                         ->orderBy('customers.id','DESC')
                         ->get();
        return view('samplecollector.users.list',compact('data'));    
    }

    public function customer_details($id)
    {
      
       $users = DB::table('customers')
                     ->leftJoin('cities', 'customers.city', '=', 'cities.id')
                         ->leftJoin('courses', 'customers.test_id', '=', 'courses.id')
                         ->where('customers.is_delete',1)
             ->where('customers.id',$id)
             ->select('customers.*','courses.course_name','cities.name as city_name')
                         ->orderBy('customers.id','DESC')
                         ->first(); 

        return view('samplecollector.users.view',compact('users'));    
    }


    

    public function takeSampleCustomer(Request $request)
    {
      $validator = Validator::make($request->all(), [
              'user_id'  => 'required',
              'sample_status'   => 'required'
          ]);


        if ($validator->fails()) 
        {
             return redirect()->back() ->withErrors($validator)->withInput(); 
        }

       $user_id = trim($request['user_id']);
       $status = $request['sample_status']; 
      
       $users = DB::table('customers')
                        ->where('id',$user_id)
                        ->first(); 
        if($users!='')
        {

             $sss = DB::table('customers')
                  ->where('id', $user_id) 
                  ->update(array('status' => $status,'sample_collect_date'=>date('d-m-Y h:s:a')));  

           return redirect()->back()->with('success_message','Your status has been updated successfully.');

        }else{

            return back()->with('error_message','Please try again.');
        }                
 
    }

    //class end

}

