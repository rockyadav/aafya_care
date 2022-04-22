<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Group;
use Validator;
use App\User;
use Image;
use Input;
use Auth;
use DB;
use Carbon\Carbon;
use File;

class GroupController extends Controller
{
   
    public function index(Request $request)
    {
        $data['list'] = DB::table('groups')
                            ->join('courses', 'groups.course_id', '=', 'courses.id')
                            ->where('groups.status',1)
                            ->select('groups.*','courses.course_name')
                            ->paginate(15);
        return view('admin.group.list',compact('data'));    
    } 

   
    public function create()
    {
		$courses = DB::table('courses')->where('status',1)->get();
         return view('admin.group.add',compact('courses'));
    }

    public function store(Request $request)
    {
		$validator = Validator::make($request->all(), [
          'course'     => 'required',    
          'name'       => 'required|unique:groups'
          ]);
       
		if ($validator->fails()) 
        {
            return redirect()->back() ->withErrors($validator)->withInput(); 
        }  

        $instdata               = new Group;   
        $instdata->name         = trim($request['name']);  
        $instdata->course_id    = trim($request['course']);   
        
        $result =  $instdata->save();  
        if($result)
        {
            return redirect('admin/group')->with('success','Details has been saved successfully.');
        }else{
            return back()->with('error','Try again.');
        }               
        
    }
    
    public function edit(Request $request,$id)
    {
		 $courses = DB::table('courses')->where('status',1)->get();
         $group   = DB::table('groups')->where('id',$id)->first();
         return view('admin.group.edit',compact('group','courses'));
              
    }

   
    public function update(Request $request,$id)
    {
      $validator = Validator::make($request->all(), [
          'name'        => 'required',    
          'course'   => 'required'
          ]);
       
        if ($validator->fails()) 
        {
            return redirect()->back() ->withErrors($validator)->withInput(); 
        }  

        $instdata              = Group::findOrFail($id);;   
        $instdata->name        = trim($request['name']);  
        $instdata->course_id   = trim($request['course']);    
        
        $result =  $instdata->save(); 

        if($result)
        {
            return back()->with('success','Details has been updated successfully.');
        }else{
            return back()->with('error','Try again.');
        } 
    }

    
    public function destroy(Request $request,$id)
    {
        $item = Group::where('id', $id)->update(['status' => 0]);
        if($item)
        {
            echo 'success';
        }else{
            echo 'error';
        } 
    }

    //class end
}
