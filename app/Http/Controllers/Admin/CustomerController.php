<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Validator;
use App\User;
use App\Model\Customer;
use Image;
use Input;
use Auth;
use DB;
use Carbon\Carbon;
use File;
use Excel;
use Mail;

class CustomerController extends Controller
{
   

    public function customers(Request $request)
    {
       
        $data['list'] = DB::table('customers')
		                 ->leftJoin('cities', 'customers.city', '=', 'cities.id')
                         ->leftJoin('courses', 'customers.test_id', '=', 'courses.id')
                         ->where('customers.is_delete',1)
						 ->select('customers.*','courses.course_name','cities.name as city_name')
                         ->orderBy('customers.id','DESC')
                         ->paginate(20);
        return view('admin.users.list',compact('data'));    
    }


   
    public function user_destroy(Request $request,$id)
    {
        
        $res =  DB::table('customers')
                ->where('id', $id)
                ->update(['is_delete' => 0]);
        if($res)
        {
           echo 'success'; 
        }else{
                echo 'error';  
        }
    }


    public function user_details($id)
    {
      
       $users = DB::table('customers')
		                 ->leftJoin('cities', 'customers.city', '=', 'cities.id')
                         ->leftJoin('courses', 'customers.test_id', '=', 'courses.id')
                         ->where('customers.is_delete',1)
						 ->where('customers.id',$id)
						 ->select('customers.*','courses.course_name','cities.name as city_name')
                         ->orderBy('customers.id','DESC')
                         ->first(); 

        return view('admin.users.view',compact('users'));    
    }


  public function export_users(Request $request)
  {
     $validator = Validator::make($request->all(), [
          'fdate'     => 'required',
          'tdate'     => 'required'
          ]);

        if ($validator->fails()) 
        {
            return redirect()->back() ->withErrors($validator)->withInput(); 
        }

          $from = date("Y-m-d",strtotime(trim($request['fdate']))); 
          $to   = date("Y-m-d",strtotime(trim($request['tdate'])));
          if($from > $to){
              return back()->with('error','From date greater than to date.');
          }

         $data = DB::table('customers')
                ->leftJoin('courses', 'customers.course_id','=','courses.id')
                ->leftJoin('groups', 'customers.group_id', '=', 'groups.id')
                ->leftJoin('plans', 'customers.plan_id', '=', 'plans.id')
                ->whereBetween('customers.cdate', [$from, $to])
                ->select('customers.*', 'groups.name as group_name', 'plans.title as plan_name','courses.course_name')
                ->get();

            $items = [];

            if(count($data)>0)
            {
              foreach($data as $row)
              {

                  $gAry = explode(",",$row->group_id);
                  $gname = DB::table('groups')->whereIn('id',$gAry)->get();
                  $groupname =""; 
                  $subname   ="";
                   if(count($gname)>0)
                   {
                      $i=0;
                      foreach($gname as $s)
                      { 
                        $groupname.= $s->name.','; 
                      }
                    }else{
                          $groupname =  "N/A";
                    }

                     $serAry = explode(",",$row->subject_id); 
                     $sname = DB::table('subjects')->whereIn('id',$serAry)->get();
                         if(count($sname)>0)
                         {
                            $i=0;
                            foreach($sname as $s)
                            {
                                $i++;
                               $subname = $s->sub_name.','; 
                            }
                         }else{
                               $subname =  "N/A";
                         } 

                 $new = [
                           'Name'=>$row->name,
                           'Email'=>$row->email,
                           'Mobile'=>$row->mobile,
                           'City'=> $row->city,
                           'Amount'=>$row->amount =='' ? 'N/A': $row->amount,
                           'Attempt Due'=>$row->attempt_due =='' ? 'N/A': $row->attempt_due,
                           'Transaction Mode'=>$row->transaction_mode =='' ? 'N/A': $row->transaction_mode,
                           'Transaction Id'=> $row->transaction_id =='' ? 'N/A': $row->transaction_id,
                           'Transaction Date'=>$row->transaction_date =='' ? 'N/A': date('d-m-Y',strtotime($row->transaction_date)),
                           'Course Name'=>$row->course_name =='' ? 'N/A': $row->course_name,
                           'Group Name'=>$groupname,
                           'Plan Name'=> $row->plan_name =='' ? 'N/A': $row->plan_name,
                           'Schedule/Unschedule'=>$row->schedule_payment =='1' ? 'Schedule': 'Unschedule',
                           'Counseling (Free)'=>$row->counsuling_fee =='1' ? 'Yes': 'No',
                           'Subject Name'=>$subname
                           
                        ];
                  array_push($items, $new);

              }

            }else{
                 return back()->with('error','Users not found.');
            }

              Excel::create('user-list', function($excel) use($items) {
                $excel->sheet('ExportFile', function($sheet) use($items) {
                    $sheet->fromArray($items, '0', 'A1', true);
                });
            })->export('xls');
          
    }

public function demo()
    {
       $users = DB::table('customers')->get(); 
        if(count($users)>0)
          {
            $i=0;
            foreach($users as $row)
            {
              $dt = date("Y-m-d",strtotime($row->created_date));
              $id = $row->id;
              $res = DB::table('customers')
                ->where('id', $id)
                ->update(['cdate' => $dt]);
                if($res){
                   $i++;
                }
            }
            echo $i;
          }    
    }



  public function update_payment_status(Request $request)
    {
       $validator = Validator::make($request->all(), [
        'cust_id'            => 'required',
        'payment_status'     => 'required',
      
        ]);
 
        if ($validator->fails()) 
        {
            return redirect()->back() ->withErrors($validator)->withInput(); 
        }

        $cid = trim($request['cust_id']); 
        $status = trim($request['payment_status']);
  
        $user = DB::table('customers')
            ->leftJoin('courses', 'customers.course_id','=','courses.id')
            ->where('customers.id', $cid)
            ->select('customers.*', 'courses.course_name')
            ->first();

        $result =  DB::table('customers')
                    ->where('id', $cid)
                    ->update(['status' => $status,'transaction_mode'=>'Manual','transaction_date'=>date('d-m-Y'),'transaction_id'=>'Updated By Admin']); 
        if($status==1)
        {

          $to      = $user->email;
          $subject = "Payment done for fasttest-series";
          $user->message = "Your payment has been successfully done for fasttest-series";
           
          $message =  view('mail.payment',compact('user'));

          $this->mailgun($to,$subject,$message);

        }             
        
        return redirect()->back()->with('success','Payment status has been updated successfully.');
                     
        
        
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

//laboratory
public function laboratoryUsers(Request $request)
{
       
        $data['list'] = DB::table('users')
                     ->leftJoin('cities', 'users.city', '=', 'cities.id')
                      ->where('users.is_delete',0)
                      ->where('users.role',2)
                      ->select('users.*','cities.name as city_name')
                      ->orderBy('users.id','DESC')
                      ->paginate(20);
        return view('admin.users.laboratory',compact('data'));    
}

public function laboratoryUserDetails(Request $request,$id)
{
       
        $users = DB::table('users')
                     ->leftJoin('cities', 'users.city', '=', 'cities.id')
                      ->where('users.is_delete',0)
                      ->where('users.role',2)
                      ->where('users.id',$id)
                      ->select('users.*','cities.name as city_name')
                      ->orderBy('users.id','DESC')
                      ->first();
        return view('admin.users.laboratory-details',compact('users'));    
}

 public function laboratoryVerify($id){
        
      $item = User::find($id);
      if(($item->is_verify)=='1'){
          $item->is_verify = '0';
      } else {
          $item->is_verify = '1';
      }
      $item->save();
} 

public function laboratoryDestroy(Request $request,$id)
  {
     $check = User::where('id', $id)->first();
      
      if($check!='')
      {
          User::where('id', $id)->update(array('is_delete'=>1));
          echo 'success';
      }else{
          echo 'error';

      } 

  }



// sample Collectors
public function sampleCollectors(Request $request)
  {
       
        $data['list'] = DB::table('users')
                     ->leftJoin('cities', 'users.city', '=', 'cities.id')
                      ->where('users.is_delete',0)
                      ->where('users.role',3)
                      ->select('users.*','cities.name as city_name')
                      ->orderBy('users.id','DESC')
                      ->paginate(20);
        return view('admin.users.sample-collectors',compact('data'));    
  }

  public function sampleCollectorDetails(Request $request,$id)
  {
       
        $users = DB::table('users')
                     ->leftJoin('cities', 'users.city', '=', 'cities.id')
                      ->where('users.is_delete',0)
                      ->where('users.role',3)
                      ->where('users.id',$id)
                      ->select('users.*','cities.name as city_name')
                      ->orderBy('users.id','DESC')
                      ->first();
        return view('admin.users.sample-collector-details',compact('users'));    
  }

public function sampleCollectorChangeStatus($id){
        
      $item = User::find($id);
      if(($item->status)=='1'){
          $item->status = '0';
      } else {
          $item->status = '1';
      }
      $item->save();
} 

public function sampleCollectorDestroy(Request $request,$id)
  {
     $check = User::where('id', $id)->first();
      
      if($check!='')
      {
          User::where('id', $id)->update(array('is_delete'=>1));
          echo 'success';
      }else{
          echo 'error';

      } 

  }

// telecallers

public function telecallers(Request $request)
 {
       
        $data['list'] = DB::table('users')
                     ->leftJoin('cities', 'users.city', '=', 'cities.id')
                      ->where('users.is_delete',0)
                      ->where('users.role',4)
                      ->select('users.*','cities.name as city_name')
                      ->orderBy('users.id','DESC')
                      ->paginate(20);
        return view('admin.users.telecallers',compact('data'));    
 }

 public function telecallerDetails(Request $request,$id)
 {
      $users  = DB::table('users')
                     ->leftJoin('cities', 'users.city', '=', 'cities.id')
                      ->where('users.is_delete',0)
                      ->where('users.role',4)
                      ->where('users.id',$id)
                      ->select('users.*','cities.name as city_name')
                      ->orderBy('users.id','DESC')
                      ->first();
        return view('admin.users.telecaller-details',compact('users'));    
 }

 public function telecallerChangeStatus($id){
        
      $item = User::find($id);
      if(($item->status)=='1'){
          $item->status = '0';
      } else {
          $item->status = '1';
      }
      $item->save();
} 

public function telecallerDestroy(Request $request,$id)
  {
     $check = User::where('id', $id)->first();
      
      if($check!='')
      {
          User::where('id', $id)->update(array('is_delete'=>1));
          echo 'success';
      }else{
          echo 'error';

      } 

  } 

	
//class end
}

?>