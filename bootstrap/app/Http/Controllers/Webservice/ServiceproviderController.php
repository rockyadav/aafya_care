<?php

namespace App\Http\Controllers\Webservice;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\Business_profiles;
use App\Model\Service_image;
use App\Model\Banner;
use App\Helpers\Helper;
use App\Model\Gallery;
use App\Model\Country;
use App\Model\Service;
use App\Model\My_vacation;
use App\Model\Payment;
use App\Model\Appointment;
use App\Model\Break_time; 
use App\Model\Availability;
use App\Model\Invoice;
use App\Model\Notification; 
use App\Model\Tag; 
use Carbon\Carbon;
use Validator;
use App\User;
use Excel;
use PDF;
use DB;
use Input;
use AfricasTalking\SDK\AfricasTalking;
class ServiceproviderController extends Controller
{
	  
  public function send_message($message,$contact,$pcode="")
   {
        $username = 'psuser'; // use 'sandbox' for development in the test environment
	    $apiKey   = 'd15f199735cf6c483ce602644675cf01ab6df8234b2f9cc98e1b69b7fb0c00d9'; // use your sandbox app API key for development in the test environment
		$AT      = new AfricasTalking($username, $apiKey);

			// Get one of the services
		$sms      = $AT->sms();

			// Use the service
			$result   = $sms->send([
				'to'      => '+'.$pcode.$contact,
				'message' => $message
			]);

		//print_r($result); 
		  return 'true';
    }
	
    //user login
    public function userLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile'        => 'required',
            'password'      => 'required',
			'role'          => 'required',
			'country_code'  => 'required',
            'fcm_token'     => 'nullable'
        ]);

        if($validator->fails())
       {
           return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
       }

        $u = User::where('mobile', $request->mobile)->where('is_delete', 0)
                 ->first(); 
        if(!$u)
        {
            return response()->json([ 
                'status'  => 0,
				'otp'  => '',
                'message' => 'Please enter a valid mobile number.'
            ], 200);
        }
		
	  $mobile = $request->mobile;	
	  $phonecode = $request->country_code;
	  $otp    = mt_rand(1000,9999);
	  $msg    = "Welcome :\n Your one time Password is : ".$otp;

        if(!empty($u))
        {
            if($u->status==0)
            {
                return response()->json([
                    'status'  => 0,
					'otp'  => '',
                    'message' => 'Your account is not activated.'
                ], 200);
            } 
			
			if($u->is_verify==0)
            {
				$this->send_message($msg,$mobile,$phonecode);
				
				$resut =  DB::table('users')
							->where('id', $u->id)
							->update(['otp' => $otp]);
							
                return response()->json([
                    'status'  => 0,
					'otp'  => "$otp",
                    'message' => 'Your account is not verified.Send otp in your mobile no.',
					'response'=> array('user_data' => $this->userResponse($u))
                ], 200);
            }
        }

        $p = User::where('mobile', $request->mobile)->first();
        if(!$p)
        {
            return response()->json([
                'status'  => 0,
				'otp'  => '',
                'message' => 'Your account is not created.'
            ], 200);
        }
          
        $credentials = request(['mobile', 'password','country_code']);

        if(!Auth::attempt($credentials))
            return response()->json([
                'status'  => 0,
				'otp'     => '',
                'message' => 'Invalid mobile number,password or country'
            ], 200);
        
        $user = $request->user();
        $user->fcm_token = $request->fcm_token;
        $user->otp = $otp;
        $user->save();

        return response()->json([
            'status'  => 1,
            'message' => 'Login successfully',
            'response'=> array('user_data' => $this->userResponse($user))
        ]);
    }

    //country list
    public function countryList(Request $request)
    {
        $country = Country::where('status',1)
							->orderBy('name','ASC')
							->get();
        if(count($country)>0)
        {
            return response()->json([
                'status'  => 1,
                'message' => 'success',
                'response'=> array('data' => $country),
            ]);
        }else{
            return response()->json([
                'status' => 0, 
                'message'=>'Country list not found.'
            ],200);
        }
    }

    //restaurant sign-up
    public function signUp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'      => 'required',
            'last_name'       => 'required',      
            'email'           => 'required',        
            'country_code'    => 'required',  
            'mobile'          => 'required|numeric|unique:users',
			'role'            => 'required',        
            'password'        => 'required',
            'fcm_token'       => 'required',
            'device_type'     => 'required',  
        ]); 

        if ($validator->fails()) {
             return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
        }else{

               $mobile = User::where('mobile', $request->mobile)->first();
               if(!empty($mobile))
               {  
                   return response()->json(['status' => 0, 'message'=>'Mobile already exist'], 200);
               }
               $otp = mt_rand(1000,9999);
			   $mobile = trim($request->mobile);
			   $phonecode = trim($request->country_code);
			   
			   $msg = "Welcome :\n Your one time Password is : ".$otp;
			   
                $user = new User([
                                   'first_name'   => ucwords(trim($request->first_name)),
                                   'last_name'    => ucwords(trim($request->last_name)),
                                   'country_code' => trim($request->country_code),
                                   'mobile'       => trim($request->mobile),
                                   'email'        => trim($request->email),
                                   'service_type' => trim($request->service_type),
                                   'role'         => trim($request->role),
                                   'password'     => bcrypt($request->password),
                                   'fcm_token'    => $request->fcm_token,
                                   'device_type'  => $request->device_type,
								   'otp'          => $otp,
                                   'status'       => 1
                               ]);

                $user->save();

                $credentials = request(['email', 'password']);

                if(!Auth::attempt($credentials))
                return response()->json([
                    'status'  => 0,
                    'message' => 'Invalid email or password'
                ], 200);

                $user = $request->user();
				
				$this->send_message($msg,$mobile,$phonecode);

                return response()->json([
                    'status'  => 1,
                    'message' => 'registered successfully',
                    'response'=> array('data' => $this->userResponse($user)),
                ]);
        }
    }

    //verify otp
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'  =>'required',
            'otp'      => 'required'
        ]); 

        if ($validator->fails()) {
             return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
        }else{
                $id  = $request->user_id;
				$otp = $request->otp;
                $rest =  User::where('id',$id)->where('otp',$otp)->first();
				if($rest!='')
				{
					$rest['is_verify']  = 1 ;
                    $res = $rest->save();
					 return response()->json([
                        'status'  => 1,
                        'message' => 'Otp verified successfully!'
                    ]);
				}else{
					return response()->json([
                        'status'  => 0,
                        'message' => 'Otp not match!'
                    ]);
				}                
        }
    } 
	
    //profile udpate
    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'     =>'required',
            'last_name'      =>'required',
			'service_type'   =>'required',  
            'email'          => 'required'
        ]); 

        if ($validator->fails()) {
             return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
        }else{
                $id = $request->user_id;
                $pass = trim($request->password);

                $user =  User::findOrFail($id);
                $user['first_name']      = ucwords(trim($request->first_name));
                $user['last_name']       = ucwords(trim($request->last_name));
				$user['service_type']    = trim($request->service_type);
				$user['country_code']    = trim($request->country_code);
                if(trim($request->mobile)!='')
                {
                    $user['mobile']      = trim($request->mobile);
                }
                
                $user['email']           = trim($request->email);

                if($pass!='')
                {
                    $user['password']    = bcrypt($pass);
                }

                if($request->hasFile('image'))
                {
                    $validator = Validator::make($request->all(), [
                        'image'    => 'required|image|mimes:jpg,png,gif,jpeg',
                        [ 
                            'image.mimes' => 'Images must have format (JPEG, PNG, JPG, GIF)',
                            'image.max' => 'Image size not greater than 1 MB' 
                        ] 
                    ]);

                    if($validator->fails())
                    {
                        return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
                    }

                    $image = $request->file('image');
                    $imagename = time().'.'.$image->getClientOriginalExtension();
                    $destinationPath = public_path('/photos');
                    $image->move($destinationPath, $imagename);
                    $user['image'] = $imagename;
                }      
               
                $res = $user->save();
                if($res)
                {
                    return response()->json([
                        'status'  => 1,
                        'message' => 'Profile updated successfully!',
                    ]);
                }else{
                    return response()->json([
                        'status'  => 0,
                        'message' => 'Please try again!'
                    ]);
                }                
        }
    }

    //get profile
    public function getProfile(Request $request)
    {
        if ($request['user_id']=='') {
             return response()->json(['status' => 0, 'message'=>'User id required'], 200);
        }

       $id =  $request['user_id'];

        $user = User::where('id',$id)->first();
        if(!empty($user))
        {
            return response()->json([
                'status'  => 1,
                'message' => 'success',
                'response'=> array('data' => $this->userResponse($user)),
            ]);
        }else{
            return response()->json(['status' => 0, 'message'=>'Profile details not found'], 200);
        }
    }

    //business profile udpate
    public function businessProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'          =>'required',
            'business_name'    =>'required',
            'country_code'     =>'required',
            'mobile'           =>'required',
            'start_time'       =>'required',
            'end_time'         =>'required',
            'slot_interval'    =>'required',
            'marchent_email'   =>'required',
            'latitude'         =>'required',
            'longitude'        =>'required',
			'business_for'     =>'required',
            'experience'       =>'required',
			'business_logo'    =>'image|mimes:jpg,png,svg,jpeg',
        ]); 

        if ($validator->fails()) {
             return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
        }else{
                $user_id = $request->user_id;
                $pass = trim($request->password);

                $check =  Business_profiles::where(['user_id'=>$user_id,'status'=>1])->first();
                if(!empty($check))
                {
                    $business = Business_profiles::findOrFail($check->id);
					
					if($request->hasFile('business_logo'))
						{
							if($business->business_logo!="")
							{
								unlink('public/photos/'.$business->business_logo);
							}
							$image = $request->file('business_logo');
							$imagename = time().'.'.$image->getClientOriginalExtension();
							$destinationPath = public_path('/photos');
							$image->move($destinationPath, $imagename);
							$business['business_logo'] = $imagename;
						} 
					
                }else{
                    $business = new Business_profiles;
					
					 if($request->hasFile('business_logo'))
						{
							$image = $request->file('business_logo');
							$imagename = time().'.'.$image->getClientOriginalExtension();
							$destinationPath = public_path('/photos');
							$image->move($destinationPath, $imagename);
							$business['business_logo'] = $imagename;
						} 
                }

                $business['user_id']         = trim($request->user_id);
                $business['business_name']   = ucwords(trim($request->business_name));
                $business['license_id']      = trim($request->license_id);
                $business['country_code']    = trim($request->country_code);
                $business['mobile']          = trim($request->mobile);
                $business['start_time']      = trim($request->start_time);
                $business['end_time']        = trim($request->end_time);
                $business['slot_interval']   = trim($request->slot_interval);
                $business['address']         = trim($request->city_town);
                $business['marchent_email']  = trim($request->marchent_email);
                $business['latitude']        = trim($request->latitude);
                $business['longitude']       = trim($request->longitude);
				$business['description']     = trim($request->description);
				$business['business_for']    = trim($request->business_for);
				$business['experience']      = trim($request->experience);
				
				$business['city_town']       = trim($request->city_town);
				$business['street_name']     = trim($request->street_name);
				$business['land_mark']       = trim($request->land_mark);
				$business['area']            = trim($request->area);
               
                $res = $business->save();
                if($res)
                {
                    return response()->json([
                        'status'  => 1,
                        'message' => 'Business Profile updated successfully',
                    ]);
                }else{
                    return response()->json([
                        'status'  => 0,
                        'message' => 'Please try again!'
                    ]);
                }                
        }
    }

    //get business profile
    public function getBusinessprofile(Request $request)
    {
        if ($request['user_id']=='') {
             return response()->json(['status' => 0, 'message'=>'User id required'], 200);
        }

       $user_id =  $request['user_id'];

        $business = Business_profiles::where(['user_id'=>$user_id,'status'=>1])->first();
        if(!empty($business))
        {
            return response()->json([
                'status'  => 1,
                'message' => 'success',
				'image_url'   => url('public/photos'),
                'response'=> array('data' => $business),
            ]);
        }else{
            return response()->json(['status' => 0, 'message'=>'Business profile not found'], 200);
        }
    }

    //restaurant detail
    public function userResponse($user)
    {
        $response=array();
        $img='';
        if($user->image!='')
        {
            $img = url('public/photos/'.$user->image);
        }
        $response['id']               = $user->id ? $user->id : '';
        $response['first_name']       = $user->first_name ? $user->first_name : '';
        $response['last_name']        = $user->last_name ? $user->last_name : '';
        $response['mobile']           = $user->mobile ? $user->mobile : '';       
        $response['email']            = $user->email ? $user->email : '';
        $response['service_type']     = $user->service_type ? $user->service_type : '';
        $response['fcm_token']        = $user->fcm_token ? $user->fcm_token : '';
        $response['latitude']         = $latitude  = $user->latitude ? $user->latitude : '';
        $response['longitude']        = $longitude = $user->longitude ? $user->longitude : '';
        $response['about_me']         = $user->aboutme ? $user->aboutme : '';
        $response['otp']              = $user->otp ? $user->otp : '';
		$response['role']             = $user->role ? $user->role : '';
		$response['country_code']     = $user->country_code ? $user->country_code : '';
        $response['profile_image']    = $img;
		$response['is_verify']        = $user->is_verify;
        return $response;
    }

    
		
	

    //forgot password
    public function forgotPassword(Request $request)
    {

        $validator = Validator::make($request->all(), [      
            'mobile'       => 'required',
			'country_code' => 'required'      
        ]); 

        if ($validator->fails()) {
             return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
        }

        $mobile       = $request['mobile'];
		$country_code = $request['country_code'];
        $udata = User::where(['mobile'=>$mobile,'role'=>2,'country_code'=>$country_code])->first();
        if(!empty($udata))
        {
            $otp = mt_rand(1000,9999);
            $msg    = "Welcome :\n Your one time Password is : ".$otp;
            $udata->otp = $otp;
            $res = $udata->save(); 
            if($res)
            {
                $this->send_message($msg,$mobile,$country_code);

                 return response()->json([
                    'status'  => 1,
                    'message' => 'Please verify otp',
                    'response'=> array('data' => $this->userResponse($udata)),
                ]);
            }else{
                return response()->json([
                    'status'  => 0,
                    'message' => 'Please try again.'
                ], 200);
            }
            
        }else{
                return response()->json([
                    'status'  => 0,
                    'message' => 'Mobile number not exist.Please enter registered mobile number'
                ], 200);
            }
         
    }
	
	public function resendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [      
            'mobile'       => 'required',
			'country_code' => 'required'      
        ]); 

        if ($validator->fails()) {
             return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
        }

        $mobile       = $request['mobile'];
		$country_code = $request['country_code'];

        $udata = User::where(['mobile'=>$mobile,'country_code'=>$country_code])->first();
        if(!empty($udata))
        {
            $otp = rand(1000,9999);
            $msg    = "Welcome :\n Your one time Password is : ".$otp;
            $udata->otp = $otp;
            $res = $udata->save();
            $this->send_message($msg,$mobile,$country_code);
            if($res)
            {
                 return response()->json([
                    'status'  => 1,
                    'message' => 'Please verify otp',
                    'response'=> array('data' => $this->userResponse($udata)),
                ]);
            }else{
                return response()->json([
                    'status'  => 0,
                    'message' => 'Please try again.'
                ], 200);
            }
            
        }else{
                return response()->json([
                    'status'  => 0,
                    'message' => 'Mobile number not exist.Please enter registered mobile number'
                ], 200);
            }
         
    }

    //reset password
    public function resetPassword(Request $request)
    {

        $validator = Validator::make($request->all(), [      
            'user_id'      => 'required',      
            'new_password' => 'required',      
        ]); 

        if ($validator->fails()) {
             return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
        }

        $udata = User::where(['id'=>$request->user_id])->first();
        if(!empty($udata))
        {
            $udata->password = bcrypt(trim($request->new_password));
            $res = $udata->save();
            if($res)
            {
                 return response()->json([
                    'status'  => 1,
                    'message' => 'Password updated successfully'
                ]);
            }else{
                return response()->json([
                    'status'  => 0,
                    'message' => 'Please try again.'
                ], 200);
            }
            
        }else{
                return response()->json([
                    'status'  => 0,
                    'message' => 'Wrong user id'
                ], 200);
            }
         
    }

    

    //main services list
    public function getMainServiceList(Request $request)
    {
		
		$limit  = trim($request->limit);
		$offset = trim($request->offset);
		if($limit!=''){
			$limit  = trim($request->limit);
		}else{
			$limit  = 15;
		}
		if($offset!=''){
			$offset  = trim($request->offset);
		}else{
			$offset  = 0;
		} 
        $res = DB::table('main_services')
					->where('status',1)
					->orderBy('id','desc')
					->offset($offset)
				    ->limit($limit)
					->get();
        if(count($res)>0)
        {
          return response()->json([
              'status'  => 1,
              'message' => 'success',
			  'icon-url' => url('public/icons'),
              'response'=> array('data' => $res),
          ]);
        }else{
          return response()->json([
              'status'  => 0,
              'message' => 'Services not found!'
          ]);
        }
    }

    public function getMyTagsList(Request $request)
    {
        $user_id = $request['user_id'];
		$limit   = trim($request->limit);
		$offset  = trim($request->offset);
		if($limit!=''){
			$limit  = trim($request->limit);
		}else{
			$limit  = 15;
		}
		if($offset!=''){
			$offset  = trim($request->offset);
		}else{
			$offset  = 0;
		} 
        $res = DB::table('tags')
				->where(['user_id'=>$user_id,'status'=>0])
				->orderBy('id','desc')
				->offset($offset)
				->limit($limit)
				->get();
        if(count($res)>0)
        {
          return response()->json([
              'status'  => 1,
              'message' => 'success',
              'response'=> array('data' => $res),
          ]);
        }else{
          return response()->json([
              'status'  => 0,
              'message' => 'Tags not found!'
          ]);
        }
    }

    //size list
  public function getMyCustomerList(Request $request)
    { 
        $user_id = trim($request['user_id']);
		$search_key = trim($request['search_key']); 
		$limit   = $request['limit'];
		$offset  = $request['offset'];
		if($limit!=''){
			$limit  = trim($request->limit);
		}else{
			$limit  = 15;
		}
		if($offset!=''){
			$offset  = trim($request->offset);
		}else{
			$offset  = 0;
		}
      
     if($search_key!=''){
		 
		 $res = DB::table('users')
                    ->join('appointments', 'users.id', '=', 'appointments.customer_id')
                    ->where('appointments.service_provider_id',$user_id)
					->where('users.first_name','LIKE','%'.$search_key.'%')
					->groupBy('appointments.customer_id')
                    ->select('users.*')
					->offset($offset)
				    ->limit($limit)
                    ->get();
		 
	 }else{	  
        $res = DB::table('users')
                    ->join('appointments', 'users.id', '=', 'appointments.customer_id')
                    ->where('appointments.service_provider_id',$user_id)
					->groupBy('appointments.customer_id')
                    ->select('users.*')
					->offset($offset)
				    ->limit($limit)
                    ->get();
	 }
        if(count($res)>0)
        {
			foreach($res as $row){
				$uid = $row->id;
				$paidamt = DB::table('payments')
							->where('provider_id',$user_id)
							->where('customer_id',$uid)
							->where('pay_status',1)
							->sum('amount');
				$booking = DB::table('appointments')
							->where('customer_id',$uid)
							->where('service_provider_id',$user_id)
							->where('status',1)
							->count();
							
				$row->total_paid_amount = $paidamt;
				$row->total_booking     = $booking;
				$row->image             = url('public/photos/'.$row->image); 
			}
          return response()->json([
              'status'  => 1,
              'message' => 'success',
              'response'=> array('data' => $res),
          ]);
        }else{
          return response()->json([
              'status'  => 0,
              'message' => 'My user not found!'
          ]);
        }
    }

	public function getCustomerReviews(Request $request)
    {
        $user_id = $request['provider_id'];
		$limit = $request['limit'];
		$offset = $request['offset'];
		if($limit!=''){
			$limit  = trim($request->limit);
		}else{
			$limit  = 15;
		}
		if($offset!=''){
			$offset  = trim($request->offset);
		}else{
			$offset  = 0;
		} 
        $res = DB::table('reviews')
                    ->join('users', 'reviews.customer_id', '=', 'users.id')
                    ->where('reviews.provider_id',$user_id)
					->where('users.role',3)
                    ->select('users.image','users.first_name','users.last_name','reviews.*')
					->orderBy('reviews.id','desc')
					->offset($offset)
				    ->limit($limit)
                    ->get();
					
		 if(count($res)>0)
         {
			 foreach($res as $row){
				 if($row->image!=''){
				 $row->image =  url('public/photos/'.$row->image);
				 }else{
					 $row->image ="";
				 }
			 }
		  }				
					
        if(count($res)>0)
        {
          return response()->json([
              'status'  => 1,
              'message' => 'success',
              'response'=> array('data' => $res),
          ]);
        }else{
          return response()->json([
              'status'  => 0,
              'message' => 'Reviews not found!'
          ]);
        }
    }


    public function addTag(Request $request)
    {
        $validator = Validator::make($request->all(), [      
            'user_id' => 'required',      
            'tag_name'  => 'required'
        ]); 

        if ($validator->fails()) {
             return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
        }

        $tag_name = trim($request['tag_name']);
        $user_id = trim($request['user_id']);

        $check = DB::table('tags')
                    ->where('tag_name',$tag_name)
					->where('user_id',$user_id)
                    ->first();
         if($check!='')
         {
             return response()->json([
                    'status'  => 0,
                    'message' => 'Tag name alredy exist!'
                ], 200);

         } else{
            
			$tag = new Tag;
			$tag->tag_name = $tag_name;
			$tag->user_id  = $user_id;
			$res = $tag->save ();

           return response()->json([
                    'status'  => 1,
                    'message' => 'Tag saved successfully!',
					'response'=> array('data'=>$tag->id)
                ], 200);

         }   
            
    } 
	
	
	public function updateTag(Request $request)
    {
        $validator = Validator::make($request->all(), [      
            'tag_id' => 'required',
			'user_id' => 'required',      
            'tag_name'  => 'required'
        ]); 

        if ($validator->fails()) {
             return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
        }

        $tag_name = trim($request['tag_name']);
        $user_id = trim($request['user_id']);
		$tag_id = trim($request['tag_id']);

        $check = DB::table('tags')
                    ->where('tag_name',$tag_name)
					->where('user_id',$user_id)
					->where('id','!=',$tag_id)
                    ->first();
         if($check!='')
         {
             return response()->json([
                    'status'  => 0,
                    'message' => 'Tag name alredy exist!'
                ], 200);

         } else{

           $res = DB::table('tags')
						->where('id', $tag_id)
						->update(['tag_name' => $tag_name]);
				
           return response()->json([
                    'status'  => 1,
                    'message' => 'Tag updated successfully!'
                ], 200);

         }   
            
    }
	
	public function deleteTag(Request $request)
    {
        $validator = Validator::make($request->all(), [      
            'tag_id' => 'required'
        ]); 

        if ($validator->fails()) {
             return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
        }
		$tag_id = trim($request['tag_id']);

        $res = DB::table('tags')
						->where('id', $tag_id)
						->update(['status' =>1]);
         if($res)
         {
             return response()->json([
                    'status'  => 1,
                    'message' => 'Tag deleted successfully!'
                ], 200);

         } else{
           return response()->json([
                    'status'  => 0,
                    'message' => 'Please try again.'
                ], 200);

         }   
            
    }

    public function getAppointmentRequest(Request $request)
    {
        $user_id = trim($request['user_id']);
		$limit = $request['limit'];
		$offset = $request['offset'];
		if($limit!=''){
			$limit  = trim($request->limit);
		}else{
			$limit  = 15;
		}
		if($offset!=''){
			$offset  = trim($request->offset);
		}else{
			$offset  = 0;
		} 

        $res = DB::table('appointments')
                    ->leftjoin('users', 'appointments.customer_id', '=', 'users.id')
                    ->leftjoin('services', 'appointments.service_id', '=', 'services.id')
                    ->select('appointments.*','services.service_name','users.first_name','users.last_name')
                    ->where('appointments.service_provider_id',$user_id)
					->orderBy('appointments.id','desc')
					->offset($offset)
				    ->limit($limit)
                    ->get();
         if(count($res)>0)
         {
             return response()->json([
                    'status'  => 1,
                    'message' => 'success',
                    'response'=> array('data' => $res),
                ], 200);

         } else{

           return response()->json([
                    'status'  => 0,
                    'message' => 'No appointments!'
                ], 200);

         }   
            
    }

    //update product  
    public function contactUs(Request $request)
    {
        $validator = Validator::make($request->all(), [      
            'user_id' => 'required',
			'name'    => 'required',      
            'email'   => 'required',      
            'contact' => 'required',    
            'subject' => 'required',
            'message' => 'required',
			'country_code' => 'required',
            'location'=> 'required'       
        ]); 

        if ($validator->fails()) {
             return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
        }

        $name       = trim($request['name']);
		$type       = trim($request['type']);
		$user_id    = trim($request['user_id']);
        $email      = trim($request['email']);
        $contact    = trim($request['contact']);
        $subject    = trim($request['subject']);
        $message    = trim($request['message']);
        $location   = trim($request['location']);
		$country_code   = trim($request['country_code']);

        $res =  DB::table('contact_us')->insert(
                    ['user_id' =>$user_id,'name' =>$name, 'email' => $email, 'contact' => $contact, 'subject' => $subject, 'message' => $message, 'location' => $location, 'type' => $type, 'country_code' => $country_code]
                );
        if($res){
             return response()->json([
                    'status'  => 1,
                    'message' => 'Your details saved successfully.'
                ], 200);
        }else{
            return response()->json([
                    'status'  => 0,
                    'message' => 'Some thing went wrong!'
                ], 200);
        }

   
    }

    //save gallery images 
    public function saveImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'  => 'required', 
            'image'    => 'required|image|mimes:jpg,png,gif,jpeg',
            [ 
                'image.mimes' => 'Images must have format (JPEG, PNG, JPG, GIF)',
                'image.max' => 'Image size not greater than 1 MB' 
            ] 
        ]);

        if($validator->fails())
        {
            return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
        }

        $user_id = trim($request['user_id']);

        $inst = new Gallery;
        $inst->user_id    = $user_id;

        $image = $request->file('image');
        $imagename = time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/gallery');
        $image->move($destinationPath, $imagename);
        $inst->image = $imagename;

        $res = $inst->save();
        if($res)
        {
            return response()->json([
                'status'  => 1,
                'message' => 'Image added successfully'
            ]);
        }else{
            return response()->json([
                'status'  => 0,
                'message' => 'Please try again!'
            ], 200);
        }   
    }

    //gallery list
    public function galleryImages(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
        }

        $res = Gallery::select('id','image')->where(['status'=>1,'user_id'=>$request->user_id])->orderBy('id','desc')->get();
        if(count($res)>0)
        {
            foreach($res as $p)
            {
                $p->image = url('public/gallery/'.$p->image);
            }

            return response()->json([
                'status'  => 1,
                'message' => 'success',
                'response'=> array('data' => $res),
            ]);
        }else{
            return response()->json([
                'status'  => 0,
                'message' => 'Images not found!'
            ], 200);
        }
    }

    //delete images 
    public function deleteImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image_id' => 'required',
			'user_id' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
        }

        $pdata = Gallery::where('id',$request->image_id)->where('user_id',$request->user_id)->first();
        $res='';
        if(!empty($pdata))
        {
             $img = $pdata->image;
             $res = $pdata->delete();
        }
       
        if($res)
        {
            if($img!='')
            {
                unlink(public_path('/gallery/'.$img));
            }

            return response()->json([
                'status'  => 1,
                'message' => 'Image deleted successfully'
            ]);
        }else{
            return response()->json([
                'status'  => 0,
                'message' => 'Please try again!'
            ], 200);
        }
    }

    //delete product 
    public function deletemultiImages(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image_ids' => 'required',
			'user_id' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
        }

        $ids = $request['image_ids'];
        if($ids!='')
        {
            $idArry = explode(',', $ids);
        }

        $count=0;
        foreach($idArry as $id)
        {
            $pdata = Gallery::where('id',$id)->where('user_id',$request->user_id)->first();
            if(!empty($pdata))
            {
                $img = $pdata->image;
                $res = $pdata->delete();

                if($res)
                {
                    if($img!='')
                    {
                        unlink(public_path('/gallery/'.$img));
                    }
                }
                $count++;
            }
            
        }
        
        if($count)
        {
            return response()->json([
                'status'  => 1,
                'message' => 'Image deleted successfully'
            ]);
        }else{
            return response()->json([
                'status'  => 0,
                'message' => 'Please try again!'
            ], 200);
        }
    }

    //logout
    public function logout(Request $request)
    {
        return response()->json([
            'status'  => 1,
            'message' => 'Successfully logged out.'
            ]);
    }

 public function getMyServicesList(Request $request)
    {
        $user_id = $request['user_id'];
		$limit = $request['limit'];
		$offset = $request['offset'];
		if($limit!=''){
			$limit  = trim($request->limit);
		}else{
			$limit  = 15;
		}
		if($offset!=''){
			$offset  = trim($request->offset);
		}else{
			$offset  = 0;
		} 
        $res = Service::where('user_id',$user_id)
					  ->where('is_delete',0)
					  ->orderBy('id','desc')
					  ->offset($offset)
				      ->limit($limit)
                      ->get();
        if(count($res)>0)
        {
			foreach($res as $row){
				if($row->image==''){
					$row->image = url('public/adminassets/img/mmh.png');
				}else{
					$row->image = url('public/service_images/'.$row->image);
				}
				if($row->image_1==''){
					$row->image_1 = url('public/adminassets/img/mmh.png');
				}else{
					$row->image_1 = url('public/service_images/'.$row->image_1);
				}
				if($row->image_2==''){
					$row->image_2 = url('public/adminassets/img/mmh.png');
				}else{
					$row->image_2 = url('public/service_images/'.$row->image_2);
				}
			}
			
          return response()->json([
              'status'  => 1,
              'message' => 'success',
			  'image-url' => url('public/service_images/'),
              'response'=> array('data' => $res),
          ]);
        }else{
          return response()->json([
              'status'  => 0,
              'message' => 'Services not found!'
          ]);
        }
    }

 public function addService(Request $request)
    {
        $validator = Validator::make($request->all(), [
			'user_id'            => 'required',
			'service_name'       => 'required',
            'service_for_man'    => 'required',
			'service_for_women'  => 'required',
			/* 'duration_for_man'   => 'required',
			'duration_for_women' => 'required',    
			'service_cost_for_man'   => 'required',
			'service_cost_for_women' => 'required', */        
            'service_days'       => 'required',  
            'service_tag'        => 'required',        
            'description'        => 'required',
            'image'              => 'mimes:jpeg,jpg,gif,png|required'
        ]); 
        if ($validator->fails()) 
		{
             return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
			 
        }else{

               $srvcheck = Service::where('service_name', trim($request->service_name))->where('user_id', trim($request->user_id))->first();
               if(!empty($srvcheck))
               {  
                   return response()->json(['status' => 0, 'message'=>'Service name already exist'], 200);
               }  
			   
			   $service_days = trim($request->service_days);
			   $servicedays  = explode(',',$service_days);

		   $srv = new Service;
		   $srv->user_id                = trim($request->user_id);
		   $srv->service_name           = ucwords(trim($request->service_name));
		   $srv->service_for_man        = trim($request->service_for_man); 
		   $srv->service_for_women      = trim($request->service_for_women);
		   $srv->duration_for_man       = trim($request->duration_for_man);
		   $srv->duration_for_women     = trim($request->duration_for_women);
		   $srv->service_cost_for_man   = trim($request->service_cost_for_man);
		   $srv->service_cost_for_women = trim($request->service_cost_for_women); 
		   $srv->sunday                 = $servicedays[0];
		   $srv->monday                 = $servicedays[1];
		   $srv->tuesday                = $servicedays[2];
		   $srv->wednesday              = $servicedays[3];
		   $srv->thursday               = $servicedays[4];
		   $srv->friday                 = $servicedays[5];
		   $srv->saturday               = $servicedays[6];
		   $srv->service_tag            = $request->service_tag;
		   $srv->description            = $request->description;
		   
		   if ($request->hasFile('image')) 
			{
			    $file = array('image' => Input::file('image'));
				$destinationPath = 'public/service_images/'; 
				$extension = Input::file('image')->getClientOriginalExtension(); 
				$fileName = date('m-d-Y_hia').rand(1,99999).'.'.$extension;
				Input::file('image')->move($destinationPath, $fileName);
				$srv->image = $fileName;
				
			}
			
			if ($request->hasFile('image_1')) 
			{
			    $file = array('image_1' => Input::file('image_1'));
				$destinationPath = 'public/service_images/'; 
				$extension = Input::file('image_1')->getClientOriginalExtension(); 
				$fileName = date('m-d-Y_hia').rand(1,99999).'.'.$extension;
				Input::file('image_1')->move($destinationPath, $fileName);
				$srv->image_1 = $fileName; 
			}
			if ($request->hasFile('image_2')) 
			{
			    $file = array('image_2' => Input::file('image_2'));
				$destinationPath = 'public/service_images/'; 
				$extension = Input::file('image_2')->getClientOriginalExtension(); 
				$fileName = date('m-d-Y_hia').rand(1,99999).'.'.$extension;
				Input::file('image_2')->move($destinationPath, $fileName);
				$srv->image_2 = $fileName; 
			}

		  $result = $srv->save();

                if($result)
				{
					return response()->json([
						'status'  => 1,
						'message' => 'Service has been saved successfully.',
						'response'=> array('data' => $result),
					]);
				}else{
						return response()->json([
						'status'  => 0,
						'message' => 'Please try again.'
					], 200);
				}
    } 
	
 }
 
 public function updateService(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_id'             => 'required',
			'user_id'                => 'required',
			'service_name'           => 'required',
            'service_for_man'        => 'required',
			'service_for_women'      => 'required',
			'duration_for_man'       => 'required',
			'duration_for_women'     => 'required',    
			'service_cost_for_man'   => 'required',
			'service_cost_for_women' => 'required',        
            'service_days'           => 'required',  
            'service_tag'            => 'required',        
            'description'            => 'required'
        ]); 
        if ($validator->fails()) 
		{
             return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
			 
        }else{

               $srvcheck = Service::where('service_name', trim($request->service_name))->where('user_id', trim($request->user_id))->where('id','!=', trim($request->service_id))->first();
               if(!empty($srvcheck))
               {  
                   return response()->json(['status' => 0, 'message'=>'Service name already exist'], 200);
               }  
			   
			   $service_id  = trim($request->service_id);
			   $service_days = trim($request->service_days);
			   $servicedays  = explode(',',$service_days);

		   $srv = Service::findOrFail($service_id);
		   
		   $srv->user_id                = trim($request->user_id);
		   $srv->service_name           = ucwords(trim($request->service_name));
		   $srv->service_for_man        = trim($request->service_for_man); 
		   $srv->service_for_women      = trim($request->service_for_women);
		   $srv->duration_for_man       = trim($request->duration_for_man);
		   $srv->duration_for_women     = trim($request->duration_for_women);
		   $srv->service_cost_for_man   = trim($request->service_cost_for_man);
		   $srv->service_cost_for_women = trim($request->service_cost_for_women); 
		   $srv->sunday                 = $servicedays[0];
		   $srv->monday                 = $servicedays[1];
		   $srv->tuesday                = $servicedays[2];
		   $srv->wednesday              = $servicedays[3];
		   $srv->thursday               = $servicedays[4];
		   $srv->friday                 = $servicedays[5];
		   $srv->saturday               = $servicedays[6];
		   $srv->service_tag            = $request->service_tag;
		   $srv->description            = $request->description;
		   
		   if ($request->hasFile('image')) 
			{
				if($srv->image!='')
				{
				    unlink('public/service_images/'.$srv->image);
				}
			    $file = array('image' => Input::file('image'));
				$destinationPath = 'public/service_images/'; 
				$extension = Input::file('image')->getClientOriginalExtension(); 
				$fileName = date('m-d-Y_hia').rand(1,99999).'.'.$extension;
				Input::file('image')->move($destinationPath, $fileName);
				$srv->image = $fileName;
				
			}
			
			if ($request->hasFile('image_1')) 
			{
				if($srv->image_1!='')
				{
				    unlink('public/service_images/'.$srv->image_1);
				}
			    $file = array('image_1' => Input::file('image_1'));
				$destinationPath = 'public/service_images/'; 
				$extension = Input::file('image_1')->getClientOriginalExtension(); 
				$fileName = date('m-d-Y_hia').rand(1,99999).'.'.$extension;
				Input::file('image_1')->move($destinationPath, $fileName);
				$srv->image_1 = $fileName; 
			}
			if ($request->hasFile('image_2')) 
			{
				if($srv->image_2!='')
				{
				    unlink('public/service_images/'.$srv->image_2);
				}
			    $file = array('image_2' => Input::file('image_2'));
				$destinationPath = 'public/service_images/'; 
				$extension = Input::file('image_2')->getClientOriginalExtension(); 
				$fileName = date('m-d-Y_hia').rand(1,99999).'.'.$extension;
				Input::file('image_2')->move($destinationPath, $fileName);
				$srv->image_2 = $fileName; 
			}

		  $result = $srv->save();

                if($result)
				{
					return response()->json([
						'status'  => 1,
						'message' => 'success',
						'response'=> array('data' => $result),
					]);
				}else{
						return response()->json([
						'status'  => 0,
						'message' => 'Please try again.'
					], 200);
				}
    } 
	
 }

 public function getServiceDetails(Request $request)
    {
        $user_id = trim($request['user_id']);
        $service_id  = trim($request['service_id']);
            
        $services = DB::table('services')
                    ->where('id',$service_id)
                    ->where('user_id',$user_id)
                    ->first();
                    
         if($services!="")
         {
             return response()->json([
                    'status'    => 1,
                    'message'   => 'Success',
                    'image_url' => url('public/photos'),
                    'response'  => array('data' => $services),
                ], 200);

         }else{

             return response()->json([
                    'status'  => 0,
                    'message' => 'Result not found!'
                ], 200);
        }     
    }
 
 public function deleteService(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_id'     => 'required'
        ]); 
        if ($validator->fails()) 
		{
             return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
			 
        }else{
			
		   $service_id = trim($request->service_id);
		   $srv = Service::findOrFail($service_id);
		   $srv->is_delete = 1 ;
		   $result = $srv->save();
			if($result)
			{
				return response()->json([
					'status'  => 1,
					'message' => 'Service deleted successfully',
				]);
			}else{
					return response()->json([
					'status'  => 0,
					'message' => 'Please try again.'
				], 200);
			}
    } 
	
 }
 
 public function checkAvailability(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'user_id'    => 'required',
			'a_date'     => 'required',
			'a_time'     => 'required'
			
        ]); 
        if ($validator->fails()) 
		{
             return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
			 
        }else{
			
		   $user_id = trim($request->user_id);
		   $a_date  = date("Y-m-d",strtotime(trim($request->a_date)));
		   $a_time  = trim($request->a_time);
		   
		   $avl = DB::table('my_vacations')
						   ->where('provider_id',$user_id)
						   ->where('from_date','<=',$a_date)
						   ->where('to_date','>=',$a_date)
						   ->get();
					   
		  $srv = DB::table('availabilities')
						   ->where('user_id',$user_id)
						   ->where('a_date',$a_date)
						   ->where('a_time',$a_time)
						   ->get();
			if(count($srv)>0)
			{
				return response()->json([
					'status'  => 2,
					'message' => 'Booked',
				]);
			}elseif(count($avl)>0){
					return response()->json([
					'status'  => 0,
					'message' => 'Unavailable',
				], 200);
			}else{
				return response()->json([
					'status'  => 1,
					'message' => 'Available',
				], 200);
			}
			
			
    } 
	
 }
 
 public function addVacations(Request $request)
    {
        $validator = Validator::make($request->all(), [      
            'provider_id' => 'required',      
            'from_date'  => 'required',
			'to_date'  => 'required'
        ]); 

        if ($validator->fails()) {
             return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
        }

        $from_date   = date("Y-m-d",strtotime(trim($request['from_date'])));
		$to_date     = date("Y-m-d",strtotime(trim($request['to_date'])));
        $provider_id = trim($request['provider_id']);

        $check = DB::table('my_vacations')
                    ->where('provider_id',$provider_id)
					->where('from_date',$from_date)
					->where('to_date',$to_date)
                    ->first();
         if($check!='')
         {
             return response()->json([
                    'status'  => 0,
                    'message' => 'Vacation alredy exist!'
                ], 200);

         } else{

           $res = DB::table('my_vacations')->insert(
                    ['from_date' =>$from_date, 'provider_id' => $provider_id, 'to_date' => $to_date]
                );
			if($res){

				return response()->json([
						'status'  => 1,
						'message' => 'Vacation saved successfully!'
					], 200);
			}else{
				 return response()->json([
                    'status'  => 0,
                    'message' => 'Please try again.'
                ], 200);
			}

         }   
            
    }
	
	public function updateVacations(Request $request)
    {
        $validator = Validator::make($request->all(), [      
            'vacation_id' => 'required',
			'provider_id' => 'required',      
            'from_date'   => 'required',
			'to_date'     => 'required'
        ]); 

        if ($validator->fails()) {
             return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
        }
		
		$from_date   = date("Y-m-d",strtotime(trim($request['from_date'])));
		$to_date     = date("Y-m-d",strtotime(trim($request['to_date'])));
        $provider_id = trim($request['provider_id']);
		$vacation_id = trim($request['vacation_id']);
		
		if ($from_date > $to_date) {
             return response()->json(['status' => 0, 'message'=>'From date greater than to date.'], 200);
        }

        

        $check = DB::table('my_vacations')
                    ->where('id',$vacation_id)
					->where('provider_id',$provider_id)
                    ->first();
         if($check!='')
         {
			 
			  $res =  DB::table('my_vacations')
                    ->where('id', $vacation_id)
                    ->update(['from_date' =>$from_date, 'provider_id' => $provider_id, 'to_date' => $to_date]);
		  
			

				return response()->json([
						'status'  => 1,
						'message' => 'Vacation update successfully!',
					], 200);
            

         } else{

            return response()->json([
                    'status'  => 0,
                    'message' => 'Vacation id not found !'
                ], 200);

         }   
            
    }
	
	public function deleteVacations(Request $request)
    {
        $validator = Validator::make($request->all(), [      
            'vacation_id' => 'required',
			'provider_id' => 'required'
        ]); 

        if ($validator->fails()) {
             return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
        }
        $provider_id = trim($request['provider_id']);
		$vacation_id = trim($request['vacation_id']);

        $res = DB::table('my_vacations')
                    ->where('id',$vacation_id)
					->where('provider_id',$provider_id)
                    ->delete();
		  
			if($res){

				return response()->json([
						'status'  => 1,
						'message' => 'Vacation deleted successfully!'
					], 200);
			}else{
				 return response()->json([
                    'status'  => 0,
                    'message' => 'Please try again.'
                ], 200);
			}
 
    }
	
	public function getVacationList(Request $request)
    {
        $validator = Validator::make($request->all(), [      
            'provider_id' => 'required'
        ]); 

        if ($validator->fails()){
             return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
        }

        $provider_id = trim($request['provider_id']);
		$limit  = trim($request['limit']);
		$offset = trim($request['offset']);
		if($limit!=''){
			$limit  = trim($request->limit);
		}else{
			$limit  = 15;
		}
		if($offset!=''){
			$offset  = trim($request->offset);
		}else{
			$offset  = 0;
		}  

        $res = DB::table('my_vacations')
                     ->where('provider_id',$provider_id)
					 ->orderBy('id','desc')
					 ->offset($offset)
				     ->limit($limit)
					 ->orderBy('id','DESC')
                     ->get();
         if(count($res)>0)
         {
             return response()->json([
					'status'  => 1,
					'message' => 'Success',
					'response'=> array('data' => $res),
				], 200);

         }else{

          return response()->json([
                    'status'  => 0,
                    'message' => 'Vacation not found!'
                ], 200);
         }   
            
    } 
	
	
	public function getPaymentHistry(Request $request)
    {
      
        $provider_id = trim($request['provider_id']);
        $limit  = trim($request['limit']);
		$offset = trim($request['offset']);
		if($limit!=''){
			$limit  = trim($request->limit);
		}else{
			$limit  = 15;
		}
		if($offset!=''){
			$offset  = trim($request->offset);
		}else{
			$offset  = 0;
		}

        $res = DB::table('payments')
		            ->join('users', 'payments.customer_id', '=', 'users.id')
					->where('payments.provider_id',$provider_id)
					->select('payments.*','users.first_name','users.last_name','users.image')
					->orderBy('payments.id','desc')
					->offset($offset)
				    ->limit($limit)
                    ->get();
		 if(count($res)>0)
         {
			 foreach($res as $row){
				 if($row->image!=''){
				 $row->image =  url('public/photos/'.$row->image);
				 }else{
					 $row->image ="";
				 }
			 }
		  }				
         if(count($res)>0)
         {
             return response()->json([
                    'status'    => 1,
                    'message'   => 'Success',
					'response' => array('data' => $res),
                ], 200);

         }else{

			 return response()->json([
                    'status'  => 0,
                    'message' => 'Result not found!'
                ], 200);
		}
            
    }
	
	public function getBreakTimeList(Request $request)
    {
        $provider_id        = trim($request['provider_id']);
        $limit  = trim($request['limit']);
		$offset = trim($request['offset']);
		if($limit!=''){
			$limit  = trim($request->limit);
		}else{
			$limit  = 15;
		}
		if($offset!=''){
			$offset  = trim($request->offset);
		}else{
			$offset  = 0;
		}
        $res = Break_time::where('provider_id',$provider_id)
		              ->offset($offset)
				      ->limit($limit)
					  ->orderBy('id','DESC')
		              ->get();
         if(count($res)>0)
         {
             return response()->json([
                    'status'    => 1,
                    'message'   => 'Success',
					'response' => array('data' => $res),
                ], 200);

         }else{
			 return response()->json([
                    'status'  => 0,
                    'message' => 'Result not found!'
                ], 200);
		}
            
    }
	
	public function addBreakTime(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
			'provider_id'       => 'required',      
            'start_break_time'  => 'required',
			'end_break_time'    => 'required'
        ]); 

        if ($validator->fails()) {
             return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
        }

        $start_break_time   = trim($request['start_break_time']);
        $end_break_time     = trim($request['end_break_time']);
		$provider_id        = trim($request['provider_id']);

        $check = Break_time::where('provider_id',$provider_id)
							->where('start_break_time',$provider_id)
							->where('end_break_time',$provider_id)
							->first();
         if($check!='')
         {
             return response()->json([
                    'status'  => 0,
                    'message' => 'This break time already exist.'
                ], 200);

         }else{
				$break = new Break_time;
				$break->provider_id      = $provider_id;
				$break->start_break_time = $start_break_time;
				$break->end_break_time   = $end_break_time;
				$res = $break->save();
				if($res){
					
					return response()->json([
							'status'  => 1,
							'message' => 'Break time saved successfully.',
							'response'=> array('data'=>'true')
						], 200);
				}else{
					  return response()->json([
							'status'  => 0,
							'message' => 'Please try again!'
						], 200);
				}
			 
		}
            
    }
	
	public function updateBreakTime(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
			'break_time_id'     => 'required',
			'provider_id'       => 'required',      
            'start_break_time'  => 'required',
			'end_break_time'    => 'required'
        ]); 

        if ($validator->fails()) {
             return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
        }

        $break_time_id      = trim($request['break_time_id']);
		$start_break_time   = trim($request['start_break_time']);
        $end_break_time     = trim($request['end_break_time']);
		$provider_id        = trim($request['provider_id']);

        $check = Break_time::where('provider_id',$provider_id)
							->where('id','!=',$break_time_id)
							->where('start_break_time',$provider_id)
							->where('end_break_time',$provider_id)
							->first();
         if($check!='')
         {
             return response()->json([
                    'status'  => 0,
                    'message' => 'This break time already exist.'
                ], 200);

         }else{
				$break = Break_time::find($break_time_id);
				$break->provider_id      = $provider_id;
				$break->start_break_time = $start_break_time;
				$break->end_break_time   = $end_break_time;
				$res = $break->save();
				if($res){
					
					return response()->json([
							'status'  => 0,
							'message' => 'Break time updated successfully.',
							'response'=> array('data'=>'true')
						], 200);
				}else{
					  return response()->json([
							'status'  => 0,
							'message' => 'Please try again!'
						], 200);
				}
			 
		}
            
    }
	
	public function deleteBreakTime(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
			'break_time_id'     => 'required',
			'provider_id'       => 'required'
        ]); 

        if ($validator->fails()) {
             return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
        }

        $break_time_id      = trim($request['break_time_id']);
		$provider_id        = trim($request['provider_id']);

        $check = Break_time::where('provider_id',$provider_id)
							->where('id',$break_time_id)
							->delete();
         if($check)
         {
            return response()->json([
							'status'  => 0,
							'message' => 'Break time deleted successfully.',
							'response'=> array('data'=>'true')
						], 200);

         }else{
				return response()->json([
						'status'  => 0,
						'message' => 'Please try again!'
					], 200);
				
		}
            
    }
	
	public function acceptRejectAppointmentRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'appointment_id'   => 'required',
            'provider_id'      => 'required',
			'status'           => 'required'
        ]);

        if($validator->fails())
       {
           return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
       }
	   
	   $id = trim($request->appointment_id);
	   $provider_id = trim($request->provider_id);
	   $status = trim($request->status);

        $app = DB::table('appointments')
						->where('id', $id)
						->where('service_provider_id', $provider_id)
						->first(); 
        if(!$app)
        {
            return response()->json([ 
                'status'  => 0,
                'message' => 'Appointment request not found.'
            ], 200);
        }else{
			
			  $customer_id = $app->customer_id;	
			  $customer = DB::table('users')->where('id', $customer_id)->first();
			  $mobile   = $customer->mobile; 
			  $phonecode   = $customer->country_code; 
							
				if($status==1)
				{
					$resut =  DB::table('appointments')
							->where('id', $id)
							->where('service_provider_id', $provider_id)
							->update(['appointment_status' => $status]);
							
					$msg  = "Welcome :\n Your appointment ".$app->appointment_no." has been accepted.";
					$message = 'Appointment has been accepted successfully';
					
					      $not = new Notification;
						  $not->provider_id    = $provider_id;
						  $not->customer_id    = $customer_id;
						  $not->appointment_id = $id;
						  $not->type           = 2;
						  $not->title          = "Appointment Accepted";
						  $not->message        = "Your appointment request has been accepted.";
						  $resnot = $not->save();
					
					
				}else{
					$resut =  DB::table('appointments')
							->where('id', $id)
							->where('service_provider_id', $provider_id)
							->update(['appointment_status' => $status,'status' => $status]);
					
					$msg  = "Welcome :\n Your appointment ".$app->appointment_no." has been rejected.";
					$message = 'Appointment has been rejected successfully';
					
					      $not = new Notification;
						  $not->provider_id    = $provider_id;
						  $not->customer_id    = $customer_id;
						  $not->appointment_id = $id;
						  $not->type           = 2;
						  $not->title          = "Appointment Rejected";
						  $not->message        = "Your appointment request has been rejected.";
						  $resnot = $not->save();
				}	
               $appontment =  DB::table('appointments')
							->where('id', $id)
							->first();
					
			  $this->send_message($msg,$mobile,$phonecode);
			  
			  return response()->json([ 
                'status'  => 1,
                'message' => $message,
				'response'=> array('data'=>$appontment)
            ], 200);
			  
		}
		
	}
	
	 public function completeAppointment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'appointment_id'   => 'required',
            'provider_id'      => 'required'
        ]);

        if($validator->fails())
       {
           return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
       }
	   
	   $id = trim($request->appointment_id);
	   $provider_id = trim($request->provider_id);
	   $status = trim($request->status);

        $app = DB::table('appointments')
						->where('id', $id)
						->where('service_provider_id', $provider_id)
						->first(); 
        if(!$app)
        {
            return response()->json([ 
                'status'  => 0,
                'message' => 'Appointment request not found.'
            ], 200);
        }else{
			
			  $service_id   = $app->service_id;
			  $service_type = $app->service_type;
			  $customer_id  = $app->customer_id;
			  $inv_no       = $app->appointment_no;
			  
			  $service = DB::table('services')
						->where('id', $service_id)
						->first();
			  $invoice = DB::table('invoices')
						->where('invoice_no', $inv_no)
						->first();
			
			  $result =  DB::table('appointments')
							->where('id', $id)
							->where('service_provider_id', $provider_id)
							->update(['status' => 1,'appointment_status' => 1]);
							
				if($service_type==1)
				{
					$amount = $service->service_cost_for_man;
				}else{
					$amount = $service->service_cost_for_women;
				}			
							
				$inv = new Invoice;
				$inv->invoice_no    = $inv_no;
				$inv->service_name  = $service->service_name;
				$inv->provider_id   = $provider_id;
				$inv->customer_id   = $customer_id;
				$inv->service_id    = $service_id;
				$inv->amount        = $amount;
				$inv->invoice_date  = date('Y-m-d');
				
				if($invoice=='')
				{
				  $inv_res = $inv->save();
				}
				
				  if($result)
				  {
					      $not = new Notification;
						  $not->provider_id    = $provider_id;
						  $not->customer_id    = $customer_id;
						  $not->appointment_id = $id;
						  $not->type           = 2;
						  $not->title          = "Appointment Completed";
						  $not->message        = "Your appointment has been completed.";
						  $resnot = $not->save();
					  
					   return response()->json([ 
								'status'  => 1,
								'message' => 'Appointment has been completed successfully.'
							], 200);
				  }else{
						  return response()->json([ 
							'status'  => 0,
							'message' => 'Appointment has been already completed.'
						], 200);
				  }
			  
		}
		
	}
	
	
	public function getAppointmentsHistory(Request $request) 
    {
        $validator = Validator::make($request->all(), [
			'provider_id'   => 'required',
			'type'          => 'required',
        ]); 
        if ($validator->fails()) 
		{
             return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
			 
        }else{
		    $limit  = trim($request['limit']);
			$offset = trim($request['offset']);
			if($limit!=''){
				$limit  = trim($request->limit);
			}else{
				$limit  = 15;
			}
			if($offset!=''){
				$offset  = trim($request->offset);
			}else{
				$offset  = 0;
			}

		   $provider_id = trim($request->provider_id);
		   $type        = trim($request->type);
		   
		   $res = DB::table('appointments')
		                   ->leftjoin('services', 'appointments.service_id', '=', 'services.id')
						   ->leftjoin('business_profiles', 'appointments.service_provider_id', '=', 'business_profiles.user_id')
						   ->where('appointments.service_provider_id',$provider_id);
						   if($type==3){
							  $res->where('appointments.status',1);
						   }else{
							   $res->where('appointments.appointment_status',$type);
						   }
						   
						  $app = $res->select('appointments.*','services.service_name','services.image as service_image','services.duration_for_man','services.duration_for_women','services.service_for_man','services.service_for_women','services.service_cost_for_man','services.service_cost_for_women','business_profiles.business_name')
						   ->offset($offset)
					       ->limit($limit)
						   ->orderBy('appointments.id','DESC')
						   ->get();
			if(count($app)>0)
			{
				
				foreach($app as $row){
				 $row->customer_name='';
				 if($row->customer_id)
				 {
				 	$user = DB::table('users')->where('id',$row->customer_id)->first();
				 	$row->customer_name = $user->first_name.' '.$user->last_name;
				 }
				 if($row->appointment_status==1){
				 $row->appointment_status = "Accepted";
				 }elseif($row->appointment_status==2){
					 $row->appointment_status = "Rejected";
				 }else{
					 $row->appointment_status = "Pending";
				 }
				 
				 if($row->status==1){
				 $row->status = "Completed";
				 }elseif($row->status==2){
					 $row->status = "Canceled";
				 }else{
					 $row->status = "Pending";
				 }
				 
				 if($row->service_image!=''){
				    $row->service_image =  url('public/service_images/'.$row->service_image);
				 }else{
					 $row->service_image = '';
				 }
			 }
				
				return response()->json([
					'status'  => 1,
					'message' => 'Success',
					'data' => $app,
				], 200);
			}else{
				
				return response()->json([
                    'status'  => 0,
                    'message' => 'Result not found!'
                ], 200);
					
			}
    } 
	
 }
 
 public function PayCashPayment(Request $request) 
    {
        $validator = Validator::make($request->all(), [
			'provider_id'   => 'required',
			'appointment_id'=> 'required',
			'customer_id'   => 'required',
			'amount'        => 'required',
			'pay_date'      => 'required'
        ]); 
        if ($validator->fails()) 
		{
             return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
			 
        }else{
		   
		   $provider_id    = trim($request->provider_id);
		   $customer_id    = trim($request->customer_id);
		   $appointment_id = trim($request->appointment_id);
		   
		   $pay = new Payment;
		   $pay->provider_id    = trim($request->provider_id);
		   $pay->appointment_id = trim($request->appointment_id);
		   $pay->customer_id    = trim($request->customer_id);
		   $pay->amount         = trim($request->amount);
		   $pay->pay_mode       = "Cash";
		   $pay->transaction_id = "Cash Payment";
		   $pay->pay_date       = date("Y-m-d",strtotime(trim($request->pay_date)));
		   $pay->pay_status     = 1;
		   $res = $pay->save();
		   if($res){
					  $not = new Notification;
					  $not->provider_id    = $provider_id;
					  $not->customer_id    = $customer_id;
					  $not->appointment_id = $appointment_id;
					  $not->type           = 2;
					  $not->title          = "Completed appointment payment";
					  $not->message        = "Your appointment payment has been completed.";
					  $resnot = $not->save();
			   
			   return response()->json([
					'status'  => 1,
					'message' => 'Payment details has been saved successfully.',
				], 200);
		   }else{
			   return response()->json([
					'status'  => 0,
					'message' => 'Please try again.'
				], 200);
		   }
    } 
	
 }
 
 public function getNotificationList(Request $request) 
    {
        $validator = Validator::make($request->all(), [
			'provider_id' => 'required',
        ]); 
		
		$limit  = trim($request['limit']);
		$offset = trim($request['offset']);
		if($limit!=''){
			$limit  = trim($request->limit);
		}else{
			$limit  = 15;
		}
		if($offset!=''){
			$offset  = trim($request->offset);
		}else{
			$offset  = 0;
		}
		
        if ($validator->fails()) 
		{
             return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
			 
        }else{
		   
		   $provider_id    = trim($request->provider_id);
		   
		   $result = DB::table('notifications')
						->leftjoin('users','notifications.customer_id','=','users.id')
						->where('notifications.type',1)
						->where('notifications.provider_id',$provider_id)
						->select('notifications.*','users.first_name','users.last_name','users.image')
						->orderBy('notifications.id','desc')
						->offset($offset)
						->limit($limit)
						->get();
		   if(count($result)>0)
		   {
				 foreach($result as $row){
					 if($row->image!=''){
					 $row->image =  url('public/photos/'.$row->image);
					 }else{
						 $row->image ="";
					 }
				 }
		   
			   return response()->json([
					'status'  => 1,
					'message' => 'success',
					'data'    => $result,
				], 200);
		   }else{
			   return response()->json([
					'status'  => 0,
					'message' => 'Notification not found.'
				], 200);
		   }
    } 
	
 }
	

    //end class
}