<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Validator;
use App\Model\Subject;
use Image;
use Input;
use Auth;
use DB;
use Carbon\Carbon;

class SubjectController extends Controller
{
   public function get_group_list(Request $request)
    {  
        $models = DB::table("groups")
                    ->where("course_id",$request->course_id)
                    ->orderBy("name","ASC")
                    ->pluck("name","id");
        return response()->json($models);
    }

    public function index(Request $request)
    {
		   $data['list'] = DB::table('subjects')
                            ->join('courses', 'subjects.course_id', '=', 'courses.id')
                            ->join('groups', 'subjects.group_id', '=', 'groups.id')
                            ->where('subjects.status',1)
                            ->select('subjects.*','courses.course_name','groups.name as group_name')
                            ->paginate(15);
                            
        
        return view('admin.subject.list',compact('data'));    
    } 

   
   
    
    public function create()
    {
        $courses = DB::table('courses')->where('status',1)->get();
        return view('admin.subject.add',compact('courses'));
    }

   
    public function store(Request $request)
    {
       $validator = Validator::make($request->all(), [
              'sub_name'       => 'required|unique:subjects',
              'group'          => 'required',
              'course'         => 'required'
          ]);

        if ($validator->fails()) 
        {
            return redirect()->back() ->withErrors($validator)->withInput(); 
        }
  
          $catdata = new Subject;  
          $catdata->sub_name           = trim($request['sub_name']);
          $catdata->course_id          = trim($request['course']);
          $catdata->group_id           = trim($request['group']); 
          $result =  $catdata->save();  
          if($result)
          {
              return redirect('admin/subject')->with('success','Details has been saved successfully.');
          }else{
              return back()->with('error','Try again.');
          }               
        
    }

    
    public function edit(Request $request,$id)
    {
        $subject = Subject::select(['*'])->where('id' ,$id)->first();
        $courses = DB::table('courses')->where('status',1)->get();
        $groups  = DB::table('groups')->where('course_id' ,$subject->course_id)->get();
        return view('admin.subject.edit',compact('subject','courses','groups'));
    }

   
    public function update(Request $request,$id)
    {
         $validator = Validator::make($request->all(), [
              'subject_name'       => 'required',
              'group'          => 'required',
              'course'         => 'required'
          ]);

        if ($validator->fails()) 
        {
            return redirect()->back() ->withErrors($validator)->withInput(); 
        }
         
          $catdata = Subject::findOrFail($id); 

          $catdata->sub_name           = trim($request['subject_name']);
          $catdata->course_id          = trim($request['course']);
          $catdata->group_id           = trim($request['group']); 
          
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
        $res = Subject::where('id', $id)->update(['status' => 0]);
        if($res)
        {
           echo 'success'; 
        }else{
                echo 'error';  
        }
    }

    //class end
}
