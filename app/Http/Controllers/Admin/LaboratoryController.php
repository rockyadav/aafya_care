<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use Validator;
use App\User;
use App\Model\Customer;
use App\Model\Report;
use Image;
use Input;
use Auth;
use DB;
use Carbon\Carbon;

class LaboratoryController extends Controller
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

        return view('laboratory.profile',compact('data'));

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
        $user = Auth::user() ;
        $city = $user['city']; 

        $data['list'] = DB::table('customers')
                     ->leftJoin('cities', 'customers.city', '=', 'cities.id')
                     ->leftJoin('courses', 'customers.test_id', '=', 'courses.id')
                      ->where('customers.is_delete',1)
                      ->where('customers.city',$city)
                      ->select('customers.*','courses.course_name','cities.name as city_name')
                       ->orderBy('customers.id','DESC')
                      ->get();
        return view('laboratory.users.list',compact('data'));    
    }

    public function customer_details($id)
    {
      $id = base64_decode($id);
       $users = DB::table('customers')
                     ->leftJoin('cities', 'customers.city', '=', 'cities.id')
                         ->leftJoin('courses', 'customers.test_id', '=', 'courses.id')
                         ->where('customers.is_delete',1)
             ->where('customers.id',$id)
             ->select('customers.*','courses.course_name','cities.name as city_name')
                         ->orderBy('customers.id','DESC')
                         ->first(); 

        return view('laboratory.users.view',compact('users'));    
    }


    public function SubmittedLaboratory(Request $request)
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
                  ->update(array('status' => $status,'sample_submitted_date'=>date('d-m-Y h:s:a')));  

           return redirect()->back()->with('success_message','Your status has been updated successfully.');

        }else{

            return back()->with('error_message','Please try again.');
        }                
 
    }


  public function laboratoryGenerateReport(Request $request,$id)
  {
        $user = Auth::user();
        $city = $user['city']; 
        $id = base64_decode($id); 
        $user = DB::table('customers')
                     ->leftJoin('cities', 'customers.city', '=', 'cities.id')
                     ->join('courses', 'customers.test_id', '=', 'courses.id')
                      ->where('customers.is_delete',1)
                      ->where('customers.id',$id)
                      ->select('customers.*','courses.course_name','cities.name as city_name')
                      ->first();

                      //print_r($user); die;

        $test = DB::table('course_perameters')
                      ->where('course_id',$user->test_id)
                      ->get();

                      
                     

        $report = Report::where(['test_id'=>$user->test_id,'user_id'=>$id])->first();  

        return view('laboratory.generate-report',compact('user','test','report'));    
        //return view('laboratory.report',compact('user','test','report'));    
  }



  


  public function generateReportAction(Request $request)
    {
      $validator = Validator::make($request->all(), [
              'user_id'  => 'required',
              'test_id'  => 'required',
              'values'   => 'required',
              'reviewed_by'   => 'required'
          ]);


        if ($validator->fails()) 
        {
             return redirect()->back() ->withErrors($validator)->withInput(); 
        }

       
       $user_id = trim($request['user_id']);
       $reviewed_by  = trim($request['reviewed_by']);
       $test_id = $request['test_id']; 
       $valuess  = $request['values']; 
       $lab_id  = Auth::user()->id;

       $check = Report::where(['test_id'=>$test_id,'user_id'=>$user_id])->first();
       if($check!='')
       {
         $cdata = $check;
       }else{


         $cdata = new Report;
         $cdata->report_no = "AAFYACARE#R".mt_rand(1000,9999);
       }


      //print_r(json_encode($valuess)); die;

         $cdata->user_id        = $user_id;
         $cdata->laboratory_id  = $lab_id;
         $cdata->test_id        = $test_id;
         $cdata->reviewed_by    = $reviewed_by;
         $cdata->report_date    = date('d-m-Y');
         $cdata->p_values       = json_encode($valuess);
         $res = $cdata->save();
         if($res)
         {
            DB::table('customers')
                      ->where('id',$user_id)
                      ->where('test_id',$test_id)
                      ->update(array('report_generated_date'=>date('d-m-Y h:i:sa'),'status'=>"Report Generated")); 

             return back()->with('success','Report has been generated successfully');
         }else{
             return back()->with('error','Try again!'); 
         } 
    }


  public function laboratoryDownloadReport(Request $request,$id)
  {
        $userData = Auth::user();
        $city = $userData['city']; 
        $id = base64_decode($id); 

        $report = Report::where('id',$id)->first();

      if($report)
      {

          $test = DB::table('course_perameters')
                        ->where('course_id',$report->test_id)
                        ->get();
          

          $user = DB::table('customers')
                       ->leftJoin('cities', 'customers.city', '=', 'cities.id')
                       ->join('courses', 'customers.test_id', '=', 'courses.id')
                        ->where('customers.is_delete',1)
                        ->where('customers.id',$report->user_id)
                        ->select('customers.*','courses.course_name','cities.name as city_name')
                        ->first();

          return view('laboratory.report',compact('user','test','report')); 
      }else{
        return redirect()->back();
      }   
  }




    //class end

}

