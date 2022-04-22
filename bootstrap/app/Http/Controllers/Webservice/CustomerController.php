<?php

namespace App\Http\Controllers\Webservice;

use Illuminate\Support\Facades\Auth;
use AfricasTalking\SDK\AfricasTalking;
use Illuminate\Http\Request;
use App\Model\Business_profiles;
use App\Model\Service_image;
use App\Model\Availability;
use App\Helpers\Helper;
use App\Model\Gallery;
use App\Model\Country;
use App\Model\Service;
use App\Model\My_vacation;
use App\Model\Payment;
use App\Model\Appointment;
use App\Model\Notification;
use Carbon\Carbon;
use Validator;
use App\User;
use Excel;
use PDF;
use DB;
use Input;
class CustomerController extends Controller
{
	public function send_message($message,$contact)
   {
        /*--User msg send-*/
		 $mcall= $message ;  
		//Your authentication key
		$authKey ="195394AvzgQhPugj5a6c84e7";

		//Multiple mobiles numbers separated by comma
		$mobileNumber =$contact;

		//Sender ID,While using route4 sender id should be 6 characters long.
		$senderId ="JDNJEW";

		//Your message to send, Add URL encoding here.
		$message = urlencode($mcall);

		//Define route
		$route = "4";

		//Prepare you post parameters
		$postData = array(
		'authkey' => $authKey,
		'mobiles' => $mobileNumber,
		'message' => $message,
		'sender' => $senderId,
		'route' => $route,
		'unicode'=>1
	  );

		
		//API URL
		$url="http://sms.workholics.com/sendhttp.php";

		// init the resource
		$ch = curl_init();
		curl_setopt_array($ch, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => $postData
		//,CURLOPT_FOLLOWLOCATION => true
		));

		//Ignore SSL certificate verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


		//get response
		$output = curl_exec($ch);


		//Print error if any
		if(curl_errno($ch))
		{
		echo 'error:' . curl_error($ch);
		}

		curl_close($ch); 
		 /*----User message close--*/
		 
		  return 'true';
    }
    //profile udpate
    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'        =>'required', 
			'first_name'     =>'required',
            'last_name'      =>'required',
            'email'          =>'required'
        ]); 

        if ($validator->fails()) {
             return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
        }else{
                $id = $request->user_id;
                $pass = trim($request->password);

                $user =  User::findOrFail($id);
                $user['first_name']      = ucwords(trim($request->first_name));
                $user['last_name']       = ucwords(trim($request->last_name));
                $user['email']           = trim($request->email);

                if($pass!='')
                {
                    $user['password']    = bcrypt($pass);
                }

                if($request->hasFile('image'))
                {
                    $validator = Validator::make($request->all(), [
                        'image'    => 'required|image|mimes:jpg,png,gif,jpeg|max:1024',
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
						'data' => $this->userResponse($user),
                    ]);
                }else{
                    return response()->json([
                        'status'  => 0,
                        'message' => 'Please try again!'
                    ]);
                }                
        }
    } 
	
	
	public function changeImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'        =>'required', 
			'image'          =>'required|image|mimes:jpg,png,gif,jpeg'
        ]); 

        if ($validator->fails()) {
             return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
        }else{
                $id = $request->user_id;
                $user =  User::findOrFail($id);

                if($request->hasFile('image'))
                {
                    
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
                        'message' => 'Profile image updated successfully!',
						'data'    =>  $this->userResponse($user),
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
                'data' => $this->userResponse($user),
            ]);
        }else{
            return response()->json(['status' => 0, 'message'=>'Profile details not found'], 200);
        }
    }
    
	
    //user detail
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
	
	public function getMainService(Request $request)
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
        $res = DB::table('main_services')
					->where('status',1)
					->offset($offset)
				    ->limit($limit)
					->orderBy('id','desc')
                    ->get();
					
         if(count($res)>0)
         {
			  foreach($res as $row) 
			 {
				 if($row->icon!='')
				 {
					  $row->icon = url('public/icons/'.$row->icon);
				 }else{
					  $row->icon = '';
				 }
				
			 }
             return response()->json([
                    'status'    => 1,
                    'message'   => 'Success',
					'icon-url' => url('public/icons'),
					'data'      => $res,
                ], 200);

         }else{

			 return response()->json([
                    'status'  => 0,
                    'message' => 'Result not found!'
                ], 200);
		}   
    }
	
	public function getBannerList(Request $request)
    {
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
        $res = DB::table('banners')
					->where('status',0)
					->offset($offset)
				    ->limit($limit)
					->orderBy('id','desc')
                    ->get();
					
					
         if(count($res)>0)
         {
			 foreach($res as $row) 
			 {
				 if($row->image!='')
				 {
					  $row->image = url('public/photos/'.$row->image);
				 }else{
					  $row->image = '';
				 }
				
			 }
             return response()->json([
                    'status'    => 1,
                    'message'   => 'Success',
					'image-url' => url('public/photos'),
					'data' => $res,
                ], 200);

         }else{

			 return response()->json([
                    'status'  => 0,
                    'message' => 'Result not found!'
                ], 200);
		}   
    }
	
	
	public function calculate_distance($lat1, $lon1, $lat2, $lon2, $unit) {
  if (($lat1 == $lat2) && ($lon1 == $lon2)) {
    return 0;
  }else {
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
      return ($miles * 1.609344);
    } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
      return $miles;
    }
  }
  
}
	
	public function getServiceProviderByCategory(Request $request)
    {
		$validator = Validator::make($request->all(), [      
            'category_id' => 'required',
			'limit'       => 'required',
			'offset'      => 'required',
			'latitude'    => 'required',
			'longitude'   => 'required'      
        ]); 

        if ($validator->fails()) {
             return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
        }
		
        $category_id = trim($request['category_id']);
		$keyword = trim($request['keyword']);
		$limit  = trim($request['limit']);
		$offset = trim($request['offset']);
		$latitude    = trim($request['latitude']);
		$longitude  = trim($request['longitude']);
		
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
		
		if($keyword!=''){
			
			 $result = DB::table('business_profiles')
						->leftjoin('users','business_profiles.user_id','=','users.id')
					    ->where('users.service_type',$category_id)
						->where('users.is_delete',0)
						->where('users.role',2)
						->where('business_profiles.status',1);
		      $result->where(function ($query) use ($keyword) {
							$query->orWhere('business_profiles.business_name','LIKE','%'.$keyword.'%')
							->orWhere('business_profiles.address','LIKE','%'.$keyword.'%')
							->orWhere('business_profiles.description','LIKE','%'.$keyword.'%');
						}); 
				$res = $result->select('business_profiles.*')
								->orderBy('business_profiles.id','desc')
								->offset($offset)
								->limit($limit)
								->get();
			
			
		}else{

        $res = DB::table('business_profiles')
						->leftjoin('users','business_profiles.user_id','=','users.id')
					    ->where('users.service_type',$category_id)
						->where('users.is_delete',0)
						->where('users.role',2)
						->where('business_profiles.status',1)
						->select('business_profiles.*')
						->orderBy('business_profiles.id','desc')
						->offset($offset)
				        ->limit($limit)
                        ->get();
	     }
		  			
         if(count($res)>0)
         {
             foreach($res as $r)
             {
                if($r->business_logo!='')
                {
                    $r->business_logo = url('public/photos/'.$r->business_logo);                    
                }
				
				$slat = $r->latitude;
				$slon = $r->longitude;
				if($slat!='' && $slon!='')
				{
					$sdistance = round($this->calculate_distance($slat,$slon,$latitude,$longitude,"K"),1) . " Kilometers";
				}else{
					$sdistance = "00 Kilometers";
				}
				
				
				$avg = DB::table('reviews')
                    ->where('provider_id',$r->user_id)
                    ->avg('rating');				
						
		            $r->average_rating =  $avg;
                    $r->distance       = $sdistance;
             }
             
             return response()->json([
                    'status'    => 1,
                    'message'   => 'Success',
					'data' => $res,
                ], 200);

         }else{

			 return response()->json([
                    'status'  => 0,
                    'message' => 'Result not found!'
                ], 200);
		}
            
    }
	
	public function getServiceProviderDetails(Request $request)
    {
        $provider_id = trim($request['provider_id']);

        $res = DB::table('business_profiles')
					    ->where('user_id',$provider_id)
                        ->first();
		 $avg = DB::table('reviews')
                    ->where('provider_id',$provider_id)
                    ->avg('rating');				
						
		$res->average_rating =  $avg;
		if($res->business_logo!=''){
				 $res->business_logo =  url('public/photos/'.$res->business_logo);
				 }else{
					$res->business_logo ="";
				 }
       			
						
	   $services = DB::table('services')
					    ->where('user_id',$provider_id)
                        ->get();
						
	   $reviews = DB::table('reviews')
                    ->join('users', 'reviews.customer_id', '=', 'users.id')
                    ->where('reviews.provider_id',$provider_id)
					->where('users.role',3)
                    ->select('users.first_name','users.last_name','users.image','reviews.*')
					->offset(0)
				    ->limit(5)
					->orderBy('reviews.id','desc')
                    ->get();
					
		 if(count($reviews)>0)
         {
			 foreach($reviews as $row){
				 if($row->image!=''){
				 $row->image =  url('public/photos/'.$row->image);
				 }else{
					 $row->image ="";
				 }
			 }
		  }

		  if(count($services)>0)
         {
			 foreach($services as $row){
				 if($row->image!=''){
				 $row->image =  url('public/service_images/'.$row->image);
				 }else{
					 $row->image ="";
				 }
				 if($row->image_1!=''){
				 $row->image_1 =  url('public/service_images/'.$row->image_1);
				 }else{
					 $row->image_1 ="";
				 }
				 if($row->image_2!=''){
				 $row->image_2 =  url('public/service_images/'.$row->image_2);
				 }else{
					 $row->image_2 ="";
				 }
			 }
		  }			
					
         if($res!='')
         {
             return response()->json([
                    'status'    => 1,
                    'message'   => 'Success',
					'image_url' => url('public/photos'),
					'response'  => array('data' => $res,'services' => $services,    'reviews'   => $reviews),
                ], 200);

         }else{

			 return response()->json([
                    'status'  => 0,
                    'message' => 'Result not found!'
                ], 200);
		}     
    }
	
	public function getAllReviews(Request $request)
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
			
	   $reviews = DB::table('reviews')
                    ->join('users', 'reviews.customer_id', '=', 'users.id')
                    ->where('reviews.provider_id',$provider_id)
					->where('users.role',3)
                    ->select('users.first_name','users.last_name','users.image','reviews.*')
					->offset($offset)
				    ->limit($limit)
					->orderBy('reviews.id','desc')
                    ->get();
					
	   if(count($reviews)>0)
         {
			 foreach($reviews as $row){
				 if($row->image!=''){
				 $row->image =  url('public/photos/'.$row->image);
				 }else{
					 $row->image ="";
				 }
			 }
		  }		
					
         if(count($reviews)>0)
         {
             return response()->json([
                    'status'    => 1,
                    'message'   => 'Success',
					'image_url' => url('public/photos'),
					'data' => $reviews,
                ], 200);

         }else{

			 return response()->json([
                    'status'  => 0,
                    'message' => 'Result not found!'
                ], 200);
		}     
    }
	
	public function getServiceDetails(Request $request)
    {
        $provider_id = trim($request['provider_id']);
		$service_id  = trim($request['service_id']);
			
	   $services = DB::table('services')
                    ->where('id',$service_id)
					->where('user_id',$provider_id)
                    ->first();
					
         if($services!="")
         {
			 if($services->image!=''){
				 $services->image = url('public/service_images/'.$services->image);
			 }else{
				  $services->image ='';
			 }
			 if($services->image_1!=''){
				 $services->image_1 = url('public/service_images/'.$services->image_1);
			 }else{
				  $services->image_1 ='';
			 }
			 if($services->image_2!=''){
				 $services->image_2 = url('public/service_images/'.$services->image_2);
			 }else{
				  $services->image_2 ='';
			 }
             return response()->json([
                    'status'    => 1,
                    'message'   => 'Success',
					'image_url' => url('public/photos'),
					'data' => $services,
                ], 200);

         }else{

			 return response()->json([
                    'status'  => 0,
                    'message' => 'Result not found!'
                ], 200);
		}     
    }
	
	
	
	public function writeReview(Request $request)
    {
        $validator = Validator::make($request->all(), [      
            'provider_id'    => 'required',      
            'customer_id'    => 'required',
			'description'    => 'required',
			'rating'         => 'required'
        ]); 

        if ($validator->fails()) {
             return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
        }

        $provider_id = trim($request['provider_id']);
		$customer_id = trim($request['customer_id']);
		$description = trim($request['description']);
		$rating      = trim($request['rating']);

        $check = DB::table('reviews')
                    ->where('provider_id',$provider_id)
					->where('customer_id',$customer_id)
                    ->first();
          $rdata = ['customer_id' =>$customer_id, 'provider_id' => $provider_id, 'description' => $description, 'rating' => $rating,'created_date'=>date('Y-m-d H:i:s')];

         if($check!='')
         {
             $res = DB::table('reviews')->where('id', $check->id)->update($rdata);
             $msg = 'Review updated successfully';
         } else{

           $res = DB::table('reviews')->insert($rdata);
           $msg = 'Review write successfully';
         }     
         if($res){
         		$cusdata = User::find($customer_id);
         		$rdata['first_name'] = $cusdata->first_name;
         		$rdata['last_name'] = $cusdata->last_name;
         		$image ="";
         		if($cusdata->image!=''){
				 $image =  url('public/photos/'.$cusdata->image);
				}
         		$rdata['image'] = $image;
				return response()->json([
						'status'  => 1,
						'message' => $msg,
						'data' => $rdata,
					], 200);
			}else{
				 return response()->json([
	                'status'  => 0,
	                'message' => 'Please try again.'
	            ], 200);
			}
    }

    public function getReview(Request $request)
    {
        $validator = Validator::make($request->all(), [      
            'provider_id'    => 'required',      
            'customer_id'    => 'required'
        ]); 

        if ($validator->fails()) {
             return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
        }

        $provider_id = trim($request['provider_id']);
		$customer_id = trim($request['customer_id']);

        $check = DB::table('reviews')
                    ->where('provider_id',$provider_id)
					->where('customer_id',$customer_id)
                    ->first();
         if(empty($check))
         {
             return response()->json([
                    'status'  => 0,
                    'message' => 'Review not write!'
                ], 200);

         } else{

         		$cusdata = User::find($customer_id);
         		$review['first_name'] = $cusdata->first_name;
         		$review['last_name'] = $cusdata->last_name;
         		$image ="";
         		if($cusdata->image!=''){
				 $image =  url('public/photos/'.$cusdata->image);
				}
         		$review['image'] = $image;
         		$review["id"]    = $check->id;
		        $review["provider_id"]= $check->provider_id;
		        $review["customer_id"]= $check->customer_id;
		        $review["rating"]= $check->rating;
		        $review["description"]= $check->description;
		        $review["created_date"]= $check->created_date;
		        $review["status"]= $check->status;
		        
				return response()->json([
						'status'    => 1,
	                    'message'   => 'Success',
						'data' => $review,
					], 200);
         }     
    }
	
	public function availability(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'provider_id'    => 'required',
			'a_date'     => 'required',
			'a_time'     => 'required'
			
        ]); 
        if ($validator->fails()) 
		{
             return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
			 
        }else{
			
		   $user_id = trim($request->provider_id);
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
 
 public function bookAppointments(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'provider_id'   => 'required',
			'customer_id'   => 'required',
			'service_id'    => 'required',
			'service_type'  => 'required',
			'a_date'        => 'required',
			'a_time'        => 'required',
        ]); 
        if ($validator->fails()) 
		{
             return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
			 
        }else{
			   
		   $provider_id  = trim($request->provider_id);
		   $customer_id  = trim($request->customer_id);
		   $service_id   = trim($request->service_id);
		   $service_type = trim($request->service_type);
		   $a_date  = date("Y-m-d",strtotime(trim($request->a_date)));
		   $a_time  = trim($request->a_time);
		   
		   $srv = DB::table('appointments')
						   ->where('service_provider_id',$provider_id)
						   ->where('appointment_date','=',$a_date)
						   ->where('appointment_time','=',$a_time)
						   ->where('customer_id',$customer_id)
						   ->where('service_id',$service_id)
						   ->first();
			if($srv!="")
			{
				return response()->json([
					'status'  => 0,
					'message' => 'Already booked your appointment on this date.',
					'data' => 'false',
				]);
			}else{
				
				$check = DB::table('appointments')
						   ->orderBy('id','DESC')
						   ->limit(1)
						   ->select('id','appointment_no')
						   ->get();
					if(count($check)>0)
					{	   
						$apno = $check[0]->appointment_no;	   
							   
						$ss = explode('-',$apno);
						$appno = $ss[1]+1;
						$appointment_no = "mmh-".$appno;
						
					}else{
						$appointment_no = "mmh-1001";
					}					
				
				  $app = new Appointment;
				  $app->appointment_no = $appointment_no;
				  $app->service_provider_id = $provider_id;
				  $app->customer_id = $customer_id;
				  $app->service_id = $service_id;
				  $app->service_type = $service_type;
				  $app->appointment_time = $a_time;
				  $app->appointment_date = $a_date;
				  $app->appointment_status = 0;
				  
				  $res = $app->save();
					if($res){
						  $not = new Notification;
						  $not->provider_id    = $provider_id;
						  $not->customer_id    = $customer_id;
						  $not->appointment_id = $app->id;
						  $not->type           = 1;
						  $not->title          = "Booking";
						  $not->message        = "Request for appointment";
						  $resnot = $not->save();
						
						
						return response()->json([
								'status'  => 1,
								'message' => 'Your appointment has been booked successfully.',
								'data' => $appointment_no,
							], 200);
							
							
					  $avl = new Availability;
					  $avl->user_id = $provider_id;
					  $avl->a_date  = $a_date;
					  $avl->a_time  = $a_time;
					  $res1 = $avl->save();						
							
					}else{
						return response()->json([
									'status'  => 0,
									'message' => 'Please try again.',
								], 200);
					}
					
			}
    } 
	
 }
 
 public function getMyAppointments(Request $request) 
    {
        $validator = Validator::make($request->all(), [
			'customer_id'   => 'required',
			'type'   => 'required',
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

		   $customer_id = trim($request->customer_id);
		   $type = trim($request->type);
		   
		   $res = DB::table('appointments')
		                   ->leftjoin('services', 'appointments.service_id', '=', 'services.id')
						   ->leftjoin('business_profiles', 'appointments.service_provider_id', '=', 'business_profiles.user_id')
						   ->where('appointments.customer_id',$customer_id);
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
				 $row->service_provider_name='';
				 if($row->service_provider_id)
				 {
				 	$user = DB::table('users')->where('id',$row->service_provider_id)->first();
				 	$row->service_provider_name = $user->first_name.' '.$user->last_name;
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
 
 public function searchServiceProviders(Request $request)
    {
        $category_id = trim($request['category_id']);
		$keyword     = trim($request['keyword']);
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

        $result = DB::table('business_profiles')
						->join('users','business_profiles.user_id','=','users.id')
					    ->where('users.service_type',$category_id)
						->where('users.is_delete',0)
						->where('users.role',2)
						->where('business_profiles.status',1);
		$result->where(function ($query) use ($keyword) {
							$query->orWhere('business_profiles.business_name','LIKE','%'.$keyword.'%')
							->orWhere('business_profiles.address','LIKE','%'.$keyword.'%')
							->orWhere('business_profiles.description','LIKE','%'.$keyword.'%');
						}); 
				$res = $result->select('business_profiles.*')
								->offset($offset)
								->limit($limit)
								->get();
					
         if(count($res)>0)
         {
             return response()->json([
                    'status'    => 1,
                    'message'   => 'Success',
					'image_url'   => url('public/photos'),
					'data' => $res,
                ], 200);

         }else{

			 return response()->json([
                    'status'  => 0,
                    'message' => 'Result not found!'
                ], 200);
		}
            
    }
	
	
	public function updateMyAppointment(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'appointment_id'=> 'required',
			'provider_id'   => 'required',
			'customer_id'   => 'required',
			'service_id'    => 'required',
			'service_type'  => 'required',
			'a_date'        => 'required',
			'a_time'        => 'required',
        ]); 
        if ($validator->fails()) 
		{
             return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
			 
        }else{
			   
		   $appointment_id  = trim($request->appointment_id);
		   $provider_id  = trim($request->provider_id);
		   $customer_id  = trim($request->customer_id);
		   $service_id   = trim($request->service_id);
		   $service_type = trim($request->service_type);
		   $a_date  = date("Y-m-d",strtotime(trim($request->a_date)));
		   $a_time  = trim($request->a_time);
		   
		   $app = DB::table('appointments')
						   ->where('id',$appointment_id)
						   ->where('customer_id',$customer_id)
						   ->first();
			if($app!="")
			{
				  $res = DB::table('appointments')
								->where('id', $appointment_id)
								->update(['service_provider_id' => $provider_id,'customer_id' => $customer_id,'service_id' => $service_id,'service_type' => $service_type,'appointment_time' => $a_time,'appointment_date' => $a_date,]);
				  
				  
					if($res)
					{
						 $not = new Notification;
						  $not->provider_id    = $provider_id;
						  $not->customer_id    = $customer_id;
						  $not->appointment_id = $appointment_id;
						  $not->type           = 1;
						  $not->title          = "Update Booking";
						  $not->message        = "Update appointment request.";
						  $resnot = $not->save();
						  
						return response()->json([
								'status'  => 1,
								'message' => 'Your appointment has been updated successfully.',
								'data' => $app->appointment_no,
							], 200);
					}else{
						return response()->json([
									'status'  => 0,
									'message' => 'Please try again.',
								], 200);
					}
			}else{
				
				return response()->json([
					'status'  => 0,
					'message' => 'Appointment not found.'
				]);				
					
			}
    } 
	
 }
	
	public function cancelMyAppointment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'appointment_id'   => 'required',
            'customer_id'      => 'required'
        ]);

        if($validator->fails())
       {
           return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
       }
	   
	   $id = trim($request->appointment_id);
	   $customer_id = trim($request->customer_id);
	   
        $app = DB::table('appointments')
						->where('id', $id)
						->where('customer_id', $customer_id)
						->first(); 
        if(!$app)
        {
            return response()->json([ 
                'status'  => 0,
                'message' => 'Appointment request not found.'
            ], 200);
        }else{
			
			  $result =  DB::table('appointments')
								->where('id', $id)
								->where('customer_id', $customer_id)
								->update(['status' => 2,'appointment_status' => 2]);
				
				  if($result)
				  {
					      $not = new Notification;
						  $not->provider_id    = $app->service_provider_id;
						  $not->customer_id    = $customer_id;
						  $not->appointment_id = $id;
						  $not->type           = 1;
						  $not->title          = "Canceled Appointment";
						  $not->message        = "Canceled appointment request.";
						  $resnot = $not->save();
					  
					   return response()->json([ 
								'status'  => 1,
								'message' => 'Appointment has been cenceled successfully.'
							], 200);
				  }else{
						  return response()->json([ 
							'status'  => 0,
							'message' => 'Please try again..'
						], 200);
				  }
		}
		
	}
	
	
	public function getNotificationList(Request $request) 
    {
        $validator = Validator::make($request->all(), [
			'customer_id' => 'required',
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
		   
		   $customer_id    = trim($request->customer_id);
		   
		   $result = DB::table('notifications')
						->leftjoin('users','notifications.provider_id','=','users.id')
						->where('notifications.type',2)
						->where('notifications.customer_id',$customer_id)
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
 
 
 public function getServiceProviderByBanner(Request $request)
    {
		$validator = Validator::make($request->all(), [      
            'banner_id' => 'required',
			'limit'       => 'required',
			'offset'      => 'required',
			'latitude'    => 'required',
			'longitude'   => 'required'      
        ]); 

        if ($validator->fails()) {
             return response()->json(['status' => 0, 'message'=>$validator->errors()->first()], 200);
        }
		
        $banner_id = trim($request['banner_id']);
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
			$res = DB::table('banners')
					->leftjoin('users','banners.main_service_id','=','users.service_type')
					->leftjoin('business_profiles','users.id','=','business_profiles.user_id')
					->where('banners.id',$banner_id)
					->where('users.is_delete',0)
					->where('users.role',2)
					->where('business_profiles.status',1)
					->select('business_profiles.*','banners.offer_percent','banners.image as banner_image')
					->orderBy('business_profiles.id','desc')
					->offset($offset)
					->limit($limit)
					->get();
	     
		  			
         if(count($res)>0)
         {
             foreach($res as $r)
             {
                if($r->business_logo!='')
                {
                    $r->business_logo = url('public/photos/'.$r->business_logo);                    
                }
				
				$slat = $r->latitude;
				$slon = $r->longitude;
				if($slat!='' && $slon!='')
				{
					$sdistance = round($this->calculate_distance($slat,$slon,$latitude,$longitude,"K"),1) . " Kilometers";
				}else{
					$sdistance = "00 Kilometers";
				}
				
				 $avg = DB::table('reviews')
                    ->where('provider_id',$r->user_id)
                    ->avg('rating');				
						
		            $r->average_rating =  $avg;
                    $r->distance       = $sdistance;
             }
             
             return response()->json([
                    'status'    => 1,
                    'message'   => 'Success',
					'data' => $res,
                ], 200);

         }else{

			 return response()->json([
                    'status'  => 0,
                    'message' => 'Result not found!'
                ], 200);
		}
            
    }
	
	 

    //end class
}