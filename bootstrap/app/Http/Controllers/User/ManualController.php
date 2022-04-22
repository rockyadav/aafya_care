<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Model\Manual;
use Validator;
use App\User;
use Image;
use Input;
use Auth;
use DB;
use Carbon\Carbon;
use File;


class ManualController extends Controller
{

 public function getSerialNumberList(Request $request)
    {  
        $models = DB::table("serial_numbers")
                    ->where("model_id",$request->model_id)
                    ->orderBy("serial_number","ASC")
                    ->pluck("serial_number","id");
        return response()->json($models);
    }

public function getModelList(Request $request)
    {  
        $models = DB::table("models")
                    ->where("manufacture_id",$request->manufacturer_id)
                    ->orderBy("model_name","ASC")
                    ->pluck("model_name","id");
        return response()->json($models);
    }
  
	
	public function searchManuals(Request $request)
    {
		  $category_id      = trim($request['category']);
      $manufacturer_id  = trim($request['manufacturer']); 
      $model_id         = trim($request['model']);
      $serial_number = trim($request['serial_number']);
      $userid = Auth::user()->id ;
           //echo "ram"; die;
      $mymanual = DB::table('user_manuals')
                       ->where('user_id',$userid)
                       ->first();
      if($mymanual!='')
      {
            $manualid = explode(',', $mymanual->manual_id); 
      }else{                 
            $manualid = array();  
      }                

	    $res = DB::table('manuals')
                       ->join('manufacturers', 'manuals.manufacturer_id', '=', 'manufacturers.id')
                       ->join('models', 'manuals.model_id', '=', 'models.id')
                       ->join('services', 'manuals.category_id', '=', 'services.id')
                       ->join('serial_numbers', 'manuals.serial_number_id', '=', 'serial_numbers.id')
                       ->where('manuals.is_delete',0)
                       ->whereIn('manuals.id',$manualid);
                       if($category_id !=''){
                         $res->where('manuals.category_id',$category_id);
                       }
                        if($manufacturer_id !=''){
                         $res->where('manuals.manufacturer_id',$manufacturer_id);
                       }
                        if($model_id !=''){
                         $res->where('manuals.model_id',$model_id);
                       }
                        if($serial_number !=''){
                         $res->where('manuals.serial_number_id',$serial_number);
                       }

          $data['list'] = $res->select('manuals.*','manufacturers.name as manufacturer_name','models.model_name','serial_numbers.serial_number','services.service_name')
                       ->orderBy('manuals.id','DESC')
                       ->paginate(5000);

        return view('user.manuals.search',compact('data'));    
    }



    public function index(Request $request)
    {
    
     $userid = Auth::user()->id ;
     $mymanual = DB::table('user_manuals')
                       ->where('user_id',$userid)
                       ->first();
      if($mymanual!='')
      {
            $manualid = explode(',', $mymanual->manual_id); 
      }else{                 
            $manualid = array();  
      }                

      $data['list'] = DB::table('manuals')
                       ->join('manufacturers', 'manuals.manufacturer_id', '=', 'manufacturers.id')
                       ->join('models', 'manuals.model_id', '=', 'models.id')
                       ->join('services', 'manuals.category_id', '=', 'services.id')
                       ->join('serial_numbers', 'manuals.serial_number_id', '=', 'serial_numbers.id')
                       ->where('manuals.is_delete',0)
                       ->whereIn('manuals.id',$manualid)
                       ->select('manuals.*','manufacturers.name as manufacturer_name','models.model_name','serial_numbers.serial_number','services.service_name')
                       ->orderBy('manuals.id','DESC')
                       ->paginate(15);

       $services  = DB::table('services')->where('status',1)->orderBy('id','DESC')->get();
       $manufacturers = DB::table('manufacturers')->where('status',1)->orderBy('id','DESC')->get();

        return view('user.manuals.list',compact('data','services','manufacturers'));    
    }
	
	 
    public function create()
    {
         $services      = DB::table('services')->where('status',1)->orderBy('id','DESC')->get();
         $manufacturers = DB::table('manufacturers')->where('status',1)->orderBy('id','DESC')->get();

        return view('user.manuals.add',compact('services','manufacturers'));
    }

    public function view_details(Request $request,$id)
    {
		if($id!='')
		{
          $manual = DB::table('manuals')
                       ->join('manufacturers', 'manuals.manufacturer_id', '=', 'manufacturers.id')
                       ->join('models', 'manuals.model_id', '=', 'models.id')
                       ->join('services', 'manuals.category_id', '=', 'services.id')
                       ->join('serial_numbers', 'manuals.serial_number_id', '=', 'serial_numbers.id')
                       ->where('manuals.is_delete',0)
                       ->where('manuals.id',$id)
                       ->select('manuals.*','manufacturers.name as manufacturer_name','models.model_name','serial_numbers.serial_number','services.service_name')
                       ->orderBy('manuals.id','DESC')
                       ->first();
          return view('user.manuals.views',compact('manual'));
		  
		}else{
			return redirect('user/manuals');
		}
    }
	

    public function store(Request $request)
    {
       $validator = Validator::make($request->all(), [
          'manual_title'        => 'required',
		      'category'            => 'required',
          'manufacturer'        => 'required',
          'model'               => 'required',
          'serial_number'       => 'required',
          'description'         => 'required',
          'manual_file'         => 'required|mimes:pdf,doc|max:30720',
          'manual_image'        => 'required|mimes:jpeg,jpg,gif,png,svg|max:10240'
          ]);

        if ($validator->fails()) 
        {
            return redirect()->back() ->withErrors($validator)->withInput(); 
        }
  
          $catdata = new Manual;  
          $catdata->manual_title          = trim($request['manual_title']); 
          $catdata->category_id           = trim($request['category']);
		      $catdata->manufacturer_id       = trim($request['manufacturer']);	
          $catdata->model_id              = trim($request['model']);
		      $catdata->serial_number_id      = trim($request['serial_number']);
          $catdata->manual_description    = trim($request['description']);

           if ($request->hasFile('manual_file'))
           {
              $file = array('manual_file' => Input::file('manual_file'));
              $destinationPath = 'public/manual_files/'; 
              $extension = Input::file('manual_file')->getClientOriginalExtension(); 
              $fileName = date('m-d-Y_hia').rand(1,99999).'.'.$extension;
              Input::file('manual_file')->move($destinationPath, $fileName);
               $catdata->manual_file = $fileName;
            } 

          if ($request->hasFile('manual_image'))
           {
              $file = array('manual_image' => Input::file('manual_image'));
              $destinationPath = 'public/manual_images/'; 
              $extension = Input::file('manual_image')->getClientOriginalExtension(); 
              $fileName = date('m-d-Y_hia').rand(1,99999).'.'.$extension;
              Input::file('manual_image')->move($destinationPath, $fileName);
               $catdata->manual_image = $fileName;
            } 

        $result =  $catdata->save();  
        if($result)
        {
            return redirect('user/manuals')->with('success','Details has been saved successfully.');
        }else{
            return back()->with('error','Try again.');
        }               
        
    }

    
    public function edit(Request $request,$id)
    {
        $manual        = Manual::select(['*'])->where('id' ,$id)->first();

        $services      = DB::table('services')->where('status',1)->orderBy('id','DESC')->get();

        $manufacturers = DB::table('manufacturers')->where('status',1)->orderBy('id','DESC')->get();

        $models        = DB::table('models')->where('status',1)
                            ->where('manufacture_id',$manual->manufacturer_id)
                            ->orderBy('id','DESC')->get();

       $serial_numbers = DB::table('serial_numbers')->where('status',1)
                             ->where('model_id',$manual->model_id)
                             ->orderBy('id','DESC')->get();
        
        return view('user.manuals.edit',compact('manual','services','manufacturers','models','serial_numbers'));
    }

   
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
          'manual_title'        => 'required',
          'category'            => 'required',
          'manufacturer'        => 'required',
          'model'               => 'required',
          'serial_number'       => 'required',
          'description'         => 'required',
          'manual_file'         => 'mimes:pdf,doc|max:30720',
          'manual_image'        => 'mimes:jpeg,jpg,gif,png,svg|max:10240'
          ]);
        if ($validator->fails()) 
        {
            return redirect()->back() ->withErrors($validator)->withInput(); 
        }
         
          $catdata = Manual::findOrFail($id); 
          $catdata->manual_title          = trim($request['manual_title']); 
          $catdata->category_id           = trim($request['category']);
          $catdata->manufacturer_id       = trim($request['manufacturer']); 
          $catdata->model_id              = trim($request['model']);
          $catdata->serial_number_id      = trim($request['serial_number']);
          $catdata->manual_description    = trim($request['description']);

           if ($request->hasFile('manual_file'))
           {
              if($catdata->manual_file!='')
              {
                unlink('public/manual_files/'.$catdata->manual_file);
              }

              $file = array('manual_file' => Input::file('manual_file'));
              $destinationPath = 'public/manual_files/'; 
              $extension = Input::file('manual_file')->getClientOriginalExtension(); 
              $fileName = date('m-d-Y_hia').rand(1,99999).'.'.$extension;
              Input::file('manual_file')->move($destinationPath, $fileName);
               $catdata->manual_file = $fileName;
            } 

          if ($request->hasFile('manual_image'))
           {

             if($catdata->manual_image!='')
              {
                unlink('public/manual_images/'.$catdata->manual_image);
              }

              $file = array('manual_image' => Input::file('manual_image'));
              $destinationPath = 'public/manual_images/'; 
              $extension = Input::file('manual_image')->getClientOriginalExtension(); 
              $fileName = date('m-d-Y_hia').rand(1,99999).'.'.$extension;
              Input::file('manual_image')->move($destinationPath, $fileName);
               $catdata->manual_image = $fileName;
            } 
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
        $item = Manual::findOrFail($id);
        $img  = $item->manual_image;
        $file = $item->manual_file;
        if($img!='')
        {
          unlink('public/manual_images/'.$img);
        }
        if($img!='')
        {
          unlink('public/manual_files/'.$file);
        }

        $res =  DB::table('manuals')
                ->where('id', $id)
                ->update(['is_delete' => 1]);
        if($res>0)
        {
           echo 'success'; 
        }else{
                echo 'error';  
             }
    }
	

	
    //class end
}
