<?php

namespace App\Http\Controllers\Admin;

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
    	$data['users']          = DB::table('users')->where(['is_delete'=>0,'role'=>2])->count();
    	$data['courses']  = DB::table('courses')->where('status',1)->count();
        $data['groups'] = DB::table('groups')->where('status',1)->count();
        $data['subjects']         = DB::table('subjects')->where('status',1)->count();
        $data['plans']       = DB::table('plans')->where('status',1)->count();
        
        return view('admin.dashboard',compact('data'));
    } 


    public function settings(Request $request)
    {

    	 $data['manufacturers'] = DB::table('manufacturers')->where('status',1)->count();
         $data['serial_numbers'] = DB::table('serial_numbers')->where('status',1)->count();
         $data['models']        = DB::table('models')->where('status',1)->count();
         $data['category']      = DB::table('services')->where('status',1)->count();
                             
        return view('admin.setting',compact('data'));
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
            'username'   => 'required',         
            'name'       => 'required',         
            'mobile'     => 'required|min:10|max:10',      
            'rowid'      => 'required',      
            'email'      => 'required|email'      
        ]); 

        if ($validator->fails()) {
        $userdata = Auth::user();
        $data['user'] = User::findOrFail($userdata->id);
        return view('admin.profile',compact('data'));
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

    public function showContent(Request $request,$type='')
    {
        //check permission
        $sesdata = Auth::user();
        $role = $sesdata['role'];
        $allow = $this->allow_permision('page_view',$role);
        if(!$allow)
        return redirect('404');
        //end
    
        $page = $request->segment(2);
        $data['data'] = Website_content::where('type',$page)->first();
        if(!empty($data['data']))
        {
            if($page=='about-us')
            {
                $data['page'] = 'About Us';
            }

            if($page=='disclaimer')
            {
                $data['page'] = 'Disclaimer';
            }

            if($page=='privacy-policy')
            {
                $data['page'] = 'Privacy Policy';
            }

            if($page=='terms-condition')
            {
                $data['page'] = 'Terms & Condition';
            }
            return view('admin.website-content',compact('data'));
        }else{
            return redirect('admin/dashboard');
        }
        
    }

    public function updateContent(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title'       => 'required',         
            'description' => 'required',      
            'rowid'       => 'required'      
        ]);       
        $id = $request['rowid'];
        $inst = Website_content::findOrFail($id);
        $inst->title           = ucfirst(trim($request['title']));
        $inst->description     = trim($request['description']);

        $result =  $inst->save();  
        if($result)
        {
           return back()->with('success','Content updated successfully');
        }else{
           return back()->with('error','Try again!'); 
        } 
    }

    //check permission
    public function allow_permision($view,$roleid)
    {        
       $permission = Permissions::select(['allowed'])->where('section' ,$view)->where('roleid',$roleid)->first();      
       if(!empty($permission->allowed))
       {
          return true;
       }else{
        return false;
       }
    } 
	
	
	public function reports(Request $request)
    {      

		$check = $request->session()->get('country_login'); 
		if(Auth::user()->role==4)
		{
			 $admin = DB::table('users')->where('id',Auth::user()->id)->first();
			 $country_code = $admin->country_code;
			 
				 $data['service_provider'] = DB::table('users')
						->where('role', 2)
						->where('is_delete', 0)
						->where('country_code',$country_code)
						->count();
			    $data['customer'] = DB::table('users')
						->where('role', 3)
						->where('is_delete', 0)
						->where('country_code',$country_code)
						->count();
			 
		}elseif($check!=''){
			
			 $admin = DB::table('users')->where('id',$check)->first();
			 $country_code = $admin->country_code;
			 $data['service_provider'] = DB::table('users')
						->where('role', 2)
						->where('is_delete', 0)
						->where('country_code',$country_code)
						->count();
			$data['customer'] = DB::table('users')
						->where('role', 3)
						->where('country_code',$country_code)
						->where('is_delete', 0)
						->count();			
        
		}else{
				$data['service_provider'] = DB::table('users')
						->where('role', 2)
						->where('is_delete', 0)
						->count();
						
				$data['customer'] = DB::table('users')
						->where('role', 3)
						->where('is_delete', 0)
						->count();
		}

      return view('admin.reports',compact('data'));
    }
	
	public function get_report_count(Request $request)
    {      
		$check = $request->session()->get('country_login'); 
		
		$from_date = date('Y-m-d',strtotime($request['fdt']));
		$to_date  = date('Y-m-d',strtotime($request['tdt']));
		
		if(Auth::user()->role==4)
		{
			 $admin = DB::table('users')->where('id',Auth::user()->id)->first();
			 $country_code = $admin->country_code;
			 
				 $data['service_provider'] = DB::table('users')
						->where('role', 2)
						->where('is_delete', 0)
						->where('country_code',$country_code)
						->whereBetween('created_at',[$from_date, $to_date])
						->count();
			    $data['customer'] = DB::table('users')
						->where('role', 3)
						->where('is_delete', 0)
						->whereBetween('created_at',[$from_date, $to_date])
						->where('country_code',$country_code)
						->count();
			 
		}elseif($check!=''){
			
			 $admin = DB::table('users')->where('id',$check)->first();
			 $country_code = $admin->country_code;
			 $data['service_provider'] = DB::table('users')
						->where('role', 2)
						->where('is_delete', 0)
						->whereBetween('created_at',[$from_date, $to_date])
						->where('country_code',$country_code)
						->count();
			$data['customer'] = DB::table('users')
						->where('role', 3)
						->where('country_code',$country_code)
						->whereBetween('created_at',[$from_date, $to_date])
						->where('is_delete', 0)
						->count();			
        
		}else{
				$data['service_provider'] = DB::table('users')
						->where('role', 2)
						->whereBetween('created_at',[$from_date, $to_date])
						->where('is_delete', 0)
						->count();
						
				$data['customer'] = DB::table('users')
						->where('role', 3)
						->whereBetween('created_at',[$from_date, $to_date])
						->where('is_delete', 0)
						->count();
		}

      return $data['service_provider'].'####'.$data['customer'];
    }
	
	public function export_service_providers(Request $request)
	{
		$from_date = date('Y-m-d',strtotime($request['from_date']));
		$to_date   = date('Y-m-d',strtotime($request['to_date']));
		$type      = $request['type']; 
		$fdt = $request['from_date'];
		$tdt = $request['to_date'];
		
		$check = $request->session()->get('country_login'); 
		if(Auth::user()->role==4)
		{
			 $admin = DB::table('users')->where('id',Auth::user()->id)->first();
			 $country_code = $admin->country_code;
			 
				 $res = DB::table('users')
						->where('role', $type)
						->where('is_delete', 0)
						->where('country_code',$country_code);
						if($fdt!='' && $fdt!=''){
							$res->whereBetween('created_at',[$from_date, $to_date]);
						}
			  $users = $res->get();
			 
		}elseif($check!=''){
			
			 $admin = DB::table('users')->where('id',$check)->first();
			 $country_code = $admin->country_code;
			 $res = DB::table('users')
						->where('role', $type)
						->where('is_delete', 0)
						->where('country_code',$country_code);
						if($fdt!='' && $fdt!='')
						{
							$res->whereBetween('created_at',[$from_date, $to_date]);
						}
			$users = $res->get();
        
		}else{
				$res = DB::table('users')
						->where('role', $type)
						->where('is_delete', 0);
						if($fdt!='' && $fdt!='')
						{
							$res->whereBetween('created_at',[$from_date, $to_date]);
						}
			$users = $res->get();
		}
		
			if(count($users)>0)
			{
				 foreach($users as $row)
				 {
					$exelArry[] = array(
							'Name' =>$row->first_name.' '.$row->first_name,
							'Email' =>$row->email,
							'Mobile' =>$row->mobile,
							'Gender' =>$row->gender,
							'Country Code' =>$row->country_code,
							'Created Date' =>date('d-m-Y',strtotime($row->created_at)),
							);
				 }


				Excel::create('service-provider', function($excel) use($exelArry) {
				$excel->sheet('ExportFile', function($sheet) use($exelArry) {
				$sheet->fromArray($exelArry, '0', 'A1', true);
				});
				})->export('xls');
			}else{
			   return back()->with('error','Wrong action perform!!');
			}
	}
	
	public function export_customers(Request $request)
	{
		$check = $request->session()->get('country_login'); 
		if(Auth::user()->role==4)
		{
			 $admin = DB::table('users')->where('id',Auth::user()->id)->first();
			 $country_code = $admin->country_code;
			 
				 $users = DB::table('users')
						->where('role', 2)
						->where('is_delete', 0)
						->where('country_code',$country_code)
						->get();
			 
		}elseif($check!=''){
			
			 $admin = DB::table('users')->where('id',$check)->first();
			 $country_code = $admin->country_code;
			 $users = DB::table('users')
						->where('role', 2)
						->where('is_delete', 0)
						->where('country_code',$country_code)
						->get();
        
		}else{
				$users = DB::table('users')
						->where('role', 2)
						->where('is_delete', 0)
						->get();
		}
			if(count($users)>0)
			{
				 foreach($users as $row)
				 {
					$exelArry[] = array(
							'Name' =>$row->first_name.' '.$row->first_name,
							'Email' =>$row->email,
							'Mobile' =>$row->mobile,
							'Gender' =>$row->gender,
							'Country Code' =>$row->country_code,
							'Created Date' =>date('d-m-Y',strtotime($row->created_at)),
							);
				 }

				Excel::create('service-provider', function($excel) use($exelArry) {
				$excel->sheet('ExportFile', function($sheet) use($exelArry) {
				$sheet->fromArray($exelArry, '0', 'A1', true);
				});
				})->export('xls');
			}else{
			   return back()->with('error','Wrong action perform!!');
			}
	}

    //class end
}