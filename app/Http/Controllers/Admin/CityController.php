<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\City;
use Validator;
use Auth;
use DB;



class CityController extends Controller
{
    public function index(Request $request)
    {
      $data['list'] = DB::table('cities')->where(['status'=>1])->orderBy('id','DESC')->paginate(20);
        return view('admin.city.list',compact('data'));    
    }

    
    public function create()
    {
        return view('admin.city.add');
    }


    public function store(Request $request)
    {
       $validator = Validator::make($request->all(), [
          'name'        => 'required|unique:cities',
          ]);

        if ($validator->fails()) 
        {
            return redirect()->back() ->withErrors($validator)->withInput(); 
        }

         
          $catdata = new City;  


          $catdata->name        = trim($request['name']);

        $result =  $catdata->save();  
        if($result)
        {
            return redirect('admin/city')->with('success','Details has been saved successfully.');
        }else{
            return back()->with('error','Try again.');
        }               

    }



    

    public function edit(Request $request,$id)
    {
        $city = City::where('id' ,$id)->first();
        return view('admin.city.edit',compact('city'));
    }

    public function update(Request $request,$id)
    {
       $validator = Validator::make($request->all(), [
          'name'        => 'required',
          ]);

        if ($validator->fails()) 
        {
            return redirect()->back() ->withErrors($validator)->withInput(); 
        }

         $catdata = City::findOrFail($id); 

          $catdata->name        = trim($request['name']);
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
        $check = DB::table('cities')->where('id', $id)->first();
       
      if($check!='')
      {
         City::where('id', $id)->delete();
           echo 'success'; 
      }else{
            echo 'error';  
      }
    }



    //class end

}

