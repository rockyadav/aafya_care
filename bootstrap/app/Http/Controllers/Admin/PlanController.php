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
                       ->where('status',1)
                       ->orderBy('id','DESC')
                       ->paginate(15);
     
        return view('admin.plan.list',compact('data'));    
    }
	
	
    public function create()
    { 
        return view('admin.plan.add');
    }

    
    public function store(Request $request)
    {
       $validator = Validator::make($request->all(), [
          'title'               => 'required|unique:plans',
		      'price'               => 'required',
          'description'        => 'required'
          ]);

        if ($validator->fails()) 
        {
            return redirect()->back() ->withErrors($validator)->withInput(); 
        }
  
          $catdata = new Plan;  
          $catdata->title          = trim($request['title']); 
          $catdata->price          = trim($request['price']);
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
        $plan   = Plan::findOrFail($id);  
        return view('admin.plan.edit',compact('plan'));
    }

   
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
          'title'               => 'required',
          'price'               => 'required',
          'description'         => 'required'
          ]);

        if ($validator->fails()) 
        {
            return redirect()->back() ->withErrors($validator)->withInput(); 
        }
         
          $catdata                 = Plan::findOrFail($id); 
          $catdata->title          = trim($request['title']); 
          $catdata->price          = trim($request['price']);
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
