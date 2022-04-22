<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Testimonial;
use Validator;
use App\User;
use Image;
use Input;
use Auth;
use DB;
use Carbon\Carbon;
use File;


class TestimonialController extends Controller
{

	public function index(Request $request)
    {
      $data['list'] = DB::table('testimonials')->where(['status'=>1])->orderBy('id','DESC')->paginate(20);
        return view('admin.testimonial.list',compact('data'));    
    }

	
    public function create()
    {
        return view('admin.testimonial.add');
    }


    public function store(Request $request)
    {
       $validator = Validator::make($request->all(), [
          'title'        => 'required',
		  'description'  => 'required',
		  'image'=>'required|mimes:jpg,png,jpeg|max:10000'
          ]);

        if ($validator->fails()) 
        {
            return redirect()->back() ->withErrors($validator)->withInput(); 
        }

         
          $catdata = new Testimonial;  
        if ($request->hasFile('image'))
           {
              $file = array('image' => Input::file('pdf_file'));
              $destinationPath = 'public/testimonial/'; 
              $extension = Input::file('image')->getClientOriginalExtension(); 
              $fileName = date('m-d-Y_hia').'.'.$extension;
              Input::file('image')->move($destinationPath, $fileName);
               $catdata->image = $fileName;
            } 


        $catdata->title       = trim($request['title']);
		$catdata->description = trim($request['description']);

        $result =  $catdata->save();  
        if($result)
        {
            return redirect('admin/testimonial')->with('success','Details has been saved successfully.');
        }else{
            return back()->with('error','Try again.');
        }               

    }



    

    public function edit(Request $request,$id)
    {
        $testimonial = Testimonial::where('id' ,$id)->first();
        return view('admin.testimonial.edit',compact('testimonial'));
    }

    public function update(Request $request,$id)
    {
       $validator = Validator::make($request->all(), [
          'title' => 'required',
          'description' => "required",
          'image'       =>'mimes:jpg,png,jpeg|max:10000',
          ]);

        if ($validator->fails()) 
        {
            return redirect()->back() ->withErrors($validator)->withInput(); 
        }

         $catdata = Testimonial::findOrFail($id); 

           if ($request->hasFile('image'))
           {
           	
           	 if($catdata->image!='')
              {
                $path = url('public/testimonial/'.$catdata->image);
                if(file_exists($path))
                   {
                      @unlink($path);
                   } 
              }

              $file = array('image' => Input::file('image'));
              $destinationPath = 'public/testimonial/'; 
              $extension = Input::file('image')->getClientOriginalExtension(); 
              $fileName = date('m-d-Y_hia').'.'.$extension;
              Input::file('image')->move($destinationPath, $fileName);
               $catdata->image = $fileName;
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
        $check = DB::table('testimonials')->where('id', $id)->first();
       
      if($check!='')
      {
		  if($check->image!='')
              {
                $path = url('public/testimonial/'.$check->image);
                if(file_exists($path))
                   {
                      @unlink($path);
                   } 
              }
         Testimonial::where('id', $id)->delete();
           echo 'success'; 
      }else{
            echo 'error';  
      }
    }

    //class end

}

