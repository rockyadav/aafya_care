<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = 'check/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:4|confirmed',
            'mobile' => 'required|unique:users|max:10'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     // 'country' => 'required',
    // 'city' => 'required',
    // 'zipcode' => 'required',
    // 'address' => 'required'
     // 'country' => $data['country'],
    // 'city' => $data['city'],
    // 'zipcode' => $data['zipcode'],
    // 'landmark' => $data['landmark'],
    // 'address' => $data['address'],
     */
    protected function create(array $data)
    {
        $gnOtp = mt_rand(1000,9999);
        $user = User::create([
            'first_name'=> $data['first_name'],
            'last_name' => $data['last_name'],
            'email'     => $data['email'],
            'password'  => bcrypt($data['password']),
            'email'     => $data['email'],
            'mobile'    => $data['mobile'],
            'otp'       =>$gnOtp,
            'role'      => 3,
            'status'    => 0,
        ]);

        if($user)
        {

            $mcall='Your one time password for radhefashion.com is '.$gnOtp;
            /*------MSG.pnpuniverse-API------------*/
            /*Your authentication key*/
            $authKey ="195394AvzgQhPugj5a6c84e7";
            //Multiple mobiles numbers separated by comma
            $mobileNumber = $data['mobile'];
            //Sender ID,While using route4 sender id should be 6 characters long.
            $senderId ="PORWAL";
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
            'route' => $route
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
            //----mobile otp close--
        }
        session()->put('otp_verify',0);

        return $user;

    }
}
