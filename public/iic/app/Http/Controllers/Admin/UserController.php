<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Model\Images;
use App\User;
use Validator;
use Auth;
use DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        $res = User::where(['users.role'=>2,'users.status'=>1]);
        $res->orderBy('users.id','desc');
        $result = $res->paginate(25); 
        $data['list']   = $result;
        return view('admin.users.list',compact('data'));
    }

    public function create()
    {  
        return view('admin.users.add');
    }

    public function store(Request $request)
    {
        $validator      =  Validator::make($request->all(), [
          'name'        => 'required',
          'mobile_number'      => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:6|max:24',
          'password'    => 'required|min:6',
          'confirm_password' => 'required_with:password|same:password|min:6'
        ]);

         $response = array();
        if ($validator->fails()) {
            $valErrors = '';
            foreach ($validator->messages()->getMessages() as $field_name => $messages)
            {
                foreach($messages AS $message) {
                    $valErrors .= $message.', ';
                }
            }

            $response['status']='error';
            $response['msg']=rtrim($valErrors,', ');
            return $response; 
        }

        $checkUnique = User::where(['username'=>$request['username'],'status'=>1])->first();
        
        if(!empty($checkUnique)){
            $response['status']='error';
            $response['msg']='Username already exist';
            return $response; 
        }

        if($request['mobile_number']!='')
        {
            $checkUnique = User::where(['mobile'=>$request['mobile_number'],'status'=>1])->first();
        
            if(!empty($checkUnique)){
                $response['status']='error';
                $response['msg']='Mobile number already exist';
                return $response; 
            }
        }

        if($request['email']!='')
        {
            $checkUnique = User::where(['email'=>$request['email'],'status'=>1])->first();
        
            if(!empty($checkUnique)){
                $response['status']='error';
                $response['msg']='Email id already exist';
                return $response; 
            }
        }
        
        $insert_data = User::saveStudentData($request->all());
        if($insert_data==1)
        {
            $response['status']='success';
            $response['msg']='Student saved successfully';
        }elseif($insert_data=='error'){
            $response['status']='error';
            $response['msg']='Centre manager not linked with state and city';
        }else{
            $response['status']='error';
            $response['msg']='Please try again';
        }
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $data['page'] = 'profile';
       $data['user'] = User::where('users.id',$id)->leftJoin('user_address','user_address.user_id','=','users.id')->select('users.*','user_address.address','user_address.area','user_address.pin_code','user_address.about_me')->first();
       return view('admin.users.profile',compact('data','id'));
    }

    public function userSubscription($id)
    {
       $data['page'] = 'subscription';
       $data['list'] = DB::table('user_subscriptions')->where('user_id',$id)->paginate(25);
       return view('admin.users.subscription',compact('data','id'));
    }

    public function userDownloads($id)
    {
       $data['page'] = 'downloads';
       $data['images'] = Images::join('user_downloaded','user_downloaded.image_id','=','images.id')->where(['user_downloaded.user_id'=>$id,'images.status'=>1])->select('images.*')->paginate(25);
       return view('admin.users.downloads',compact('data','id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['detail'] = User::where('id',$id)->first();
        return view('admin.students.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rowId'       => 'required',      
            'name'        => 'required',
            'mobile_number'=> 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:6|max:24',
            'isLogin'    => 'required'
        ]);

        $id = $request['rowId'];
        $response = array();
        if ($validator->fails()) {
            $valErrors = '';
            foreach ($validator->messages()->getMessages() as $field_name => $messages)
            {
                foreach($messages AS $message) {
                    $valErrors .= $message.', ';
                }
            }

            $response['status']='error';
            $response['msg']=rtrim($valErrors,', ');
            return $response; 
        }
        
        if($request['mobile_number']!='')
        {
            $checkUnique = User::where(['mobile'=>$request['mobile_number'],'status'=>1])->first();
        
            if(!empty($checkUnique) && $id!=$checkUnique->id){
                $response['status']='error';
                $response['msg']='Mobile number already exist';
                return $response; 
            }
        }
        
        if($request['email']!='')
        {
            $checkUnique = User::where(['email'=>$request['email'],'status'=>1])->first();
        
            if(!empty($checkUnique) && $id!=$checkUnique->id){
                $response['status']='error';
                $response['msg']='Email id already exist';
                return $response; 
            }
        }

        $update_data = User::updateStudentData($id,$request->all());
        if($update_data==1)
        {
            $response['status']='success';
            $response['msg']='User updated successfully';
        }else{
            $response['status']='error';
            $response['msg']='Please try again';
        }        
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function login($id)
    {
        $user = User::where('id',$id)->first();
        if(!empty($user))
        {   
            if($user->isLogin==0)
            {
                $user->isLogin = 1;
                $msg = 'Enabled successfully';
            }else{
                $user->isLogin = 0;
                $msg = 'Disabled successfully';
            }
            $user->save();

            return back()->with('success',$msg);
        }else{
            return back()->with('error','Please try again');
        }
    }
    
    public function destroy($id)
    {
        $delete_data = User::deleteData($id);
        if($delete_data)
        {
            return back()->with('success','User deleted successfully');
        }else{
            return back()->with('error','Please try again');
        }
    }
    //class end
}
