<?php



namespace App\Http\Controllers\Admin;



use Illuminate\Http\Request;
use Validator;
use App\User;
use App\Model\Contact;
use Image;
use Input;
use Auth;
use Session;
use Excel;
use Carbon\Carbon;
use DB;

class Dashboard extends Controller

{

    public function index(Request $request)
    {
		$userdata = Auth::user();
		$role = $userdata['role']; 
		$city = $userdata['city'];  
    	$data['courses']  = DB::table('courses')->where('status',1)->count();
		
        if($role==2)
		{

			 $data['customers']  = DB::table('customers')->where('is_delete',1)
			           ->where('city',$city)->count();
			        
			 return view('laboratory.dashboard',compact('data'));
			 
		}elseif($role==3)
		{
			 return view('samplecollector.dashboard',compact('data'));
			 
		}elseif($role==4)
		{
			 return view('telecaller.dashboard',compact('data'));
			
		}else{
			 return view('admin.dashboard',compact('data'));
		}
			
       

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