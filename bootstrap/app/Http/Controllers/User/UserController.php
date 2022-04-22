<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\User_manual;
use App\Model\Manual;
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
	

	public function index(Request $request)
    {
		
	   $data['list'] = DB::table('users')
                        ->where('role',2)
                        ->where('is_delete',0)
                        ->orderBy('id','DESC')
                        ->paginate(15);
						
        return view('admin.members.members',compact('data'));    
    }
	
	 public function membersChnageStatus($id){
       
            $item = User::find($id);
            if(($item->status)=='1'){
                $item->status = '0';
            } else {
                $item->status = '1';
            }
            $item->save();
        
    } 

     public function customerChnageStatus($id){
       
            $item = User::find($id);
            if(($item->status)=='1'){
                $item->status = '0';
            } else {
                $item->status = '1';
            }
            $item->save();
        
    } 

   
    public function create()
    {
        return view('admin.members.member_add',compact('service'));
    }

    public function view_details(Request $request,$id)
    {
		if($id!='')
		{
          $user = User::select(['*'])->where('id' ,$id)->first();
          return view('admin.members.member_view',compact('user'));
		  
		}else{
			return redirect('admin/members');
		}
    }
	
  public function customer_details($id='')
  {
        $user = User::select(['*'])->where('id' ,$id)->first();
        $umanual = User_manual::where('user_id' ,$id)->first();
        if($umanual!=''){
          $manual_id = explode(',', $umanual->manual_id);
        }else{
          $manual_id = array();
        }
        $manuals = DB::table('manuals')
                       ->join('manufacturers', 'manuals.manufacturer_id', '=', 'manufacturers.id')
                       ->join('models', 'manuals.model_id', '=', 'models.id')
                       ->join('services', 'manuals.category_id', '=', 'services.id')
                       ->join('serial_numbers', 'manuals.serial_number_id', '=', 'serial_numbers.id')
                       ->where('manuals.is_delete',0)
                       ->whereIn('manuals.id',$manual_id)
                       ->select('manuals.*','manufacturers.name as manufacturer_name','models.model_name','serial_numbers.serial_number','services.service_name')
                       ->orderBy('manuals.id','DESC')
                       ->paginate(15);
		 
         return view('admin.customers.customer_details',compact('user','manuals'));
    }

    public function store(Request $request)
    {
       $validator = Validator::make($request->all(), [
          'username'         => 'required|unique:users',
		      'name'             => 'required',
          'referral_code'    => 'required',
          'mobile'           => 'required|numeric|unique:users',
          'email'            => 'required|string|email|unique:users',
          'gender'           => 'required',
		      'business_name'    => 'required',
		      'business_details' => 'required',
          'image'            => 'mimes:jpeg,jpg,gif,png,svg|max:10240',
          'password'         => 'required|min:6',
          'pay_status'       => 'required'  
          ]);

        if ($validator->fails()) 
        {
            return redirect()->back() ->withErrors($validator)->withInput(); 
        }
  
         $check = DB::table('users')
					   ->orderBy('id','DESC')
					   ->limit(1)
					   ->select('id','unique_code')
					   ->get();

			if(count($check)>0)
			{	   
				$apno = $check[0]->unique_code;	
				$ss = explode('-',$apno);
				$appno = $ss[1]+1;
				$unique_no = "MLM-".$appno;
				
			}else{
				$unique_no = "MLM-1001";
			}	
  

          $catdata = new User;  
          $catdata->name               = trim($request['name']); 
          $catdata->unique_code        = trim($unique_no);
		      $catdata->referral_code      = trim($request['referral_code']);	
		      $catdata->username           = trim($request['username']);
          $catdata->mobile             = trim($request['mobile']);
          $catdata->email              = trim($request['email']); 
          $catdata->gender             = trim($request['gender']);
          $catdata->address            = trim($request['address']);
		      $catdata->business_name      = trim($request['business_name']);
          $catdata->business_details   = trim($request['business_details']);
		      $catdata->pay_status         = trim($request['pay_status']);
          $catdata->password           = bcrypt(trim($request['password']));
          $catdata->role               = 2 ;

           if ($request->hasFile('image'))
           {
              $file = array('image' => Input::file('image'));
              $destinationPath = 'public/photos/'; 
              $extension = Input::file('image')->getClientOriginalExtension(); 
              $fileName = date('m-d-Y_hia').rand(1,99999).'.'.$extension;
              Input::file('image')->move($destinationPath, $fileName);
               $catdata->image = $fileName;
            } 

        $result =  $catdata->save();  
        if($result)
        {
            return redirect('admin/members')->with('success','Member details has been saved successfully.');
        }else{
            return back()->with('error','Try again.');
        }               
        
    }

    
    public function edit(Request $request,$id)
    {
        $user = User::select(['*'])->where('id' ,$id)->first();
        return view('admin.members.member_edit',compact('user'));
    }

   
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
		      'name'             => 'required',
          'mobile'           => 'required|numeric',
          'email'            => 'required|string|email',
          'gender'           => 'required',
		      'business_name'    => 'required',
		      'business_details' => 'required',
          'image'            => 'mimes:jpeg,jpg,gif,png,svg|max:10240',
          'pay_status'       => 'required'  
          ]);

        if ($validator->fails()) 
        {
            return redirect()->back() ->withErrors($validator)->withInput(); 
        }
         
          $catdata = User::findOrFail($id); 

          $catdata->name               = trim($request['name']); 
		      $catdata->username           = trim($request['username']);
          $catdata->mobile             = trim($request['mobile']);
          $catdata->email              = trim($request['email']); 
          $catdata->gender             = trim($request['gender']);
          $catdata->address            = trim($request['address']);
		      $catdata->business_name      = trim($request['business_name']);
          $catdata->business_details   = trim($request['business_details']);
		      $catdata->pay_status         = trim($request['pay_status']);

          if(trim($request['password'])!='')
          {
              $catdata->password             = bcrypt(trim($request['password']));
          }

           if ($request->hasFile('image'))
           {

              $img = $catdata->image;
              if($img!='')
              {
                 unlink('public/photos/'.$img);
              }

              $file = array('image' => Input::file('image'));
              $destinationPath = 'public/photos/'; 
              $extension = Input::file('image')->getClientOriginalExtension(); 
              $fileName = date('m-d-Y_hia').rand(1,99999).'.'.$extension;
              Input::file('image')->move($destinationPath, $fileName);
               $catdata->image = $fileName;
            }  
         
        $result =  $catdata->save();  
        if($result)
        {
            return back()->with('success','Member details has been updated successfully.');
        }else{
            return back()->with('error','Try again.');
        } 
    }

    
    public function destroy(Request $request,$id)
    {
        $item = User::findOrFail($id);
        $img = $item->image;
        if($img!='')
        {
          unlink('public/photos/'.$img);
        }

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
	

    public function customers(Request $request)
    {
        $data['list'] = DB::table('users')
                        ->where('role',3)
                        ->where('is_delete',0)
                        ->orderBy('id','DESC')
                        ->paginate(15);

         $data['manuals'] = DB::table('manuals')
                              ->where('is_delete',0)
                              ->where('status',1)
                              ->orderBy('id','DESC')
                              ->get(); 
          
        return view('admin.customers.customers',compact('data'));    
    }


    public function customer_add(Request $request)
    {
         return view('admin.customers.customer_add');
    }
   
     public function add_customer_action(Request $request)
    {
       $validator = Validator::make($request->all(), [
          'username'         => 'required|unique:users',
          'name'             => 'required',
          'referral_code'    => 'required',
          'mobile'           => 'required|numeric|unique:users',
          'email'            => 'required|string|email|unique:users',
          'gender'           => 'required',
          'business_name'    => 'required',
          'business_details' => 'required',
          'image'            => 'mimes:jpeg,jpg,gif,png,svg|max:10240',
          'password'         => 'required|min:6',
          'pay_status'       => 'required'  
          ]);

        if ($validator->fails()) 
        {
            return redirect()->back() ->withErrors($validator)->withInput(); 
        }
  
         $check = DB::table('users')
             ->orderBy('id','DESC')
             ->limit(1)
             ->select('id','unique_code')
             ->get();

      if(count($check)>0)
      {    
        $apno = $check[0]->unique_code; 
        $ss = explode('-',$apno);
        $appno = $ss[1]+1;
        $unique_no = "MLM-".$appno;
        
      }else{
        $unique_no = "MLM-1001";
      } 
  
          $catdata = new User;  
          $catdata->name               = trim($request['name']); 
          $catdata->unique_code        = trim($unique_no);
      $catdata->referral_code      = trim($request['referral_code']); 
      $catdata->username           = trim($request['username']);
          $catdata->mobile             = trim($request['mobile']);
          $catdata->email              = trim($request['email']); 
          $catdata->gender             = trim($request['gender']);
          $catdata->address            = trim($request['address']);
      $catdata->business_name      = trim($request['business_name']);
          $catdata->business_details   = trim($request['business_details']);
      $catdata->pay_status         = trim($request['pay_status']);
          $catdata->password           = bcrypt(trim($request['password']));
          $catdata->role               = 3 ;

           if ($request->hasFile('image'))
           {
              $file = array('image' => Input::file('image'));
              $destinationPath = 'public/photos/'; 
              $extension = Input::file('image')->getClientOriginalExtension(); 
              $fileName = date('m-d-Y_hia').rand(1,99999).'.'.$extension;
              Input::file('image')->move($destinationPath, $fileName);
               $catdata->image = $fileName;
            } 

        $result =  $catdata->save();  
        if($result)
        {
            return redirect('admin/customers')->with('success','Customer details has been saved successfully.');
        }else{
            return back()->with('error','Try again.');
        }               
        
        
    }

    
    
    public function customer_edit($id)
    {
         $user = User::select(['*'])->where('id' ,$id)->first();
         return view('admin.customers.customer_edit',compact('user'));

           
    }

   
    public function update_customer(Request $request)
    {
        $validator = Validator::make($request->all(), [
		  'name'             => 'required',
          'mobile'           => 'required|numeric',
          'email'            => 'required|string|email',
          'gender'           => 'required',
		  'business_name'    => 'required',
		  'business_details' => 'required',
          'image'            => 'mimes:jpeg,jpg,gif,png,svg|max:10240',
          'pay_status'       => 'required'  
          ]);

        if ($validator->fails()) 
        {
            return redirect()->back() ->withErrors($validator)->withInput(); 
        }
         $id = trim($request['user_id']); 
          $catdata = User::findOrFail($id); 

          $catdata->name               = trim($request['name']); 
		  $catdata->username           = trim($request['username']);
          $catdata->mobile             = trim($request['mobile']);
          $catdata->email              = trim($request['email']); 
          $catdata->gender             = trim($request['gender']);
          $catdata->address            = trim($request['address']);
		  $catdata->business_name      = trim($request['business_name']);
          $catdata->business_details   = trim($request['business_details']);
		  $catdata->pay_status         = trim($request['pay_status']);

          if(trim($request['password'])!='')
          {
              $catdata->password             = bcrypt(trim($request['password']));
          }

           if ($request->hasFile('image'))
           {

              $img = $catdata->image;
              if($img!='')
              {
                 unlink('public/photos/'.$img);
              }

              $file = array('image' => Input::file('image'));
              $destinationPath = 'public/photos/'; 
              $extension = Input::file('image')->getClientOriginalExtension(); 
              $fileName = date('m-d-Y_hia').rand(1,99999).'.'.$extension;
              Input::file('image')->move($destinationPath, $fileName);
               $catdata->image = $fileName;
            }  
         
        $result =  $catdata->save();  
        if($result)
        {
            return back()->with('success','Member details has been updated successfully.');
        }else{
            return back()->with('error','Try again.');
        } 
    }

    
    public function customer_destroy(Request $request,$id)
    {
        $item = User::findOrFail($id);
        $img = $item->image;
        if($img!='')
        { 
          unlink('public/photos/'.$img);
        }

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
