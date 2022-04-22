<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Event;
use Validator;
use App\User;
use Image;
use Input;
use Auth;
use DB;
use Carbon\Carbon;
use File;


class EventController extends Controller
{

	public function index(Request $request)
    {
      $data['list'] = Event::where(['status'=>1])->orderBy('id','DESC')->paginate(20);
        return view('admin.events.list',compact('data'));    
    }

	
    public function create()
    {
        return view('admin.events.add');
    }


    public function store(Request $request)
    {
       $validator = Validator::make($request->all(), [
          'title'        => 'required|unique:events',
          'event_date'   => 'required',
          'description'  => 'required',
          'image'        => "required|mimes:jpg,jpeg,png|max:90000"
          ]);

        if ($validator->fails()) 
        {
            return redirect()->back() ->withErrors($validator)->withInput(); 
        }

         
          $catdata = new Event;  

       if ($request->hasFile('image')) 
         {
                $file = array('image' => Input::file('image'));
                $destinationPath = 'public/events/'; 
                $extension = Input::file('image')->getClientOriginalExtension(); 
                $fileName = date('m-d-Y_hia').rand(1,99999).'.'.$extension;
                Input::file('image')->move($destinationPath, $fileName);
                $catdata->image = $fileName;
          
          } 

          $catdata->title       = trim($request['title']);
          $catdata->event_date   = trim($request['event_date']);
          $catdata->description  = trim($request['description']);

        $result =  $catdata->save();  
        if($result)
        {
            return redirect('event')->with('success','Details has been saved successfully.');
        }else{
            return back()->with('error','Try again.');
        }               

    }



    

    public function edit(Request $request,$id)
    {
        $event = Event::where('id' ,$id)->first();
        return view('admin.events.edit',compact('event'));
    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
          'title'        => 'required',
          'event_date'   => 'required',
          'description'  => 'required',
          'image'        => "mimes:jpg,jpeg,png|max:90000"
          ]);

        if ($validator->fails()) 
        {
            return redirect()->back() ->withErrors($validator)->withInput(); 
        }

         $catdata = Event::findOrFail($id); 


          if ($request->hasFile('image')) 
         {
			 
			    $image_path = "public/events/".$catdata->image;

				if (File::exists($image_path)) 
				{
					//File::delete($image_path);
					unlink($image_path);
				}
				
                $file = array('image' => Input::file('image'));
                $destinationPath = 'public/events/'; 
                $extension = Input::file('image')->getClientOriginalExtension(); 
                $fileName = date('m-d-Y_hia').rand(1,99999).'.'.$extension;
                Input::file('image')->move($destinationPath, $fileName);
                $catdata->image = $fileName;
          
          } 

          $catdata->title       = trim($request['title']);
          $catdata->event_date   = trim($request['event_date']);
          $catdata->description  = trim($request['description']);

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
        $check = DB::table('events')->where('id', $id)->first();
       
      if($check!='')
      {
		  
		   $image_path = "public/events/".$check->image;

				if (File::exists($image_path)) {
					//File::delete($image_path);
					unlink($image_path);
				}
         Event::where('id', $id)->delete();
           echo 'success'; 
      }else{
            echo 'error';  
      }
    }

	



	

    //class end

}

