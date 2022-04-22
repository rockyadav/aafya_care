<?php



namespace App\Http\Controllers\Admin;



use Illuminate\Http\Request;

use Validator;

use App\Model\Subject;
use App\Model\Scheduler;
use App\Model\Test_paper_result;
use Image;
use Input;
use Auth;
use DB;
use Mail;
use Carbon\Carbon;

class SchedulerController extends Controller

{

   public function get_subject_list_new(Request $request)
    {  
       
        $models = DB::table("subjects")
                    ->where("course_id",$request->course_id)
                    ->orderBy("sub_name","ASC")
                    ->pluck("sub_name","id");
        
        return response()->json($models);

    }

     public function get_subject_list(Request $request)
    {  
        $data = array();
        $models = DB::table("subjects")
                    ->where("course_id",$request->course_id)
                    ->orderBy("sub_name","ASC")
                    ->pluck("sub_name","id");

        $plans = DB::table("plans")
                    ->where("course_id",$request->course_id)
                    ->orderBy("title","ASC")
                    ->pluck("title","id");
                                
        $data['subject'] =   $models;         
        $data['plans']   =   $plans;         
        return response()->json($data);

    }

    public function get_user_list(Request $request,$cid,$sid,$pid,$plan_id)
    {  
      
        $customer = DB::table("customers")
                    ->where("course_id",$cid)
                    ->where("status",1)
                    ->where("subject_id","LIKE",'%'.$sid.'%')
                    ->where("test_type_id","LIKE",'%'.$pid.'%')
                    ->where("plan_id","LIKE",'%'.$plan_id.'%')
                    ->orderBy("name","ASC")
                    ->pluck("name","id");
        return response()->json($customer);

    }


    public function index(Request $request)

    {

		   $data['list'] = DB::table('schedulers')
                            ->leftJoin('courses', 'schedulers.course_id', '=', 'courses.id')
                            ->leftJoin('subjects', 'schedulers.subject_id', '=', 'subjects.id')
                            ->leftJoin('test_types', 'schedulers.test_type', '=', 'test_types.id')
                            ->where('schedulers.status',1)
                            ->select('schedulers.*','courses.course_name','subjects.sub_name','test_types.name as test_type_name')
                            ->orderBy('schedulers.id','DESC')
                            ->paginate(15);

        return view('admin.scheduler.list',compact('data'));    

    } 

    public function scheduler_details(Request $request,$id)

    {

       $data = DB::table('schedulers')
                            ->leftJoin('courses', 'schedulers.course_id', '=', 'courses.id')
                            ->leftJoin('subjects', 'schedulers.subject_id', '=', 'subjects.id')
                            ->leftJoin('test_types', 'schedulers.test_type', '=', 'test_types.id')
                            ->where('schedulers.status',1)
                            ->where('schedulers.id',$id)
                            ->select('schedulers.*','courses.course_name','subjects.sub_name','test_types.name as test_type_name')
                            ->orderBy('schedulers.id','DESC')
                            ->first();

        return view('admin.scheduler.view',compact('data'));    

    }


    public function create()
    {
        $courses   = DB::table('courses')->where('status',1)->get();
        $test_type = DB::table('test_types')->where('status',1)->get();
        return view('admin.scheduler.add',compact('courses','test_type'));
    }


    public function store(Request $request)
    {

       $validator = Validator::make($request->all(), [
              'course'              => 'required',
              'subject'             => 'required',
              'plan_id'             => 'required',
              'test_type'           => 'required',
              'user_id'             => 'required',
              'schedule_date'       => 'required',
              'unschedule_date'     => 'required',
              'message'             => 'required',
              'paper_name'          => 'required',
              'pdf_file'            => 'required|mimes:pdf|max:10000',
              'example_answer_pdf'  => 'mimes:pdf|max:10000'

          ]);


        if ($validator->fails()) 
        {
            return redirect()->back() ->withErrors($validator)->withInput(); 
        }

  
          $catdata = new Scheduler;

          $course_id   = trim($request['course']);
          $sub_id      = trim($request['subject']);
          $course      = DB::table('courses')->where('id',$course_id)->first(); 
          $subjects    = DB::table('subjects')->where('id',$sub_id)->first(); 

          $cnm = explode(' ', $course->course_name);
          $snm =  explode(' ',$subjects->sub_name);
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

         $questio_pdf_name =  $qpdf."-".$spdf."-question-".date('m-d-Y_hia') ; 
         $ex_ans_pdf_name  =  $qpdf."-".$spdf."-example-answer-".date('m-d-Y_hia') ; 

          $catdata->paper_name        = trim($request['paper_name']);
          $catdata->user_id           = implode(',', $request['user_id']);
          $catdata->course_id         = trim($request['course']);
          $catdata->plan_id           = trim($request['plan_id']);
          $catdata->subject_id        = trim($request['subject']); 
          $catdata->test_type         = trim($request['test_type']);
          $catdata->schedule_date     = date("Y-m-d",strtotime(trim($request['schedule_date'])));
          $catdata->unschedule_date   =  date("Y-m-d",strtotime(trim($request['unschedule_date']))); 
          $catdata->message           = trim($request['message']);

          if ($request->hasFile('pdf_file'))
           {
              $file = array('pdf_file' => Input::file('pdf_file'));
              $destinationPath = 'public/schedule_pdf/'; 
              $extension = Input::file('pdf_file')->getClientOriginalExtension(); 
              $fileName = $questio_pdf_name.'.'.$extension;
              Input::file('pdf_file')->move($destinationPath, $fileName);
               $catdata->pdf_file = $fileName;
            } 

          if ($request->hasFile('example_answer_pdf'))
           {
              $file = array('example_answer_pdf' => Input::file('example_answer_pdf'));
              $destinationPath = 'public/schedule_pdf/'; 
              $extension = Input::file('example_answer_pdf')->getClientOriginalExtension(); 
              $fileName = $ex_ans_pdf_name.'.'.$extension;
              Input::file('example_answer_pdf')->move($destinationPath, $fileName);
               $catdata->example_answer_pdf = $fileName;
            } 
          
          $result =  $catdata->save();  

          if($result)
          {
              $users = $request['user_id'];
              if(!empty($users))
              {
                foreach ($users as $us)
                {
                  if($us!='')
                  {
                     $customer = DB::table('customers')->where('id',$us)->first();
                     if($customer!='')
                     {
                       $cname = $course->course_name;
                       $sname = $subjects->sub_name;
                       $tname = trim($request['paper_name']);
                       $sdate = trim($request['schedule_date']);
                       $to      = $customer->email;  
                       $name    = $customer->name;  
                       $subject = "Test paper details";
                       $message =  view('mail.schedule_mail',compact('name','cname','sname','sdate','tname'));
                       $check = $this->mailgun($to,$subject,$message);
                     }
                  }
                }

              }
              return redirect('admin/scheduler')->with('success','Details has been saved successfully.');
          }else{
              return back()->with('error','Try again.');
          }               

    }



    

    public function edit(Request $request,$id)
    {

        $scheduler = Scheduler::where('id' ,$id)->first();
        $cid = $scheduler->course_id;
        $sid = $scheduler->subject_id;
        $pid = $scheduler->test_type;
        $plan_id = $scheduler->plan_id;
        $courses = DB::table('courses')->where('status',1)->get();
        $subject  = DB::table('subjects')->where('course_id' ,$scheduler->course_id)->get();
        $plans  = DB::table('plans')->where('course_id' ,$scheduler->course_id)->get();
        $test_type  = DB::table('test_types')->where('status' ,1)->get();
        $users  = DB::table("customers")
                    ->where("course_id",$cid)
                    ->where("status",1)
                    ->where("subject_id","LIKE",'%'.$sid.'%')
                    ->where("test_type_id","LIKE",'%'.$pid.'%')
                    ->where("plan_id","LIKE",'%'.$plan_id.'%')
                    ->orderBy("name","ASC")
                    ->get();

        return view('admin.scheduler.edit',compact('scheduler','courses','subject','users','test_type','plans'));

    }



   

    public function update(Request $request,$id)
    {
         $validator = Validator::make($request->all(), [
              'course'              => 'required',
              'plan_id'             => 'required',
              'paper_name'          => 'required',
              'subject'             => 'required',
              'test_type'           => 'required',
              'user_id'             => 'required',
              'schedule_date'       => 'required',
              'unschedule_date'     => 'required',
              'message'             => 'required',
              'pdf_file'            => 'mimes:pdf|max:10000',
              'example_answer_pdf'  => 'mimes:pdf|max:10000'

          ]);


        if ($validator->fails()) 
        {
            return redirect()->back() ->withErrors($validator)->withInput(); 
        }

          $catdata = Scheduler::findOrFail($id); 

         
          $catdata->paper_name        = trim($request['paper_name']);
          $catdata->user_id           = implode(',', $request['user_id']);
          $catdata->course_id         = trim($request['course']);
          $catdata->subject_id        = trim($request['subject']); 
          $catdata->plan_id           = trim($request['plan_id']); 
          $catdata->test_type         = trim($request['test_type']);
          $catdata->schedule_date     = date("Y-m-d",strtotime(trim($request['schedule_date'])));
          $catdata->unschedule_date   =  date("Y-m-d",strtotime(trim($request['unschedule_date']))); 
          $catdata->message           = trim($request['message']);

          $course_id   = trim($request['course']);
          $sub_id      = trim($request['subject']);
          $course      = DB::table('courses')->where('id',$course_id)->first(); 
          $subjects    = DB::table('subjects')->where('id',$sub_id)->first(); 

          $cnm = explode(' ', $course->course_name);
          $snm =  explode(' ',$subjects->sub_name);
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

         $questio_pdf_name =  $qpdf."-".$spdf."-question-".date('m-d-Y_hia') ; 
         $ex_ans_pdf_name  =  $qpdf."-".$spdf."-example-answer-".date('m-d-Y_hia') ; 



          if ($request->hasFile('pdf_file'))
           {

             if($catdata->pdf_file!=''){
               unlink('public/schedule_pdf/'.$catdata->pdf_file);
             }
              $file = array('pdf_file' => Input::file('pdf_file'));
              $destinationPath = 'public/schedule_pdf/'; 
              $extension = Input::file('pdf_file')->getClientOriginalExtension(); 
              $fileName = $questio_pdf_name.'.'.$extension;
              Input::file('pdf_file')->move($destinationPath, $fileName);
               $catdata->pdf_file = $fileName;
            } 

            if ($request->hasFile('example_answer_pdf'))
           {

              if($catdata->example_answer_pdf!=''){
               unlink('public/schedule_pdf/'.$catdata->example_answer_pdf);
              }
              $file = array('example_answer_pdf' => Input::file('example_answer_pdf'));
              $destinationPath = 'public/schedule_pdf/'; 
              $extension = Input::file('example_answer_pdf')->getClientOriginalExtension(); 
              $fileName = $ex_ans_pdf_name.'.'.$extension;
              Input::file('example_answer_pdf')->move($destinationPath, $fileName);
               $catdata->example_answer_pdf = $fileName;
            } 
         $result =  $catdata->save();  

        if($result)
        {

              $users = $request['user_id'];
              if(!empty($users))
              {
                foreach ($users as $us)
                {
                  if($us!='')
                  {
                     $customer = DB::table('customers')->where('id',$us)->first();
                     if($customer!='')
                     {
                       $cname = $course->course_name;
                       $sname = $subjects->sub_name;
                       $tname = trim($request['paper_name']);
                       $sdate = trim($request['schedule_date']);
                       $to      = $customer->email;  
                       $name    = $customer->name;  
                       $subject = "Test paper details";
                       $message =  view('mail.schedule_mail',compact('name','cname','sname','sdate','tname'));
                       $check = $this->mailgun($to,$subject,$message);
                     }
                  }
                }

              }

            return back()->with('success','Details has been updated successfully.');
        }else{
            return back()->with('error','Try again.');
        } 
    }


    public function destroy(Request $request,$id)
    {
        $catdata = Scheduler::where('id', $id)->first();

         if($catdata->example_answer_pdf!='')
         {
            unlink('public/schedule_pdf/'.$catdata->example_answer_pdf);
         }

         if($catdata->pdf_file!='')
         {
            unlink('public/schedule_pdf/'.$catdata->pdf_file);
         }
      
       $res = $catdata->delete();
        if($res)
        {
           echo 'success'; 
        }else{
                echo 'error';  
        }
    }



    public function upload_result(Request $request)
    {
         $validator = Validator::make($request->all(), [
              'user_id'         => 'required',
              'scheduler_id'    => 'required',
              'total_marks'     => 'required',
              'notes'           => 'required',
              'result_pdf'      => 'mimes:pdf|max:100000'

          ]);


        if ($validator->fails()) 
        {
            $response['status'] ="0"; 
            $response['msg']    ="All fields required."; 
        }
           
        $user_id =  trim($request['user_id']);
        $scheduler_id =  trim($request['scheduler_id']);

          $catdata = Test_paper_result::where(['user_id'=>$user_id,'scheduler_id'=>$scheduler_id])->first(); 
          if($catdata!='')
          {

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

             $result_pdf_name =  $qpdf."-".$spdf."-result-".date('m-d-Y_hia') ; 
         


            $catdata->notes         = trim($request['notes']);
            $catdata->total_marks   = trim($request['total_marks']);

             if ($request->hasFile('result_pdf'))
             {
                $file = array('result_pdf' => Input::file('result_pdf'));
                $destinationPath = 'public/answer_pdf/'; 
                $extension = Input::file('result_pdf')->getClientOriginalExtension(); 
                $fileName = $result_pdf_name.'.'.$extension;
                Input::file('result_pdf')->move($destinationPath, $fileName);
                 $catdata->result_pdf = $fileName;
              } 

             $result =  $catdata->save();

             if($result)
              {
                 $response['status'] = "1"; 
                 $response['msg']    = "Result uploaded successfully.";
              }else{
                  $response['status'] = "0"; 
                  $response['msg']    = "Something went wrong please try again.";
              }   

          }else{
               $response['status'] ="0"; 
               $response['msg']    ="Please try again.";
          }

          return json_encode($response);

    }

    
    public function get_result_data($uid,$sid)
    { 
        $catdata=Test_paper_result::where(['user_id'=>$uid,'scheduler_id'=>$sid])->first();

          if($catdata!='')
          {
               $response['status']  = "1"; 
               $response['result']  = $catdata;

          }else{
               $response['status'] = "0"; 
               $response['msg']    = "Please try again.";
          }

          return json_encode($response);

    }



     public function send_answersheet_mail(Request $request)
    {
         $validator = Validator::make($request->all(), [
              'user_id'         => 'required',
              'scheduler_id'    => 'required',
              'mail_to'         => 'required|email'
          ]);


        if ($validator->fails()) 
        {
            $response['status'] ="0"; 
            $response['msg']    ="Email fields required or valid email."; 
        }
           
        $user_id      =  trim($request['user_id']);
        $scheduler_id =  trim($request['scheduler_id']);
        $email        =  trim($request['mail_to']);

        $data = Test_paper_result::where(['user_id'=>$user_id,'scheduler_id'=>$scheduler_id])->first(); 
          if($data!='')
          {
              $user = DB::table('customers')->where(['id'=>$user_id])->first();
              $to      = $email;
              $subject = "User answer sheet details";
              $message =  view('mail.answer_sheet_mail',compact('data','user'));

              $check = $this->mailgun($to,$subject,$message);
              if($check){
                   $response['status'] = "1"; 
                   $response['msg']    = "Mail has been sent successfully";
              }else{
                  $response['status'] ="0"; 
                  $response['msg']    ="Something went wrong please try again.";
              }

          }else{
               $response['status'] ="0"; 
               $response['msg']    ="Please try again.";
          }

          return json_encode($response);

    }


  public function download_ans_pdf(Request $request,$id)
    {
            $res = DB::table('test_paper_results')
                    ->where('id', $id)
                    ->update(['admin_anspdf_downloaded' => 1]);
          echo "success";          
    }


    public function mailgun($to,$subject,$message)
   {
    
        $data = array(
            'to'        => $to, 
            'subject'   => $subject,
            'from'      => "fasttestseries@gmail.com",
            'html'      => $message,
            'sendername'=> 'fasttest-series'
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

