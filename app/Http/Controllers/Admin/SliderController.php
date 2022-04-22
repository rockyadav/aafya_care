<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Course;
use App\Model\Slider;
use Validator;
use App\User;
use Image;
use Input;
use Auth;
use DB;
use Carbon\Carbon;
use File;

class SliderController extends Controller
{


    public function index(Request $request)
    {
		$sliderList = DB::table('sliders')->orderBy('id','desc')->get();
        return view('admin.slider.list', ['sliderList' => $sliderList]);
    }

	 public function create()
    {
        return view('admin.slider.add');
    }
	
	 public function store(Request $request)
    {
       $validator = Validator::make($request->all(), [
          'slider_image'    => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
          ]);

        if ($validator->fails()) 
        {
            return redirect()->back() ->withErrors($validator)->withInput(); 
        }

         
          $catdata = new Slider;  

       if ($request->hasFile('slider_image')) 
         {
                $file = array('slider_image' => Input::file('slider_image'));
                $destinationPath = 'public/sliders/'; 
                $extension = Input::file('slider_image')->getClientOriginalExtension(); 
                $fileName = date('m-d-Y_hia').rand(1,99999).'.'.$extension;
                Input::file('slider_image')->move($destinationPath, $fileName);
                $catdata->slider_image = $fileName;
          
          } 

          $catdata->title        = trim($request['title']);
		  $catdata->description  = trim($request['description']);

        $result =  $catdata->save();  
        if($result)
        {
            return redirect('admin/slider')->with('success','Details has been saved successfully.');
        }else{
            return back()->with('error','Try again.');
        }               

    }
	
    public function edit(Request $request,$id)
    {
        $slider = Slider::where('id' ,$id)->first();
        return view('admin.slider.edit',compact('slider'));
    }

    public function update(Request $request,$id)
    {
      $validator = Validator::make($request->all(), [
          'slider_image'    => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
          ]);

        if ($validator->fails()) 
        {
            return redirect()->back() ->withErrors($validator)->withInput(); 
        }

         $catdata = Slider::findOrFail($id); 

         if ($request->hasFile('slider_image')) 
         {
                $file = array('slider_image' => Input::file('slider_image'));
                $destinationPath = 'public/sliders/'; 
                $extension = Input::file('slider_image')->getClientOriginalExtension(); 
                $fileName = date('m-d-Y_hia').rand(1,99999).'.'.$extension;
                Input::file('slider_image')->move($destinationPath, $fileName);
                $catdata->slider_image = $fileName;
          
          } 

          $catdata->title        = trim($request['title']);
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
        $check = Slider::where('id', $id)->first();
       
      if($check!='')
      {
		  $image_path = app_path("public/sliders/".$check->slider_image);

			if (File::exists($image_path)) {
				//File::delete($image_path);
				unlink($image_path);
			}
         Slider::where('id', $id)->delete();
           echo 'success'; 
      }else{
            echo 'error';  
      }
    }

   
//end class

}