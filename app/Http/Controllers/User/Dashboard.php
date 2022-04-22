<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Validator;
use App\User;
use App\Model\Test_paper_result;
use App\Model\User_unscheduled_date;
use Image;
use Input;
use Auth;
use Session;
use DB;
use Excel;
use Carbon\Carbon;
class Dashboard extends Controller
{

    public function index(Request $request)
    {
      $email = Auth::user()->email;
      $data['orders'] = DB::table('customers')
                        ->where('email',$email)
                        ->where('status',1)
                        ->count();

      $data['result'] = 0;                                      

        return view('user.customer.dashboard',compact('data'));
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
            'name'       => 'required',         
            'mobile'     => 'required',      
            'rowid'      => 'required',      
            'city'       => 'required'      
        ]); 

        if ($validator->fails()) {
        $userdata = Auth::user();
        $data['user'] = User::findOrFail($userdata->id);
        return view('user.customer.profile',compact('data'));
        }else{
               $updata = User::findOrFail($request['rowid']);
               $updata->city       = trim($request['city']);
               $updata->name       = trim($request['name']);
               $updata->mobile     = trim($request['mobile']);

               if($request['password']!=''){
                $updata->password       = bcrypt($request['password']);
               }

               $res = $updata->save();
               if($res)
               {
                   return back()->with('success','Profile updated successfully');
               }else{
                   return back()->with('error','Try again!'); 
               } 
        }
    }


    public function orders(Request $request)
    {

        $email = Auth::user()->email;
        $data['list'] = DB::table('customers')
                          ->leftJoin('courses', 'customers.course_id','=','courses.id')
                          ->where('customers.email',$email)
                          ->where('customers.status',1)
                           ->select('customers.*','courses.course_name')
                          ->paginate(20);
       
        return view('user.customer.order_list',compact('data'));    
    }

 public function order_details($id)
    {
      
       $users = DB::table('customers')
                ->leftJoin('courses', 'customers.course_id','=','courses.id')
                ->leftJoin('groups', 'customers.group_id', '=', 'groups.id')
                ->leftJoin('plans', 'customers.plan_id', '=', 'plans.id')
                ->where('customers.id',$id)
                ->select('customers.*', 'groups.name as group_name', 'plans.title as plan_name','courses.course_name')
                ->first(); 

        return view('user.customer.order_view',compact('users'));    
    }


    public function schedule_test_papers(Request $request)
    {
      $email = Auth::user()->email;
      $user = DB::table('customers')
                        ->where('email',$email)
                        ->where('status',1)
                        ->where('schedule_payment',1)
                        ->get();
      
        $uid = array();
        if(count($user)>0){
           foreach ($user as $key) {
             if (!in_array($key->id, $uid))
               { 
                  array_push($uid,$key->id);
               }
           }
        }            

       $data['list'] = DB::table('schedulers')
                            ->leftJoin('courses', 'schedulers.course_id', '=', 'courses.id')
                            ->leftJoin('subjects', 'schedulers.subject_id', '=', 'subjects.id')
                            ->leftJoin('test_types', 'schedulers.test_type', '=', 'test_types.id')
                            ->where('schedulers.status',1)
                            //->where('schedulers.user_id','LIKE','%'.$custid.'%')
                            ->whereIn('schedulers.user_id',$uid)
                            ->select('schedulers.*','courses.course_name','subjects.sub_name','test_types.name as test_type_name')
                            ->orderBy('schedulers.id','DESC')
                            ->paginate(15);

        return view('user.customer.test_paper_list',compact('data'));    

    } 


    public function schedule_test_paper_details(Request $request,$id)
    {
      $email = Auth::user()->email;
      $user = DB::table('customers')
                        ->where('email',$email)
                        ->where('schedule_payment',1)
                        ->where('status',1)
                        ->get();
         
        $uid = array();
        if(count($user)>0){
           foreach ($user as $key) {
             if (!in_array($key->id, $uid))
               { 
                  array_push($uid,$key->id);
               }
           }
        }

      
       $result = DB::table('test_paper_results')
                  ->whereIn('user_id',$uid)
                  ->where('scheduler_id',$id)
                  ->where('status',1)
                  ->first();               


       $data = DB::table('schedulers')
                            ->leftJoin('courses', 'schedulers.course_id', '=', 'courses.id')
                            ->leftJoin('subjects', 'schedulers.subject_id', '=', 'subjects.id')
                            ->leftJoin('test_types', 'schedulers.test_type', '=', 'test_types.id')
                            ->where('schedulers.status',1)
                            //->where('schedulers.user_id','LIKE','%'.$custid.'%')
                            ->whereIn('schedulers.user_id',$uid)
                            ->where('schedulers.id',$id)
                            ->select('schedulers.*','courses.course_name','subjects.sub_name','test_types.name as test_type_name')
                            ->first();
       if($data!=''){
        return view('user.customer.test_paper_details',compact('data','result'));
      }else{
        return redirect()->back()->with('error','Details not found.');
      }
            

    } 

    public function unschedule_test_papers(Request $request)
    {
      $email = Auth::user()->email;
      $user = DB::table('customers')
                        ->where('email',$email)
                        ->where('status',1)
                        ->where('schedule_payment',0)
                        ->get();

       /* if($user!=''){
          $custid = $user->id;
        }else{
          $custid ='#';
        }  */  

         $uid = array();
        if(count($user)>0){
           foreach ($user as $key) {
             if (!in_array($key->id, $uid))
               { 
                  array_push($uid,$key->id);
               }
           }
        }              


       $data['list'] = DB::table('schedulers')
                            ->leftJoin('courses', 'schedulers.course_id', '=', 'courses.id')
                            ->leftJoin('subjects', 'schedulers.subject_id', '=', 'subjects.id')
                            ->leftJoin('test_types', 'schedulers.test_type', '=', 'test_types.id')
                            ->where('schedulers.status',1)
                            //->where('schedulers.user_id','LIKE','%'.$custid.'%')
                            ->whereIn('schedulers.user_id',$uid)
                            ->select('schedulers.*','courses.course_name','subjects.sub_name','test_types.name as test_type_name')
                            ->orderBy('schedulers.id','DESC')
                            ->paginate(15);

        return view('user.customer.unschedule_test_paper_list',compact('data'));    

    } 


    public function unschedule_test_paper_details(Request $request,$id)
    {
      $email = Auth::user()->email;
      $user = DB::table('customers')
                        ->where('email',$email)
                        ->where('status',1)
                        ->where('schedule_payment',0)
                        ->get();
      
         $uid = array();
        if(count($user)>0){
           foreach ($user as $key) {
             if (!in_array($key->id, $uid))
               { 
                  array_push($uid,$key->id);
               }
           }
        }  
         

       $result = DB::table('test_paper_results')
                  ->whereIn('user_id',$uid)
                  ->where('scheduler_id',$id)
                  ->where('status',1)
                  ->first();               

       $unschedule_date = DB::table('user_unscheduled_dates')
                      ->whereIn('user_id',$uid)
                      ->where('scheduler_id',$id)
                      ->first();

       $data = DB::table('schedulers')
                            ->leftJoin('courses', 'schedulers.course_id', '=', 'courses.id')
                            ->leftJoin('subjects', 'schedulers.subject_id', '=', 'subjects.id')
                            ->leftJoin('test_types', 'schedulers.test_type', '=', 'test_types.id')
                            ->where('schedulers.status',1)
                            //->where('schedulers.user_id','LIKE','%'.$custid.'%')
                            ->where('schedulers.user_id',$uid)
                            ->where('schedulers.id',$id)
                            ->select('schedulers.*','courses.course_name','subjects.sub_name','test_types.name as test_type_name')
                            ->first();

        return view('user.customer.unschedule_test_paper_details',compact('data','result','unschedule_date'));    
    }

     


    public function upload_answer_pdf(Request $request)
    {
       
       $validator = Validator::make($request->all(), [
              'answer_pdf'         => 'required|mimes:pdf|max:10000'
          ]);

        if ($validator->fails()) 
        {
            return redirect()->back() ->withErrors($validator)->withInput(); 
        }

  
          $catdata = new Test_paper_result; 
          $scheduler_id = trim($request['scheduler_id']);
          $custid = trim($request['custid']);


          $scheduler = DB::table('schedulers')->where(['id'=>$scheduler_id])->first(); 
              $course_id   = $scheduler->course_id;
              $sub_id      = $scheduler->subject_id;
              $course      = DB::table('courses')->where('id',$course_id)->first(); 
              $subjects    = DB::table('subjects')->where('id',$sub_id)->first(); 

              $cnm = explode(' ', $course->course_name);
              $snm = explode(' ', $subjects->sub_name);
              $qpdf = "";
              $spdf = "";
              if($cnm!='')
              {
                 foreach ($cnm as $row) 
                 {
                    if($row!="(" && $row!=")" && $row!="&" && $row!=":" && $row!="")
                    {
                      $qpdf.= strtolower(substr($row,0,1)); 
                    }
                 }
              }

              if($snm!='')
              {
                 foreach ($snm as $row) 
                 {
                    if($row!="(" && $row!=")" && $row!="&" && $row!=":" && $row!=""  && $row!="-")
                    {
                      $spdf.= strtolower(substr($row,0,1)); 
                    }
                 }
              }

          $answer_pdf_name            =  $qpdf."-".$spdf."-answer-".date('m-d-Y_hia') ;
          $catdata->user_id           = $custid;
          $catdata->scheduler_id      = trim($request['scheduler_id']);
          $catdata->uploaded_date     = date("Y-m-d");
         
          if ($request->hasFile('answer_pdf'))
           {
              $file = array('answer_pdf' => Input::file('answer_pdf'));
              $destinationPath = 'public/answer_pdf/'; 
              $extension = Input::file('answer_pdf')->getClientOriginalExtension(); 
              $fileName = $answer_pdf_name.'.'.$extension;
              Input::file('answer_pdf')->move($destinationPath, $fileName);
               $catdata->answer_pdf = $fileName;
            } 
          
          $result =  $catdata->save();  

          if($result)
          {
              return redirect()->back()->with('success','Details has been saved successfully.');
          }else{
              return redirect()->back()->with('error','Try again.');
          }          

    } 



  public function add_user_unschedule_date(Request $request)
    {
       $validator = Validator::make($request->all(), [
              'user_unschedule_date' => 'required'
          ]);

        if ($validator->fails()) 
        {
            return redirect()->back() ->withErrors($validator)->withInput(); 
        }
         $undt = date('Y-m-d',strtotime(trim($request['user_unschedule_date'])));
  
          $catdata = new User_unscheduled_date;
          $catdata->user_id           = trim($request['custid']);
          $catdata->scheduler_id      = trim($request['scheduler_id']);
          $catdata->unscheduled_date  = $undt;
        
          
          $result =  $catdata->save();  

          if($result)
          {
              return redirect()->back()->with('success','Details has been saved successfully.');
          }else{
              return redirect()->back()->with('error','Try again.');
          }          

    }






    

    
   

    //class end
}