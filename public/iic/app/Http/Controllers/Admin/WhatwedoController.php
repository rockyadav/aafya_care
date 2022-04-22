<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\What_we_do;
use Validator;
use App\User;
use Image;
use Input;
use Auth;
use DB;
use Carbon\Carbon;
use File;


class WhatwedoController extends Controller
{

	public function index(Request $request)
    {
      $data['list'] = What_we_do::where(['status'=>1])->orderBy('id','DESC')->paginate(20);
        return view('admin.what_we_do.list',compact('data'));    
    }

	
    public function create()
    {
        return view('admin.what_we_do.add');
    }


    public function store(Request $request)
    {
       $validator = Validator::make($request->all(), [
          'title'        => 'required|unique:what_we_do',
          'description'  => 'required',
          'image'        => "required|mimes:jpg,jpeg,png|max:90000"
          ]);

        if ($validator->fails()) 
        {
            return redirect()->back() ->withErrors($validator)->withInput(); 
        }

         
          $catdata = new What_we_do;  

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
          $catdata->description  = trim($request['description']);

        $result =  $catdata->save();  
        if($result)
        {
            return redirect('whatwedo')->with('success','Details has been saved successfully.');
        }else{
            return back()->with('error','Try again.');
        }               

    }



    

    public function edit(Request $request,$id)
    {
        $whatwedo = What_we_do::where('id' ,$id)->first();
        return view('admin.what_we_do.edit',compact('whatwedo'));
    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
          'title'        => 'required',
          'description'  => 'required',
          'image'        => "mimes:jpg,jpeg,png|max:90000"
          ]);

        if ($validator->fails()) 
        {
            return redirect()->back() ->withErrors($validator)->withInput(); 
        }

         $catdata = What_we_do::findOrFail($id); 


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
        $check = What_we_do::where('id', $id)->first();
       
      if($check=='')
      {
		  $image_path = "public/events/".$check->image;

			if (File::exists($image_path)) 
			{
				//File::delete($image_path);
				unlink($image_path);
			}
         What_we_do::where('id', $id)->delete();
           echo 'success'; 
      }else{
            echo 'error';  
      }
    }

	



	

    //class end

}

