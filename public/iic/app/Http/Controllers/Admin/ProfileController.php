<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Session;
use App\User; 
use Illuminate\Support\Facades\Input;
use Validator;
use Auth;
use DB;
use Image;

class ProfileController extends Controller
 {
    /**
     * Create a new controller instance.
     *
     * @return void 
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {  
        $id     = Auth::user()->id;
        $data['user'] = User::find($id); 
        return view('admin.profile',compact('data'));
    }

    //profile update
    public function profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'required|string',
            'username'   => 'required|string',        
            'mobile'     => 'required|min:10|max:10',      
            'rowid'      => 'required',      
            'email'      => 'required|email'      
        ]);  

        if($validator->fails()) 
        {
          return redirect()->back()->withErrors($validator)->withInput(); 
        }  
       $updata = User::findOrFail($request['rowid']);
       $updata->name = trim($request['name']);
       $updata->username  = trim($request['username']);
       $updata->email      = trim($request['email']);
       $updata->mobile     = trim($request['mobile']);

       if($request['password']!='')
       {
         $updata->password = bcrypt($request['password']);
       }
         $res = $updata->save();
       if($res)
       {
           return back()->with('success','Profile updated successfully');
       }else{
           return back()->with('error','Try again!'); 
       } 
    }


    //profile image update
    public function changeImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'mimes:jpeg,jpg,png',
            'rowid' =>'required'
        ]);

        if($validator->fails())  
        {
          return redirect()->back()->withErrors($validator)->withInput(); 
        }  
 
         $updata = User::findOrFail($request['rowid']); 
        if($request->hasFile('image')) 
          {

            if(file_exists('public/assets/photos/'.$updata->image))
            {
                unlink('public/assets/photos/'.$updata->image);
            }   
                   
            $file = $request['image'];
            $destinationPath = 'assets/photos';  
            $extension = $file->getClientOriginalExtension(); 
            $fileName = date('m-d-Y_hia').rand(1,99999).'.'.$extension; 
            $image_resize = Image::make($file->getRealPath());              
            $image_resize->resize(300, 300);
            $image_resize->save(public_path($destinationPath.'/' .$fileName));
            $updata->image = $fileName;
            $res = $updata->save(); 

            if($res)
            {
               return back()->with('success','Image updated successfully');
            }else{
               return back()->with('error','Try again!'); 
            } 
        } 
    }


    public function websiteImage(Request $request)
    {
       return view('admin.website-image');
    }

    

    public function settings()
    {
        $result = DB::table('settings')->get();
        return view('admin.settings',compact('result'));
    }

    public function updateSettings(Request $request)
    {
        $res = 0;
        $description = $request->description;
        $rowId = $request->rowId;
        if(count($description)>0 && count($rowId)>0)
        {
            $i=0;
            foreach($description as $des)
            {
                $updated_at = date('Y-m-d H:i:s');
                $res = DB::table('settings')->where('id',$rowId[$i])->update(['description'=>$des,'updated_at'=>$updated_at]);
                $i++;
            }
        }
        if($res)
        {
            return back()->with('success','Setting updated successfully');
        }else{
            return back()->with('error','Not update.'); 
        } 
    }

    public function contactEnquiry(Request $request)
    {
       $data['list'] = DB::table('contact_us')->paginate(25);
       return view('admin.contact-enquiry',compact('data'));
    }

    public function strategicPartners(Request $request)
    {
       $data['list'] = DB::table('strategic_partners')->paginate(25);
       return view('admin.strategic_partners',compact('data'));
    }

    public function pages($pageName)
    {
        $data['detail'] = array();
        $data['addmore'] = array();
        $data['addmorebutton'] = 0;
        if($pageName=='license-information')
        {
           $data['detail'] = DB::table('website_info')->where('id',4)->first();
        }

        if($pageName=='legal-privacy')
        {
           $data['detail'] = DB::table('website_info')->where('id',3)->first();
        }

        if($pageName=='contact-us')
        {
           $data['detail'] = DB::table('website_info')->where('id',5)->first();
        }

        if($pageName=='faqs')
        {
          $data['addmorebutton'] = 1;
           $data['detail'] = DB::table('website_info')->where('id',6)->first();
           if(!empty($data['detail']))
           {
              $data['addmore'] = DB::table('website_details')->where('website_id',6)->get();
           }
        }
        $data['titlehide'] = 0;
        if($pageName=='social-links')
        {
          $data['titlehide']     = 1;
          $data['detail'] = DB::table('website_info')->where('id',7)->first();
           if(!empty($data['detail']))
           {
              $data['addmore'] = DB::table('website_details')->where('website_id',7)->get();
           }
        }

        if($pageName=='about-us')
        {
          $data['addmorebutton'] = 1;
          $data['detail'] = DB::table('website_info')->where('id',8)->first();
           if(!empty($data['detail']))
           {
              $data['addmore'] = DB::table('website_details')->where('website_id',8)->get();
           }
        }

        if(!empty($data['detail']))
        {
            return view('admin.page-content',compact('data'));
        }
    }

    public function updatePages(Request $request)
    {
      $validator = Validator::make($request->all(), [
            'title'       => 'required',
            'description' => 'required',
        ]);

        if($validator->fails())  
        {
          return redirect()->back()->withErrors($validator)->withInput(); 
        }

        $res = DB::table('website_info')->where('id',$request['rowId'])->update(['title'=>trim($request['title']),'description'=>trim($request['description']),'updated_at'=>date('Y-m-d H:i:s')]);  
        if($res)
        {
            if(isset($request['addmore_title']))
            {
                $title       = $request['addmore_title'];
                $description = $request['addmore_description'];
                $i=0;
                foreach($title as $t)
                {
                    $darray = array(
                                    'website_id'  =>$request['rowId'],
                                    'description' =>$description[$i],
                                    'title'       =>$t
                               );
                    DB::table('website_details')->insert($darray);
                    $i++;
                }
            }

            if(isset($request['rowId1']))
            {
                $rowId1 = $request['rowId1'];
                $title1       = $request['addmore_title1'];
                $description1 = $request['addmore_description1'];
                $ii=0;
                foreach($rowId1 as $rid)
                {
                    $darray = array(
                                    'title'       =>$title1[$ii],
                                    'description' =>$description1[$ii]
                               );
                    DB::table('website_details')->where('id',$rid)->update($darray);
                    $ii++;
                }
            }
            return back()->with('success','Updated successfully');
        }else{
            return back()->with('error','Not update.'); 
        } 
    }

    public function removeAddMore($id)
    {
      $res = DB::table('website_details')->where('id',$id)->delete();
      if($res){
        echo 'success';
      }else{
        echo 'error'; 
      } 
    }
// class end
}
