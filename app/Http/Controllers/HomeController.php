<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\User;
use App\Model\Transaction; 
use App\Model\User_order;
use App\Model\Customer;
use App\Model\Contact;
use Input;
use Auth;
use Session;
use DB;
use Response;
use Mail;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use View;

class HomeController extends Controller
{

    public function __construct()
    {
        if (!Auth::check()) return 'NO';
    }
    
    public function index(Request $request)
    {
       $courses   = DB::table('courses')
                    ->where('status',1)
                    ->where('is_delete',0)
                    ->orderBy('show_order','ASC')
                    ->get();

        $testimonial  = DB::table('testimonials')
                         ->where('status',1)
                        ->get();

        $slider  = DB::table('sliders')
                         ->where('id',1)
                         ->first();

        $city  = DB::table('cities')
                         ->where('status',1)
                         ->orderBy('name','asc')
                         ->get();            
              /**POST SERVICE CALL */
      $method = "GET";
      $url = "http://elabcorpsupport.elabassist.com/Services/GlobalUserService.svc/SearchTest?labid=a76aeb22-c144-4748-a75c-9ba45ea80d8c";
      $mydata = $this->callAPI($method, $url, 1);
      $result = json_decode($mydata, true);
      $tests = $result['d'];
      // print_r($tests);

        // $ch = curl_init('https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');
        // curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Basic cUFEaXhabmlBYzZBOWJYZHFHUzZieVQxUERoOXg2aTU6Rk5mYVhlb2tKU2djVzlSVQ']);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $response = curl_exec($ch);
        // curl_close($ch);
        // echo $response;
                         
        // $postData = [
        //   "BusinessShortCode"=>"174379",    
        //   "Password"=> "MTc0Mzc5YmZiMjc5ZjlhYTliZGJjZjE1OGU5N2RkNzFhNDY3Y2QyZTBjODkzMDU5YjEwZjc4ZTZiNzJhZGExZWQyYzkxOTIwMTYwMjE2MTY1NjI3",    
        // "Timestamp"=>"20160216165627",    
        // "TransactionType"=> "CustomerPayBillOnline",    
        //   "Amount"=>"1",    
        //  "PartyA"=>"254708374149",    
        //   "PartyB"=>"174379",    
        // "PhoneNumber"=>"254708374149",    
        // "CallBackURL"=>"https://mydomain.com/pat",    
        // "AccountReference"=>"Test",    
        // "TransactionDesc"=>"Test"
        // ];

        // $ch = curl_init('https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest');
        // curl_setopt($ch, CURLOPT_HTTPHEADER, [
        //     'Authorization: Bearer SEtfuQgAkemMMFbnWIPTdm574RrV',
        //     'Content-Type: application/json'
        // ]);
        // curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $response     = curl_exec($ch);
        // curl_close($ch);
        // echo $response;

          return View::make('front.index')
          -> with(compact('courses'))
          -> with(compact('testimonial'))
          -> with(compact('slider'))
          -> with(compact('city'))
          -> with(compact('tests'));
          // ,'testimonial','slider','city',$tests));

    } 

               
     public function test(Request $request)
    {
       $courses   = DB::table('courses')
                    ->where('status',1)
                    ->get();

        $testimonial  = DB::table('testimonials')
                         ->where('status',1)
                        ->get();

        $slider  = DB::table('sliders')
                         ->where('id',1)
                         ->first();

        $city  = DB::table('cities')
                         ->where('status',1)
                         ->orderBy('name','asc')
                         ->get();                                 

        return view('front.test',compact('courses','testimonial','slider','city'));

    } 

    public function OtpLogin(Request $request) 
    {

      $number = $_GET['number'];
      $email = $_GET['email'];
      $obj = [
        "objSP" => 
        [
          "Task" => 7,
          "UserName" => $number,
          "Password" => $number,
          "EmailID" => $email,
          "AppID" => "a76aeb22-c144-4748-a75c-9ba45ea80d8c",
          "MobileDeviceID" => "",
          "MobileNo" => ""
        ]
      ];
      $postdata = json_encode($obj);
      /**POST SERVICE CALL */
      $method = "POST";
      $url = "http://elabcorpsupport.elabassist.com/Services/GlobalUserService.svc/UserRegistration";
      $mydata = $this->callAPI($method, $url, $postdata);
      $result = json_decode($mydata, true);
      $result = $result['d'];
      if($result["Result"] == "Success")
      {
        // Session::put('myUserData', $result);       
        Session::put('username', $result['UserName']); 
        
        echo $mydata;
      } else {
        echo '<script>alert("Otp Failed.")</script>';
      }      
    }

    public function ValidateOTP(Request $request) 
    {

      $validator = Validator::make($request->all(), [
        'otp'     => 'required|string'
      ]);

      $otp = $_GET['otp'];
      // $otp = $_GET['otp'];
      $username = session('username');
      
      $obj = [
        "objSP"=>[
          "Task"=> 2,
          "UserName"=> $username,
          "OTP"=> $otp
        ]
      ];

      $postdata = json_encode($obj);
      /**POST SERVICE CALL */
      $method = "POST";
      $url = "http://elabcorpsupport.elabassist.com/Services/GlobalUserService.svc/UserRegistration";
      $mydata = $this->callAPI($method, $url, $postdata);
      // $mydata = json_decode($mydata, true);
      $result = json_decode($mydata, true);
      $result = $result['d'];
      if($result['Result'] == "Success.")
      {
        Session::put('myUserData', $result);
        // echo "<script>localStorage.setItem('xxx', JSON.stringify($mydata));</script>";
        // return redirect('index');
        echo $mydata; 
      }
      else {
        echo "<script>alert('OTP Validation Failed .')</script>";
      }
      // echo $mydata;
      // return view('front.index',compact('result'));
      // return \View::make('front.index')->with('myUserData', $result);
    }

     public function bookingFormAction(Request $request)
    {
      echo "<script>document.getElementsByClassName('loadingIMG').style.display = 'block';</script>";
      echo "<script>document.getElementsByClassName('loadingLabel').style.display = 'none';</script>";

      $validator = Validator::make($request->all(), [
              'name'     => 'required|string',
              'mobile'   => 'required',
              'city'     => 'required|string',
              'test'     => 'required',
              'bookDate' => 'required|string',
              'bookTime' => 'required|string'
          ]);

          // print_r($_POST);
          // $AppointmentDate = $this->input->post('selectedDateAndTime');
            // // require app_path().'\third_party\PHPMailer_5.2.1\class.phpmailer.php';
            // require_once("app/third_party/PHPMailer_5.2.1/class.phpmailer.php");

            //   $mail = new \PHPMailer(true);                              // Passing `true` enables exceptions
            //   try {
            //         //Server settings
            //         // $mail->SMTPDebug = 2;                                 // Enable verbose debug output
            //         $mail->isSMTP();                                      // Set mailer to use SMTP
            //         $mail->Host = 'mail.bluepearlhealthtech.com';  // Specify main and backup SMTP servers
            //         $mail->SMTPAuth = true;                               // Enable SMTP authentication
            //         $mail->Username = 'test@bluepearlhealthtech.com';                 // SMTP username
            //         $mail->Password = 'test@123';                           // SMTP password
          
            //         $mail->SMTPSecure = 'https';                            // Enable TLS encryption, `ssl` also accepted
            //         $mail->Port = 25;                                    // TCP port to connect to
          
            //         //Recipients
            //         $mail->setFrom('test@bluepearlhealthtech.com', trim($request['name']));
            //         $mail->addAddress('care@aafya.care');     // Add a recipient
          
            //             //Content
            //         $mail->isHTML(true);                                  // Set email format to HTML
            //         $mail->Subject = 'Zeta Appointment';
            //         $mail->Body    = '<h4 align=center>Name : '.$_POST['name'].'<br>Mobile : '.trim($request['mobile']).'<br>City : '.trim($request['city']).'<br>Test : '.trim($request['test']).'</h4>';
            //         $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            //         $mail->send();
            //        // echo 'Message has been sent';
            //        return redirect()->back()->with('success_email','Success');
            //     }
            //     catch (Exception $e) {
            //       echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
            //     }

            //   if ($validator->fails()) 
            //   {
            //       return redirect()->back() ->withErrors($validator)->withInput(); 
            //   }
              
            //     $res = Customer::orderBy('id','desc')->take(1)->get();
            //     if(count($res)>0)
            //     {
            //       $regno = $res[0]->id+1;
            //     }else{
            //       $regno = 100;
            //     }
            //     $catdata = new Customer; 
            //     $otp = mt_rand(1000,9999);
            //     $catdata->registration_no  = "AAFYA-".$regno;
            //     $catdata->name       = trim($request['name']);
            //     $catdata->mobile     = trim($request['mobile']);
            //     $catdata->city       = trim($request['city']);
            //     $catdata->test_id    = trim($request['test']);
            //     $catdata->cdate      = date("Y-m-d");
            //     $catdata->otp        = $otp;

            //     $result =  $catdata->save();  

            //   if($result)
            //   {

            //      session()->put('UserData',array('id' => $catdata->id,'mobile'=>$catdata->mobile,'registration_no'=>$catdata->registration_no,'test_id'=>$catdata->test_id,'otp'=>$catdata->otp));

            //      return redirect()->back()->with('success_message','Success');
            //   }else{
            //       return back()->with('error_message','Please try again.');
            //   }
            $bktest = "";
            $bkprofile = "";

            if($_POST['selectedTestType'] == 'test')
            {
              $bktest = $_POST['selectedTest'];
            }

            if($_POST['selectedTestType'] == 'profile')
            {
              $bkprofile = $_POST['selectedTest'];
            }

            $user = session('myUserData');
            $task = 0;
            $postdata = [
              "LabID" => "a76aeb22-c144-4748-a75c-9ba45ea80d8c", // TEST_LAB_ID
              "PatientID" => $user['UserFID'],
              "Username" => $user['UserName'],
              "SelectedTest" => $bktest,
              "SelectedProfile" => $bkprofile,
              "SelectedPopularTest" => "",
              "EnteredTest" => "",
              "AppointmentDate" => $_POST['selectedDateAndTime'],
              "AppointmentAddress" => "",
              "RefDocID" => "2",
              "RefDocName" => "Self .",
              "PatientName" => $_POST['name'],
              "IsRefering" => true,
              "Age" => $_POST['age'],
              "AgeType" => "Y",
              "Gender" => 0,
              "Pincode" => "",
              "CollectionCenterID" => 28,
              "AffiliationID" => 0,
              "IsHomeCollection" => false,
              "DeviceType" => "1",
              "Task" => $task,
              "Prescription"=> "",
              "PrescriptionTwo"=> "",
              "PrescriptionThree"=> "",
              "PrescriptionFour"=> "",
              "ReferByID" => 1,
              "PatientMobileNo" => $user['UserName'],
              "RefByName" => "Dummy",
            ];

            $postdata = json_encode($postdata);
            // echo $postdata;
            /**POST SERVICE CALL */
            $method = "POST";
            $url = "http://zetatest.elabassist.com/Services/BookMyAppointment_Services.svc/PatientAppointMent_Global";
            // $url = "http://live.elabassist.com/Services/BookMyAppointment_Services.svc/PatientAppointMent_Global";
            $result = $this->callAPI($method, $url, $postdata);
            $data = json_decode($result, true);
            $data = $data["d"];
            // echo $result;
            if ($data["Result"] == "Appointment_Booked") 
            {
              // $res_access_token = $this->getAccessToken();
              // $data = json_decode($res_access_token, true);
              // $access_token = $data['access_token'];
              // $resPayment = $this->updatePayment($access_token);
              // echo $resPayment;
              echo "<script>alert('Appointment Booked .')</script>";
                // echo "<script>document.getElementsByClassName('loadingIMG').style.display = 'none';</script>";
                // echo "<script>document.getElementsByClassName('loadingLabel').style.display = 'block';</script>";
                return redirect()->back()->with('success_message','Appointment Booked .');              
            } else 
            {
              echo "<script>document.getElementsByClassName('loadingIMG').style.display = 'none';</script>";
              echo "<script>document.getElementsByClassName('loadingLabel').style.display = 'block';</script>";
              echo "<script>alert('Appointment Failed .')</script>";
            }
            // echo $mydata;
      }

    public function getAccessToken()
    {
            /**GET SERVICE CALL */
            $method = "GET";
            $url = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";

            // $result = $this->callAPI($method, $url, 1);
            // $data = json_decode($result, true);
            // // $data = $data["d"];
            // echo $result;

            $username = "Azs2KejU1ARvIL5JdJsARbV2gDrWmpOB";
            $password = "hipGvFJbOxri330c";

            $curl = curl_init();  
            switch ($method) {
              case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data)
                  curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
              case "GET":
                // curl_setopt($curl, CURLOPT_POST,1);
                break;
            }
            curl_setopt($curl, CURLOPT_URL, $url);
            /* Define Content Type */
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('content-type:application/json'));
            /* Return JSON */
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            // /* new connection instead of cached one */
            curl_setopt($curl, CURLOPT_USERPWD, $username . ":" . $password);
            // curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);
            $data = $result = curl_exec($curl);
            curl_close($curl);

            return $data;
    }

    public function updatePayment($access_token)
    {
      $authorisation = "Bearer ".$access_token;
      $dates = date('Y/m/d H:i:s', time());
      $dates = explode(' ', $dates);
      $mdate = explode('/', $dates[0]);
      $mtime = explode(':', $dates[1]);
      $mString = $mdate[0].$mdate[1].$mdate[2].$mtime[0].$mtime[1].$mtime[2];

      $postdata = [
        "BusinessShortCode"=>"174379",    
        "Password"=> base64_encode("174379+"."bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919+".$mString), // "OTU2NTAwNStiZmIyNzlmOWFhOWJkYmNmMTU4ZTk3ZGQ3MWE0NjdjZDJlMGM4OTMwNTliMTBmNzhlNmI3MmFkYTFlZDJjOTE5KzIwMjIwNDE5MTM0ODI4",    
        "Timestamp"=>$mString,    
        "TransactionType"=> "CustomerPayBillOnline",    
        "Amount"=>"1",    
        "PartyA"=>"254746609933",    
        "PartyB"=>"174379",    
        "PhoneNumber"=>"254746609933",    
        "CallBackURL"=>"https://mydomain.com/pat",    
        "AccountReference"=>"Test",    
        "TransactionDesc"=>"Test"
      ];

      $postdata = json_encode($postdata);
      echo $postdata;
      /**POST SERVICE CALL */
      $method = "POST";
      $url = "https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest";

      $username = "Azs2KejU1ARvIL5JdJsARbV2gDrWmpOB";
      $password = "hipGvFJbOxri330c";

      $curl = curl_init();  
      switch ($method) {
        case "POST":
          curl_setopt($curl, CURLOPT_POST, 1);
          if ($postdata)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
          break;
        case "GET":
          // curl_setopt($curl, CURLOPT_POST,1);
          break;
      }
      curl_setopt($curl, CURLOPT_URL, $url);
      /* Define Content Type */
      curl_setopt($curl, CURLOPT_HTTPHEADER, array('content-type:application/json','Authorization:'.$authorisation.'',));
      /* Return JSON */
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
      // /* new connection instead of cached one */
      curl_setopt($curl, CURLOPT_USERPWD, $username . ":" . $password);
      // curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);
      $result = curl_exec($curl);
      curl_close($curl);
      return $result;
    }

    public function reports(Request $request)
    {
      $user = session('myUserData');
      $method = "POST";
      $postdata = [
        "UserFID" => $user["UserFID"],
        "LabID" => "a76aeb22-c144-4748-a75c-9ba45ea80d8c", 
        "FromDate" => "",
        "ToDate" => "",
        "LabCode" => "",
        "PatientName" => "",
        "UserType" => "1",
        "RequestFor" => 0
      ];
      $postdata = json_encode($postdata);
      // echo $postdata;
      /**POST SERVICE CALL */
      $method = "POST";
      $url = "http://elabcorpsupport.elabassist.com/Services/GlobalUserService.svc/TestReportList";
      // $url = "http://devglobal.elabassist.com/services/globaluserservice.svc/TestReportList";
      $result = $this->callAPI($method, $url, $postdata);
      $data = json_decode($result, true);
      $data = $data["d"];    
      // echo $result;
      /**POST SERVICE CALL */
      // return view('front.reports');
      return view("front/reports",['myreports' => $data]);
    }

    public function Signup(Request $request)
    {
      $method = "POST";
      $postdata = [
        "objSP"=>
        [
          "Task" => "1",
          "UserName" => $_POST["mobilemnumber"],
          "EmailID" => $_POST["email"], 
          "Password" => $_POST["mobilemnumber"],
          "MobileDeviceID" => "",
          "Name" => $_POST["name"],
          "Gender" => $_POST["namegender"],
          "AppID" => "",
          "DOB" => $_POST["birthdate"]
        ]
      ];

      $postdata = json_encode($postdata);
      // echo $postdata;
      /**POST SERVICE CALL */
      $method = "POST";
      $url = "http://elabcorpsupport.elabassist.com/Services/GlobalUserService.svc/UserRegistration";
      // $url = "http://devglobal.elabassist.com/services/globaluserservice.svc/UserRegistration";
      $result = $this->callAPI($method, $url, $postdata);
      $data = json_decode($result, true);
      $data = $data["d"];
      // echo $result;
      if($data["Result"] == "Success" || $data["Result"] == "User Already Exist. Please Contact Support Center.")    
      {
        echo "<script>alert('You are Registered .');</script>";
        echo "<script>window.location.href = '{{url()}}'</script>";
      } else {
        echo "<script>alert('Sign Up Failed .Please contact Zeta Healthcare .');</script>";
        echo "<script>window.location.href = '{{url()}}'</script>";
      }
      // return redirect('HomeController@index');        
    }
    
    public function fnLogout(Request $request) 
    {
      session()->forget('myUserData');
      session()->forget('username');
      session()->flush();
      return 1; 
    }

    public function addProfilesToCart()
    {
        $profiles = $_GET['profiles'];
        $profiles = explode(",", $profiles);
        $_SESSION['cartProItems'] = $profiles;
        echo json_encode($profiles);
    }

    public function callAPI($method, $url, $data = false)
    {
      $curl = curl_init();  
      switch ($method) {
        case "POST":
          curl_setopt($curl, CURLOPT_POST, 1);
          if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
          break;
        case "GET":
          // curl_setopt($curl, CURLOPT_POST,1);
          break;
      }
      curl_setopt($curl, CURLOPT_URL, $url);
      /* Define Content Type */
      curl_setopt($curl, CURLOPT_HTTPHEADER, array('content-type:application/json'));
      /* Return JSON */
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
      // /* new connection instead of cached one */
      // curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);
      $result = curl_exec($curl);
      curl_close($curl);
      return $result;
    }

     public function verifyOtp(Request $request)
    {

      $validator = Validator::make($request->all(), [
              'otp'     => 'required',
          ]);


        if ($validator->fails()) 
        {
            return response()->json([
              'status' => 0, 
              'message'=>$validator->errors()->first()]
              , 200);
        }
          $userData = $request->session()->get('UserData');

          $otp      = trim($request['otp']);
          $res = Customer::where('id', $userData['id'])
                           ->where('otp',$otp)->first();
          
         if($res!='')
         {
             $res->verify_otp = 1;
             $result =  $res->save(); 
             
                return response()->json([
                    'status'  => 1,
                    'message' => 'Your details has been saved successfully.We will contact you soon.',
                ]); 
         }else{
            return response()->json([
                    'status'  => 0,
                    'message' => 'Please try again otp not match.',
                ]);
         }
    }

 public function resendOtp(Request $request)
{

    $userData = $request->session()->get('UserData');

      $otp      = mt_rand(1000,9999);
      $res = Customer::where('id', $userData['id'])->first();
      
      if($res!='')
      {
          $res->verify_otp = 0;
          $res->otp =  $otp;
          $result =  $res->save(); 
          
            return response()->json([
                'status'  => 1,
                'message' => 'Otp has been resend successfully.',
            ]); 
      }else {
        return response()->json([
                'status'  => 0,
                'message' => 'Please try again.',
            ]);
      }
}
  

    public function laboratory_registration(Request $request)
    {

         $city  = DB::table('cities')
                         ->where('status',1)
                         ->orderBy('name','asc')
                         ->get(); 

         $cources  = DB::table('courses')
                         ->where('status',1)
                         ->orderBy('course_name','asc')
                         ->get();                 
      return view('front.registration',compact('city','cources'));
    } 


    public function laboratory_registration_action(Request $request)
    {

      $validator = Validator::make($request->all(), [
              'lab_name'        => 'required|unique:users',
              'mobile'          => 'required|unique:users',
              'email'           => 'required|email|unique:users',
              'city'            => 'required',
              'address'         => 'required',
              'business_permit_no'     => 'required',
              'kra_pin'     => 'required',
              'test_process_name'     => 'required',
              'mpesa_till_no'     => 'required',
              'bank_name_and_branch'   => 'required',
              'bank_name_and_branch'   => 'required',
              'lab_equipments'     => 'required'
          ]);


        if ($validator->fails()) 
        {
            return redirect()->back() ->withErrors($validator)->withInput(); 
        }

          $cources = implode(',', $request['test_process_name']);
         
          $catdata = new User; 
          $catdata->name      = trim($request['lab_name']);
          $catdata->lab_name  = trim($request['lab_name']);
          $catdata->mobile    = trim($request['mobile']);
          $catdata->email     = trim($request['email']); 
          $catdata->city      = trim($request['city']);
          $catdata->address   = trim($request['address']);
          $catdata->business_permit_no   = trim($request['business_permit_no']);
          $catdata->kra_pin   = trim($request['kra_pin']);
          $catdata->test_process_name   = $cources ;

          $catdata->mpesa_till_no   = trim($request['mpesa_till_no']);
          $catdata->bank_name_and_account   = trim($request['bank_name_and_branch']);
          $catdata->account_number   = trim($request['account_number']);


          $catdata->lab_equipments   = trim($request['lab_equipments']);
          $catdata->other_information   = trim($request['other_information']);
          $catdata->national_id   = trim($request['national_id']);
          $catdata->unique_id     = 'Laboratory#'.mt_rand(1000,9999);



           $catdata->role   = 2;
          
          $result =  $catdata->save();  

        if($result)
        {
            return back()->with('success_message','Your details has been saved successfully. We will contact you soon.');
        }else{
            return back()->with('error_message','Please try again.');
        }   

    }


    public function sample_collector_registration(Request $request)
    {

         $city  = DB::table('cities')
                         ->where('status',1)
                         ->orderBy('name','asc')
                         ->get();

         $laboratory  = DB::table('users')
                         ->where('status',1)
                         ->where('is_verify',1)
                         ->where('is_delete',0)
                         ->where('role',2)
                         ->orderBy('name','asc')
                         ->get();                  
      return view('front.sample_collector_registration',compact('city','laboratory'));
    } 

     public function telecaller_registration(Request $request)
    {

         $city  = DB::table('cities')
                         ->where('status',1)
                         ->orderBy('name','asc')
                         ->get(); 
      return view('front.telecaller_registration',compact('city'));
    } 


    public function sample_collector_action(Request $request)
    {

      $validator = Validator::make($request->all(), [
          'name'            => 'required',
          'mobile'          => 'required|unique:users',
          'email'           => 'required|email|unique:users',
          'city'            => 'required',
          'address'         => 'required',
          'lab_name'        => 'required',
          'qualification'   => 'required',
          'image' => 'required|mimes:jpg,png,jpeg|max:10000',
          'certificate' => 'required|mimes:pdf,doc,docs|max:10000'
      ]);


        if ($validator->fails()) 
        {
            return redirect()->back() ->withErrors($validator)->withInput(); 
        }
      $password = mt_rand(10000,999999);  
      $catdata = new User; 

       if ($request->hasFile('image')) 
         {
            $file = array('image' => Input::file('image'));
            $destinationPath = 'public/users/'; 
            $extension = Input::file('image')->getClientOriginalExtension(); 
            $fileName = "image-".date('m-d-Y_hia').rand(1,99999).'.'.$extension;
            Input::file('image')->move($destinationPath, $fileName);
            $catdata->image = $fileName;
          
          } 

          if ($request->hasFile('certificate')) 
         {
            $file = array('certificate' => Input::file('certificate'));
            $destinationPath = 'public/users/'; 
            $extension = Input::file('certificate')->getClientOriginalExtension(); 
            $fileName = "certificate-".date('m-d-Y_hia').rand(1,99999).'.'.$extension;
            Input::file('certificate')->move($destinationPath, $fileName);
            $catdata->certificate = $fileName;
          
          } 


      
      $catdata->name      = trim($request['name']);
      $catdata->mobile    = trim($request['mobile']);
      $catdata->email     = trim($request['email']); 
      $catdata->password     = bcrypt($password); 
      $catdata->show_password  = $password; 
      $catdata->city      = trim($request['city']);
      $catdata->address   = trim($request['address']);
      $catdata->laboratory_id = trim($request['lab_name']);
      $catdata->qualification = trim($request['qualification']);
      $catdata->reference_name = trim($request['reference_name']);

      $catdata->reference_id_no   = trim($request['reference_id_no']);
      $catdata->reference_phone   = trim($request['reference_phone']);
      $catdata->national_id   = trim($request['national_id']);
      $catdata->role = 3;
      $catdata->unique_id     = 'Samplecollector#'.mt_rand(1000,9999);
          
      $result =  $catdata->save();  

        if($result)
        {
            return back()->with('success_message','Your details has been saved successfully. We will contact you soon.');
        }else{
            return back()->with('error_message','Please try again.');
        }   

    }


    public function telecaller_registration_action(Request $request)
    {

      $validator = Validator::make($request->all(), [
          'name'            => 'required',
          'mobile'          => 'required|unique:users',
          'email'           => 'required|email|unique:users',
          'city'            => 'required',
          'address'         => 'required',
          'qualification'   => 'required',
          'image'       => 'required|mimes:jpg,png,jpeg|max:10000',
          'certificate' => 'required|mimes:pdf,doc,docs|max:10000'
      ]);


        if ($validator->fails()) 
        {
            return redirect()->back() ->withErrors($validator)->withInput(); 
        }

      $password = mt_rand(10000,999999);  
      $catdata = new User; 

       if ($request->hasFile('image')) 
         {
            $file = array('image' => Input::file('image'));
            $destinationPath = 'public/users/'; 
            $extension = Input::file('image')->getClientOriginalExtension(); 
            $fileName = "image-".date('m-d-Y_hia').rand(1,99999).'.'.$extension;
            Input::file('image')->move($destinationPath, $fileName);
            $catdata->image = $fileName;
          
          } 

          if ($request->hasFile('certificate')) 
         {
            $file = array('certificate' => Input::file('certificate'));
            $destinationPath = 'public/users/'; 
            $extension = Input::file('certificate')->getClientOriginalExtension(); 
            $fileName = "certificate-".date('m-d-Y_hia').rand(1,99999).'.'.$extension;
            Input::file('certificate')->move($destinationPath, $fileName);
            $catdata->certificate = $fileName;
          
          } 



      $catdata->name      = trim($request['name']);
      $catdata->mobile    = trim($request['mobile']);
      $catdata->email     = trim($request['email']); 
      $catdata->password     = bcrypt($password); 
      $catdata->show_password  = $password; 
      $catdata->city      = trim($request['city']);
      $catdata->address   = trim($request['address']);
      $catdata->qualification = trim($request['qualification']);
      $catdata->reference_name = trim($request['reference_name']);
      $catdata->national_id   = trim($request['national_id']);
      $catdata->reference_id_no   = trim($request['reference_id_no']);
      $catdata->reference_phone   = trim($request['reference_phone']);
      $catdata->role = 4;
      $catdata->unique_id     = 'Telecaller#'.mt_rand(1000,9999);
          
      $result =  $catdata->save();  

        if($result)
        {
            return back()->with('success_message','Your details has been saved successfully. We will contact you soon.');
        }else{
            return back()->with('error_message','Please try again.');
        }   

    }



    

public function contact_action(Request $request)
    {
         $validator = Validator::make($request->all(), [
          'name'          => 'required|string',
		      'email'         => 'required|email',
          'mobile'        => 'required|numeric',
          'comment'       => 'required|string'
          ]);



        if ($validator->fails()) 
        {
            return redirect()->back() ->withErrors($validator)->withInput(); 
        }

         $catdata = new Contact; 
  
          $catdata->name               = trim($request['name']);
          $catdata->mobile             = trim($request['mobile']);
          $catdata->email              = trim($request['email']); 
          $catdata->comments           = trim($request['comment']);
          
          $result =  $catdata->save();  

        if($result)
        {
           return back()->with('success_message','Your details has been saved successfully. We will contact you soon.');
        }else{
            return back()->with('error_message','Please try again.');
        }  

    }


    public function activate_account(Request $request,$email)
    {
       
        if($email!='')
        {
           $res =  DB::table('users')
	                ->where('email', $email)
	                ->update(['is_verify'=>1,'status'=>1]);
            
            return redirect('user-login')->with('success_message', 'Your account has been activated please login.');
            
        }

    }


   public function mailgun($to,$subject,$message)
   {
    
        $data = array(
            'to'        => $to, 
            'subject'   => $subject,
            'from'      => "aafyacare@gmail.com",
            'html'      => $message,
            'sendername'=> 'aafya-care'
        );
        
        Mail::send([], $data, function($message) use ($data) {
            $message->subject($data['subject']);
            $message->from($data['from'],$data['sendername']);
            $message->to($data['to']);
            $message->setBody($data['html'], 'text/html');
        });
        // check for failures
        if (Mail::failures()) {
            return 'false'; // return response showing failed emails
        }else{
            return 'true';  
        }
    }


    //class end

}