<?php

namespace App\Http\Controllers\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Model\Images;
use App\User; 
use Validator;
use Helper;
use Auth;
use Image;
use DB;
class UserController extends Controller
 {
 	public function index()
 	{
 		$title = 'My Profile';
        $data['page']    = 'my-profile';
        $userId = Auth::user()->id;
        $user = User::where('users.id',$userId)->leftJoin('user_address','user_address.user_id','=','users.id')->select('users.id','users.name','users.email','users.mobile','users.image','user_address.address','user_address.area','user_address.pin_code','user_address.about_me')->first();
 		return view('front.user.my-profile',compact('title','data','user'));
 	}

    public function myDownload(Request $request)
    {
        $title = 'My Download';
        $data['page']  = 'my-download';
        $added_by = Auth::user()->id;
        $data['images'] = Images::join('user_downloaded','user_downloaded.image_id','=','images.id')->where(['user_downloaded.user_id'=>$added_by,'images.status'=>1])->select('images.*')->paginate(25);
        return view('front.user.my-download',compact('title','data'));
    }

    public function myPurchase(Request $request)
    {
        $title = 'My Purchase';
        $data['page']  = 'my-purchase';
        $added_by = Auth::user()->id;
        $data['images'] = Images::join('user_downloaded','user_downloaded.image_id','=','images.id')->where(['user_downloaded.user_id'=>$added_by,'images.status'=>1])->select('images.*','user_downloaded.created_at as download_date','user_downloaded.price as amount')->paginate(25);
        return view('front.user.my-purchase',compact('title','data'));
    }

    public function mySubscription(Request $request)
    {
        $title = 'My Subscription';
        $data['page']  = 'my-subscription';
        $added_by = Auth::user()->id;
        $data['subscriptions'] = DB::table('user_subscriptions')->where(['user_id'=>$added_by])->paginate(25);
        return view('front.user.my-subscriptions',compact('title','data'));
    }

    public function myWishlist(Request $request)
    {
        $title = 'My Wishlist';
        $data['page']  = 'my-wishlist';
        $added_by = Auth::user()->id;
        $data['images'] = Images::join('user_wishlists','user_wishlists.image_id','=','images.id')->where(['user_wishlists.user_id'=>$added_by,'images.status'=>1])->select('images.*','user_wishlists.created_at as download_date','images.price as amount')->paginate(5);
        return view('front.user.my-wishlist',compact('title','data'));
    }

    public function removeWishlist($imgId)
    {
        if(Auth::user())
        {
            $userId = Auth::user()->id;
            $detail = DB::table('user_wishlists')->where(['user_id'=>$userId,'image_id'=>$imgId])->first();
            $res = 0;
            if(!empty($detail))
            {
                $res = DB::table('user_wishlists')->where('id',$detail->id)->delete();
            }

            if($res)
            {
                $response['status']='success';
                $response['msg']='Image removed from wishlist successfully';
            }else{
                $response['status']='error';
                $response['msg']='Image not removed from wishlist';
            }
        }else{
            $response['status']='error';
            $response['msg']='Unauthorized acess';
        }
        return $response;
    }

 	public function imageDownload($page_url)
    {
        $title = 'Image Detail';
        $data['detail'] = Images::join('users','users.id','=','images.added_by')->where(['images.page_url'=>$page_url,'images.status'=>1,'images.isApproved'=>1])->select('images.*','users.name as user_name','users.image as user_image')->first();
        if(!empty($data['detail']))
        {
        	$userId = Auth::user()->id;
        	if(Helper::getMyDownload($data['detail']->id))
        	{	
        		$checkdownload = DB::table('user_downloaded')->where(['user_id'=>$userId,'image_id'=>$data['detail']->id])->first();
        		if(empty($checkdownload))
        		{
        			DB::table('user_downloaded')->insert(['user_id'=>$userId,'image_id'=>$data['detail']->id,'price'=>$data['detail']->price,'contributer_id'=>$data['detail']->added_by]);
        		}
        		$path = public_path(). '/storage/'. $data['detail']->image;
   				return response()->download($path);
        	}else{
        		return redirect('user/checkout')->with('front_error','Please select a valid plan to continue download');
        	}
        }else{
        	return back()->with('front_error','Image not found');
        }
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'name'  => 'required',
        'mobile'  => 'required',
        'address'  => 'required',
        'area'     => 'required',
        'pin_code' => 'required',
        'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        'image'    => 'nullable|image|mimes:jpeg,jpg,png',
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
        $address = DB::table('user_address')->where('user_id',Auth::user()->id)->first();
        if(!empty($address))
        {
            $res = DB::table('user_address')->where('user_id',Auth::user()->id)->update(['address'=>trim($request['address']),'area'=>trim($request['area']),'pin_code'=>trim($request['pin_code']),'about_me'=>trim($request['about_me'])]);
        }else{
            $res = DB::table('user_address')->insert(['user_id'=>Auth::user()->id,'address'=>trim($request['address']),'area'=>trim($request['area']),'pin_code'=>trim($request['pin_code']),'about_me'=>trim($request['about_me'])]);
        }
        
        $user = User::find(Auth::user()->id);
        $user->name = trim($request['name']);
        $user->email = trim($request['email']);
        $user->mobile = trim($request['mobile']);
        if(trim($request['password'])!='')
        {
            $user->password = Hash::make(trim($request['password']));
        }

        if($request->hasFile('image')) 
          {
            if($user->image!='')
            {
                if(file_exists('public/assets/photos/'.$user->image))
                {
                    unlink('public/assets/photos/'.$user->image);
                }
            }   
                   
            $file = $request['image'];
            $destinationPath = 'assets/photos';  
            $extension = $file->getClientOriginalExtension(); 
            $fileName = time().rand(1,99999).'.'.$extension; 
            $image_resize = Image::make($file->getRealPath());              
            $image_resize->resize(200, 200);
            $image_resize->save(public_path($destinationPath.'/' .$fileName));
            $user->image = $fileName;
        }

        $res = $user->save();
        if($res)
        {
            $response['status']='success';
            $response['type']  = 'login';
            $response['msg']='Profile update successfully';
        }else{
            $response['status']='error';
            $response['msg']='Profile not updated';
        }
        return $response;
    }

    public function addWishlist($imgId)
    {

        $userId = Auth::user()->id;
        if(Auth::user()->role!=2)
        {
            $response['status']='error';
            $response['msg']='Only customer able to add image in wishlist';
            return $response;
        }
        $detail = DB::table('user_wishlists')->where(['user_id'=>$userId,'image_id'=>$imgId])->first();
        $res = 0;
        if(empty($detail))
        {
          $res = DB::table('user_wishlists')->insert(['user_id'=>$userId,'image_id'=>$imgId]);
        }
        
        if($res)
        {
            $response['status']='success';
            $response['msg']='Image added in wishlist successfully';
        }else{
            $response['status']='error';
            $response['msg']='Image already added in wishlist';
        }
        return $response;
    }

    public function deleteAccount()
    {
        if(Auth::user()){
            $res = User::find(Auth::user()->id);
            $res->status = 0;
            $delete = $res->save();
            if($delete)
            {
                Auth::logout();
                return back()->with('front_success','Your account deleted successfully');
            }else{
                return back()->with('front_error','Please try again');
            }
        }else{
            return back()->with('front_error','Please login');
        }
    }
 	// class end
 }