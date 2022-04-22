<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Course;
use Validator;
use App\User;
use Image;
use Input;
use Auth;
use DB;
use Carbon\Carbon;
use File;


class CourseController extends Controller
{
	
	public function index(Request $request)
    {
      $data['list'] = DB::table('courses')->where(['status'=>1])->orderBy('id','DESC')->paginate(20);
        return view('admin.course.list',compact('data'));    
    }
	

   
    public function create()
    {
        return view('admin.course.add');
    }

   

    public function store(Request $request)
    {
       $validator = Validator::make($request->all(), [
          'course_name'   => 'required|unique:courses'
         
          ]);

        if ($validator->fails()) 
        {
            return redirect()->back() ->withErrors($validator)->withInput(); 
        }
  
          $catdata = new Course;  
          $catdata->course_name        = trim($request['course_name']);

        $result =  $catdata->save();  
        if($result)
        {
            return redirect('admin/course')->with('success','Details has been saved successfully.');
        }else{
            return back()->with('error','Try again.');
        }               
        
    }

    
    public function edit(Request $request,$id)
    {
        $course = Course::where('id' ,$id)->first();
        return view('admin.course.edit',compact('course'));
    }

   
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
          'course_name'   => 'required',
          ]);
        if ($validator->fails()) 
        {
            return redirect()->back() ->withErrors($validator)->withInput(); 
        }
         
          $catdata = Course::findOrFail($id); 
 
          $catdata->course_name        = trim($request['course_name']);

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
        $res = Course::where('id', $id)->update(['status' => 0]);
       
        if($res)
        {
           echo 'success'; 
        }else{
                echo 'error';  
        }
    }
	

	
    //class end
}
