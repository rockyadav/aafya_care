<?php



namespace App\Http\Controllers\Admin;



use Illuminate\Http\Request;

use App\Model\Plan;

use Validator;

use App\User;

use Image;

use Input;

use Auth;

use DB;

use Carbon\Carbon;

use File;





class PlanController extends Controller

{



	public function index(Request $request)

    {

		

	    $data['list'] = DB::table('plans')
                      ->leftJoin("courses","plans.course_id","=","courses.id")
                       ->where('plans.status',1)
                       ->orderBy('plans.id','DESC')
                       ->select('plans.*','courses.course_name')
                       ->paginate(15);

        return view('admin.plan.list',compact('data'));    

    }


    public function create()
    { 
       $test_type = DB::table('test_types')
                       ->where('status',1)
                       ->get();
        return view('admin.plan.add',compact('test_type'));
    }



    

    public function store(Request $request)

    {

       $validator = Validator::make($request->all(), [

          'title'               => 'required|unique:plans',
          'per_subject'         => 'required',
          'two_subject'         => 'required',
          'one_group'           => 'required',
          'both_group'          => 'required',
          'test_type'           => 'required',
          'description'         => 'required'

          ]);



        if ($validator->fails()) 

        {

            return redirect()->back() ->withErrors($validator)->withInput(); 

        }

  

          $catdata = new Plan;  

          $catdata->title          = trim($request['title']); 
          $catdata->test_type      = implode(',', $request['test_type']); 
          $catdata->per_subject    = trim($request['per_subject']);
          $catdata->two_subject    = trim($request['two_subject']);
          $catdata->one_group      = trim($request['one_group']);
          $catdata->both_group     = trim($request['both_group']); 
		      $catdata->description    = trim($request['description']);	

        $result =  $catdata->save();  

        if($result)

        {

            return redirect('admin/plan')->with('success','Details has been saved successfully.');

        }else{

            return back()->with('error','Try again.');

        }               

        

    }



    

    public function edit(Request $request,$id)

    {
        $courses = DB::table('courses')->get();
        $test_type = DB::table('test_types')->where('status',1)->get();
        $plan   = Plan::findOrFail($id);  

        return view('admin.plan.edit',compact('plan','courses','test_type'));

    }



   

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
          'title'               => 'required',
          'course'              => 'required',
          'per_subject'         => 'required',
          'two_group'           => 'required',
          'one_group'           => 'required',
          'both_group'          => 'required',
          'test_type'           => 'required',
          'description'         => 'required',
          'plan_pdf'            => 'mimes:pdf|max:20000',
          'uns_plan_pdf'        => 'mimes:pdf|max:20000'
          ]);

        if ($validator->fails()) 
        {
            return redirect()->back() ->withErrors($validator)->withInput(); 
        }

          $catdata                 = Plan::findOrFail($id);

       if ($request->hasFile('plan_pdf')) 
         {
                $file = array('plan_pdf' => Input::file('plan_pdf'));
                $destinationPath = 'public/plan_pdf/'; 
                $extension = Input::file('plan_pdf')->getClientOriginalExtension(); 
                $fileName = date('m-d-Y_hia').rand(1,99999).'.'.$extension;
                Input::file('plan_pdf')->move($destinationPath, $fileName);
                $catdata->plan_pdf = $fileName;
          
          } 
        
        if ($request->hasFile('uns_plan_pdf')) 
         {
                $file = array('uns_plan_pdf' => Input::file('uns_plan_pdf'));
                $destinationPath = 'public/plan_pdf/'; 
                $extension = Input::file('uns_plan_pdf')->getClientOriginalExtension(); 
                $fileName = date('m-d-Y_hia').rand(1,99999).'.'.$extension;
                Input::file('uns_plan_pdf')->move($destinationPath, $fileName);
                $catdata->uns_plan_pdf = $fileName;
          
          } 

          $catdata->title          = trim($request['title']); 
          $catdata->test_type      = implode(',', $request['test_type']); 
          $catdata->course_id      = trim($request['course']); 
          $catdata->per_subject    = trim($request['per_subject']);
          $catdata->two_group      = trim($request['two_group']);
          $catdata->one_group      = trim($request['one_group']);
          $catdata->both_group     = trim($request['both_group']); 
          $catdata->description    = trim($request['description']); 

        $result =  $catdata->save();  
        if($result)
        {
            return back()->with('success','Details has been updated successfully.');
        }else{
            return back()->with('error','Try again.');
        } 
    }



    

    public function destroy(Request $request,$id)

    {

        $res =  DB::table('plans')

                ->where('id', $id)

                ->update(['status' => 0]);

        if($res>0)

        {

           echo 'success'; 

        }else{

                echo 'error';  

             }

    }

	



	

    //class end

}

