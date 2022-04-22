<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\User;
use Auth;
use Mail;
use DB;
use Helper;

class HomeController extends Controller
{
    public function index(Request $request)
	{   
         $fevents = DB::table('events')->where('status',1)->orderBy('id','DESC')->take(3)->get();
        return view('front.index',compact('fevents'));
    }
	
	public function aboutUs()
    {
        $title = 'About Us';
        $data['detail'] = DB::table('website_info')->where('id',8)->first();
        $data['aboutus'] = array();
        if(!empty($data['detail']))
        {
            $data['aboutus'] = DB::table('website_details')->where('website_id',$data['detail']->id)->get();
        }
        $fevents = DB::table('events')->where('status',1)->orderBy('id','DESC')->take(3)->get();
        return view('front.about',compact('title','data','fevents'));
    }
	
	public function chairmansMessage()
    {
        $title = 'Chairmans Message';
        $fevents = DB::table('events')->where('status',1)->orderBy('id','DESC')->take(3)->get();
        return view('front.chairman',compact('title','fevents'));
    }
	
	public function events()
    {
        $title = 'Events';
		$events = DB::table('events')->where('status',1)->get();
        $fevents = DB::table('events')->where('status',1)->orderBy('id','DESC')->take(3)->get();
        return view('front.event',compact('title','events','fevents'));
    }
	
	public function eventDetails(Request $request,$id)
    {
         $title = 'Event Details';
		 $id = base64_decode($id);
		 $events = DB::table('events')->where('id',$id)->first();
         $fevents = DB::table('events')->where('status',1)->orderBy('id','DESC')->take(3)->get();
		
        return view('front.event-details',compact('title','events','fevents'));
    }
	
	
	
	public function whatWeDo()
    {
        $title = 'what We Do';
        $fevents = DB::table('events')->where('status',1)->orderBy('id','DESC')->take(3)->get();
        return view('front.whatwedo',compact('title','fevents'));
    }

    public function contactUs()
    {
        $title = 'Contact Us';
        $data['detail'] = DB::table('website_info')->where('id',5)->first();
        $fevents = DB::table('events')->where('status',1)->orderBy('id','DESC')->take(3)->get();
        return view('front.contact',compact('title','data','fevents'));
    }

  
	
	 public function contactUsSave(Request $request)
    {

    	 $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'phone'    => 'required|min:10|numeric',
            'email'     => ['required', 'string', 'email', 'max:255'],
            'message'  => 'required'
            ]);


        if ($validator->fails()) 
        {
            return redirect()->back() ->withErrors($validator)->withInput(); 
        }

          $result = DB::table('contact_us')->insert(['name'=>trim($request['name']),'number'=>trim($request['phone']),'email'=>trim($request['email']),'message'=>trim($request['message'])]);

        if($result)
        {
           return redirect()->back()->with('success_message','Your details has been saved successfully. We will contact you soon.');
        }else{
            return back()->with('error_message','Please try again.');
        }   

    }
	
	public function strategicPartnerRegistration()
    {
        $title = 'strategic Partner Registration';
        $fevents = DB::table('events')->where('status',1)->orderBy('id','DESC')->take(3)->get();
        return view('front.strategic_partner_registration',compact('title','fevents'));
    }

  
	
	 public function strategicPartnerRegistrationSave(Request $request)
    {

    	 $validator = Validator::make($request->all(), [
            'company_name'     => 'required',
            'mobile'    => 'required',
            'email'     => ['required', 'string', 'email', 'max:255'],
            'ceo_md'  => 'required',
			'country'  => 'required',
			'industry'  => 'required',
			'company_website_url'  => 'required',
			'project_interest'  => 'required',
            ]);


        if ($validator->fails()) 
        {
            return redirect()->back() ->withErrors($validator)->withInput(); 
        }

          $result = DB::table('strategic_partners')->insert(['company_name'=>trim($request['company_name']),'country'=>trim($request['country']),'official_email'=>trim($request['email']),'industry'=>trim($request['industry']),'company_website_url'=>trim($request['company_website_url']),'ceo_md'=>trim($request['ceo_md']),'project_interest'=>trim($request['project_interest']),'mobile'=>trim($request['mobile'])]);

        if($result)
        {
           return redirect()->back()->with('success_message','Your details has been saved successfully. We will contact you soon.');
        }else{
            return back()->with('error_message','Please try again.');
        }   

    }
	
	
	
	 public function userRegister()
    {
        $fevents = DB::table('events')->where('status',1)->orderBy('id','DESC')->take(3)->get();
        return view('front.signup',compact('fevents'));
    }
	
	
	 public function userRegisterAction(Request $request)
    {
    	$validator = Validator::make($request->all(), [
              'name'            => 'required',
              'mobile'          => 'required|numeric|unique:users',
              'email'           => 'required|email|unique:users',
              'city'            => 'required|string',
              'address'         => 'required',
              'gender'          => 'required',
			  'password'        => 'min:6|required_with:password_repeat|same:password_repeat',
              'password_repeat' => 'required|min:6',
              'birthday_day' => 'required',
			  'birthday_month' => 'required',
			  'birthday_year' => 'required',
			  'country' => 'required',
			  'agreement' => 'required',
			  
          ]);


        if ($validator->fails()) 
        {
            return redirect()->back() ->withErrors($validator)->withInput(); 
        }

           $d = trim($request['birthday_day']);
		   $m = trim($request['birthday_month']);
		   $y = trim($request['birthday_year']);
		   $dob = $d.'-'.$m.'-'.$y;
          $catdata = new User; 
          $catdata->name               = trim($request['name']);
          $catdata->mobile             = trim($request['mobile']);
          $catdata->email              = trim($request['email']); 
          $catdata->city               = trim($request['city']);
          $catdata->country            = trim($request['country']);
          $catdata->address            = trim($request['address']);
          $catdata->gender             = trim($request['gender']);
          $catdata->dob                = $dob;
		  $catdata->role               = 2;
          $catdata->password           = bcrypt(trim($request['password']));
          $catdata->cdate              = date("Y-m-d");
          $result =  $catdata->save();  

        if($result)
        {
           return redirect()->back()->with('success_message','Your details has been saved successfully. We will contact you soon.');
        }else{
            return back()->with('error_message','Please try again.');
        }   

    }
	
	
	
	
	 public function userlogin()
    {
         $fevents = DB::table('events')->where('status',1)->orderBy('id','DESC')->take(3)->get();
        return view('front.login',compact('fevents'));
    }

  


    public function resendMail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email']
            ]);
        $response = array();
        if ($validator->fails()) {
            $valErrors = '';
            foreach ($validator->messages()->getMessages() as $field_name => $messages)
            {
                foreach($messages AS $message) {
                    $valErrors .= $message.', ';
                }
            }
            $response['status']='error';
            $response['msg']=rtrim($valErrors,', ');
            return $response; 
        }

        $email = $request['email'];
        $udata = User::select(['id'])->where(['email'=>$email,'verify'=>0])->first();
        if(!empty($udata))
        {
            $confirmation_code = mt_rand();
            $udata->token = $confirmation_code;
            $res = $udata->save();
            if($res)
            {
                //send verification mail
                $subject = 'Verification mail';
                $this->sendMail($email,$confirmation_code,$subject);
                $response['status']='success';
                $response['type']='resend';
                $response['msg']='Verification email has sent to your registered email';
            }else{
                $response['status']='error';
                $response['msg']='Invalid Email address or Password';
            }
            //
        }else{
            $response['status']='error';
            $response['msg']='Invalid Email address';
        }
        return $response;
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email']
            ]);
        $response = array();
        if ($validator->fails()) {
            $valErrors = '';
            foreach ($validator->messages()->getMessages() as $field_name => $messages)
            {
                foreach($messages AS $message) {
                    $valErrors .= $message.', ';
                }
            }
            $response['status']='error';
            $response['msg']=rtrim($valErrors,', ');
            return $response; 
        }

        $email = $request['email'];
        $udata = User::select(['id'])->where(['email'=>$email,'status'=>1])->first();
        if(!empty($udata))
        {
            $digits = 4;
            $otp = rand(pow(10, $digits-1), pow(10, $digits)-1);
            $udata->otp = $otp;
            $res = $udata->save();
            if($res)
            {
                //send verification mail
                $subject = 'OTP Verification mail';
                $this->sendOtpMail($email,$otp,$subject);
                $response['status']='success';
                $response['type']='otp';
                $response['email']=$email;
                $response['msg']='OTP email has sent to your registered email';
            }else{
                $response['status']='error';
                $response['msg']='Invalid Email address or Password';
            }
            //
        }else{
            $response['status']='error';
            $response['msg']='Invalid Email address';
        }
        return $response;
    }

    
    

    public function newPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'otp' => 'required',
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            ]);
        $response = array();
        if ($validator->fails()) {
            $valErrors = '';
            foreach ($validator->messages()->getMessages() as $field_name => $messages)
            {
                foreach($messages AS $message) {
                    $valErrors .= $message.', ';
                }
            }
            $response['status']='error';
            $response['msg']=rtrim($valErrors,', ');
            return $response; 
        }

        $email  = trim($request['email']);
        $otp    = trim($request['otp']);
        $password    = trim($request['password']);
        $udata = User::select(['id'])->where(['email'=>$email,'otp'=>$otp])->first();
        if(!empty($udata))
        {   
            $udata->password = Hash::make($password);
            $udata->save();

            $response['status']='success';
            $response['type']='newpassword';
            $response['msg']='Password change successfully';    
        }else{
            $response['status']='error';
            $response['msg']='Please try again';
        }
        return $response;
    }
    public function mailVerify($email='',$token='')
    {
        $email = base64_decode($email);
        $token = base64_decode($token); 
        if($email!='' && $token!='')
        {
            $udata = User::select(['id'])->where(['email'=>$email,'token'=>$token,'verify'=>0])->first();
            if(!empty($udata))
            {
                $updata = User::findOrFail($udata->id);
                $updata->verify = 1;
                $updata->token  = '';
                $r=$updata->save();
                if($r)
                {
                    return redirect('/')->with('front_success','Mail Verified Successfully');
                }else{
                return redirect('/')->with('front_error','Something Wrong');
                }
            }else{
                return redirect('/')->with('front_error','Email Link Expired');
            }
        }else{
            return redirect('/');
        }
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
            ]);
        $response = array();
        if ($validator->fails()) {
            $valErrors = '';
            foreach ($validator->messages()->getMessages() as $field_name => $messages)
            {
                foreach($messages AS $message) {
                    $valErrors .= $message.', ';
                }
            }

            $response['status']='error';
            $response['msg']=rtrim($valErrors,', ');
            return $response; 
        }

        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
          $auth = Auth::attempt(['email' => $request->email,'password' => $request->password,'status'=>1]);
        } else {
            $auth = Auth::attempt(['mobile' => $request->email,'password' => $request->password,'status'=>1]);
        }

        
        if($auth)
        {
            if(Auth::user()->verify==0)
            {
                Auth::logout();
                $response['status']='error';
                $response['type']  ='verify';
                $response['msg']='Please verify your email id <a href="javascript:;" data-toggle="modal" data-target="#resend-mail">Click here</a>';
                return $response;
            }else{
                if(Auth::user()->status==2)
                {
                    Auth::logout();
                    $response['status']='error';
                    $response['type']  ='login';
                    $response['msg']='Your account under review';
                }elseif(Auth::user()->status==0){
                    Auth::logout();
                    $response['status']='error';
                    $response['type']  ='login';
                    $response['msg']='Your account not exist';
                }elseif(Auth::user()->isLogin==0){
                    Auth::logout();
                    $response['status']='error';
                    $response['type']  ='login';
                    $response['msg']='Your account disabled';
                }else{
                    $response['status']='success';
                    $response['type']  ='login';
                    $response['msg']='Login successfully';
                }
            }
            
        }else{
            $response['status']='error';
            $response['msg']='Invalid Email/Mobile address or Password';
        }
        return $response;
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success','Logout successfully');
    }

    public function sendOtpMail($email,$otp,$subject)
    {
        // mail function start
        $to = $email;
        $from = "info@fotographia.com";
        $user = array(
                        'logo'=>url('public/front-assets/img/logo.png'),
                        'otp'=>$otp
                    ); 
        $data = array('name'=>"Fotographia.com");
        $res = Mail::send('front.mail-template.otp', ['user' => $user, 'data' => $data], function($message) use ($to,$from,$subject) {
             $message->to($to)->subject($subject);
             $message->from($from,'Fotographia.com');
        });
        return $res;
        // mail function end
    }

    public function sendMail($email,$confirmation_code,$subject)
    {
        // mail function start
        $to = $email;
        $subject = $subject;
        $from = "info@fotographia.com";
        $eemail = base64_encode($to);
        $etoken = base64_encode($confirmation_code);
        $link = url('mail-verify/'.$eemail.'/'.$etoken);
        $user = array(
                        'logo'=>url('public/front-assets/img/logo.png'),
                        'link'=>$link
                    ); 
        $data = array('name'=>"Fotographia.com");
        $res = Mail::send('front.mail-template.registration', ['user' => $user, 'data' => $data], function($message) use ($to,$from,$subject) {
             $message->to($to)->subject($subject);
             $message->from($from,'Fotographia.com');
        });
        return $res;
        // mail function end
    }

    

    

   
/* end of class*/

}
