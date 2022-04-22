<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Model\Course_perameter;
use Validator;
use App\User;
use Image;
use Input;
use Auth;
use DB;
use Carbon\Carbon;
use File;

class CoursePerameterController extends Controller

{

     public function testList(Request $request)
    {

        $data['list'] = DB::table('courses')
                            ->where('is_delete',0)
                            ->orderBy('id','DESC')
                            ->paginate(15);

        return view('admin.course_perameter.test_list',compact('data'));    

    }

    

    public function courseParameterList(Request $request,$id)
    {

        $data['list'] = DB::table('course_perameters')
                            ->LeftJoin('courses', 'course_perameters.course_id', '=', 'courses.id')
                            ->where('course_perameters.status',1)
                            ->where('course_perameters.course_id',$id)
                            ->select('course_perameters.*','courses.course_name')
                            ->orderBy('course_perameters.parameter_order','ASC')
                            ->paginate(15);

         $test_id =$id ;                   

        return view('admin.course_perameter.list',compact('data','test_id'));    

    }

    public function index(Request $request)
    {

        $data['list'] = DB::table('course_perameters')
                            ->LeftJoin('courses', 'course_perameters.course_id', '=', 'courses.id')
                            ->where('course_perameters.status',1)
                            ->select('course_perameters.*','courses.course_name')
                            ->orderBy('courses.id','DESC')
                            ->paginate(15);

        return view('admin.course_perameter.list',compact('data'));    

    }



    public function create()

    {

		$courses = DB::table('courses')->where('status',1)->get();

         return view('admin.course_perameter.add',compact('courses'));

    }

    
    public function courseParameterAdd(Request $request,$test_id)
    {

       $courses = DB::table('courses')->where('status',1)->get();
        return view('admin.course_perameter.add',compact('courses','test_id'));

    }

    public function store(Request $request)
    {
		$validator = Validator::make($request->all(), [
          'course'     => 'required',    
          'name'       => 'required',
          'parameter_order'=>'required',
          ]);

		if ($validator->fails()) 
        {
            return redirect()->back()->withErrors($validator)->withInput(); 
        } 

     $course_id = trim($request['course']); 
     $name      = trim($request['name']); 
         

     $check = DB::table('course_perameters')
                      ->where('course_id',$course_id)
                      ->where('name',$name)
                      ->first();

        if($check!='') 
        {
            return back()->with('error','Course perameter already exist.'); 
        }              

        $instdata               = new Course_perameter;   
        $instdata->name         = trim($request['name']);  
        $instdata->parameter_order         = trim($request['parameter_order']);  
        $instdata->course_id    = trim($request['course']);   

        $result =  $instdata->save();  

        if($result)

        {

            return redirect('admin/course-parameter-list/'.$course_id)->with('success','Details has been saved successfully.');

        }else{

            return back()->with('error','Try again.');

        }               

        

    }

    

    public function edit(Request $request,$id)
    {

		 $courses = DB::table('courses')->where('status',1)->get();

         $group   = DB::table('course_perameters')->where('id',$id)->first();

         return view('admin.course_perameter.edit',compact('group','courses'));

              

    }



   

    public function update(Request $request,$id)
    {

      $validator = Validator::make($request->all(), [
          'name'     => 'required',    
          'parameter_order'   => 'required',
          'course'   => 'required'
          ]);

        if ($validator->fails()) 
        {
            return redirect()->back() ->withErrors($validator)->withInput(); 

        }  

        $course_id   = trim($request['course']); 

        $instdata              = Course_perameter::findOrFail($id);;   

        $instdata->name        = trim($request['name']);  
        $instdata->parameter_order  = trim($request['parameter_order']);  
        $instdata->course_id   = trim($request['course']); 


        $result =  $instdata->save(); 

        if($result)
        {
           return redirect('admin/course-parameter-list/'.$course_id)->with('success','Details has been updated successfully.');
        }else{
            return back()->with('error','Try again.');

        } 

    }


    public function destroy(Request $request,$id)
    {
       $check = Course_perameter::where('id', $id)->first();
        
        if($check!='')
        {
            Course_perameter::where('id', $id)->delete();
            echo 'success';
        }else{
            echo 'error';

        } 

    }

    //class end

}

