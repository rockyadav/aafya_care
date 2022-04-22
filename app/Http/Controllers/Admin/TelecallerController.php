<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Customer;
use App\Model\Discount_coupon;
use Validator;
use App\User;
use Image;
use Input;
use Auth;
use DB;
use File; 


class TelecallerController extends Controller
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

        return view('telecaller.profile',compact('data'));

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
                         ->paginate(20);
        return view('telecaller.users.list',compact('data'));    
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

        return view('telecaller.users.view',compact('users'));    
    }
	
	
	 public function telecaller_customer_edit($id)
    {
		 $user = DB::table('customers')
                     ->leftJoin('cities', 'customers.city', '=', 'cities.id')
                         ->leftJoin('courses', 'customers.test_id', '=', 'courses.id')
                         ->where('customers.is_delete',1)
             ->where('customers.id',$id)
             ->select('customers.*','courses.course_name','cities.name as city_name')
                         ->orderBy('customers.id','DESC')
                         ->first();
						 
			 $city   = DB::table('cities')->orderBy('name','asc')->get();	
             $courses = DB::table('courses')->orderBy('course_name','asc')->where('status',1)->get();				 
						 
						 
         return view('telecaller.users.edit',compact('user','city','courses'));

           
    }

   
    public function telecaller_customer_edit_action(Request $request)
    {
         $validator = Validator::make($request->all(), [
          'name'     => 'required',
          'mobile'   => 'required',
          'city'     => 'required',
          'gender'   => 'required',
		      'test_id'         => 'required',
          'full_address'    => 'required',
          'address_pin'     => 'required',
          'landmark'        => 'required',
          'dob'             => 'required',
          'blood_group'     => 'required',
    		  'any_treatment'   => 'required',
    		  'visit_date'   => 'required',
    		  'visit_time'   => 'required'
		
          ]);


        if ($validator->fails()) 
        {
            return redirect()->back() ->withErrors($validator)->withInput(); 
        }
          echo $id = trim($request['user_id']); 
          $catdata = Customer::findOrFail($id); 
         
          $catdata->name     = trim($request['name']);
          $catdata->mobile   = trim($request['mobile']);
          $catdata->email    = trim($request['email']); 
          $catdata->city     = trim($request['city']);
          $catdata->test_id  = trim($request['test_id']);
          $catdata->gender   = trim($request['gender']);
		      $catdata->full_address  = trim($request['full_address']);
          $catdata->address_pin   = trim($request['address_pin']);
		      $catdata->landmark  = trim($request['landmark']);
          $catdata->dob          = trim($request['dob']);
		      $catdata->blood_group  = trim($request['blood_group']);
          $catdata->any_treatment   = trim($request['any_treatment']);
		      $catdata->visit_date   = trim($request['visit_date']);
          $catdata->visit_time   = trim($request['visit_time']);
		      $catdata->id_passport_no   = trim($request['id_passport_no']);
		 
        $result =  $catdata->save();  
        if($result)
        {
            return back()->with('success','Details has been updated successfully.');
        }else{
            return back()->with('error','Try again.');
        } 
    }

    //class end

}

