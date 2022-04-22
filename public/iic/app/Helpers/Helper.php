<?php 
namespace App\Helpers;
use App\Model\Images;
use App\User;
use DB;
use Auth;
class Helper
{
  public static function getTableRow($tablename="",$arrayid="")
  {
    $row = DB::table($tablename)
    ->where($arrayid)
    ->first();
    return $row; 
  } 

  public static function getTableResultArray($tablename="",$arrayid="")
  {
    $row = DB::table($tablename)
    ->whereIn('id',$arrayid)
    ->get();
    return $row; 
  } 
  public static function getTableRowOR($tablename="",$arrayid="")
  {
    $row = DB::table($tablename)
    ->where('user_id',$arrayid)
    ->orWhere('meeting_user_id',$arrayid)
    ->first();
    return $row; 
  }


  public static function getTableResult($tablename="")
  {
    $result = DB::table($tablename)->get();
    return $result; 
  } 

  public static function getTableResultByID($tablename="",$arrayid="")
  {
    $result = DB::table($tablename) 
    ->where($arrayid)
    ->get();
    return $result; 
  }

  public static function getTableLastRow($tablename="",$arrayid="")
  {
    $result = DB::table($tablename) 
    ->where($arrayid)
    ->orderBy('id', 'desc')
    ->take(1)->get();

    return $result; 
  }

  public static function getUser($id)
  {
    $user = User::where('id',$id)->first();
    return $user;
  }


  public static function getCommission()
  {
    $data['settings'] = DB::table('settings')->where('id',1)->first();
    $data['commission'] = 0;
    if(!empty($data['settings']))
    {
       $data['commission'] = $data['settings']->description;
    }
    return $data['commission'];
  }

  public static function getFreeUpload()
  {
    $data['settings'] = DB::table('settings')->where('id',2)->first();
    $data['upload'] = 0;
    if(!empty($data['settings']))
    {
       $data['upload'] = $data['settings']->description;
    }
    return $data['upload'];
  }

  public static function getFreeDownload()
  {
    $data['settings'] = DB::table('settings')->where('id',3)->first();
    $data['download'] = 0;
    if(!empty($data['settings']))
    {
       $data['download'] = $data['settings']->description;
    }
    return $data['download'];
  }

  public static function getUserRemainingImages()
  {
    $userId = Auth::user()->id;
    $freeimage = DB::table('user_subscriptions')->where(['user_id'=>$userId,'plan_name'=>'Free Download'])->sum('image');
    $todayDate = date('Y-m-d');
    $planimage = DB::table('user_subscriptions')->where('user_id',$userId)->where('plan_name','!=','Free Download')->whereDate('end_date','>=',$todayDate)->get();
    $totalplanImage = $freeimage;
    if(count($planimage)>0)
    {
       foreach($planimage as $plan)
       {
          if($plan->pack_type=='Monthly Plan')
          {
            $totalplanImage = $totalplanImage + $plan->image;
          }

          if($plan->pack_type=='Quarterly Plan')
          {
            $totalplanImage = $totalplanImage + ($plan->image * 3);
          }

          if($plan->pack_type=='Annual Plan')
          {
            $totalplanImage = $totalplanImage + ($plan->image * 12);
          }
       }
    }

    $downloadedimage = DB::table('user_downloaded')->where('type','free')->where('user_id',$userId)->count();
    $remainingImages = $totalplanImage - $downloadedimage;
    return $remainingImages;
  }

  public static function myApprovedImages()
  {
    $userId = Auth::user()->id;
    $images = Images::where('added_by',$userId)->where('isApproved',1)->count();
    return $images;
  }

  public static function getTotalDownloads($imgId)
  {
    $downloads = DB::table('user_downloaded')->where('image_id',$imgId)->count();
    return $downloads;
  }

  public static function getMyDownload($imgId)
  {
    $userId = Auth::user()->id;
    $planimage = DB::table('user_subscriptions')->where('user_id',$userId)->where('pack_type','Images Plan')->sum('image');
    $downloadedimage = DB::table('user_downloaded')->where('type','free')->where('user_id',$userId)->count();

    $checkdownload = DB::table('user_downloaded')->where(['user_id'=>$userId,'image_id'=>$imgId])->first();
    $download = 0;
    if(($planimage>$downloadedimage) || !empty($checkdownload))
    {
      $download = 1;
    }

    //check monthly or annual pack
    $todayDate = date('Y-m-d');
    $longpack = DB::table('user_subscriptions')->where('user_id',$userId)->where('pack_type','!=','Images Plan')->whereDate('end_date','>=',$todayDate)->get();
    if(count($longpack)>0 && $download==0)
    {
        $totalImg = 0;
        foreach($longpack as $lp)
        {
           if($lp->pack_type=='Monthly Plan'){
            $totalImg += $lp->image;
           }

           if($lp->pack_type=='Quarterly Plan'){
            $totalImg += ($lp->image * 3);
           }

           if($lp->pack_type=='Annual Plan'){
            $totalImg += ($lp->image * 12);
           }
        }
        
        //check download
        $remainingYearImg = $totalImg - $downloadedimage;
        if($remainingYearImg>0)
        {
            $download = 1;
        }

        //echo $monthly; echo '<br>'; echo $annualy;die;
    }
    return $download;
  }

  public static function getUserdata()
  {
    $userId = Auth::user()->id;
    $user = DB::table('users')->where('id',$userId)->first();
    return $user;
  }

  public static function getSocialLinks()
  {
    $detail = DB::table('website_details')->where('website_id',7)->get();
    return $detail;
  }

  public static function getWishlist($imgId)
  {
    if(Auth::user())
    {
        $userId = Auth::user()->id;
        $detail = DB::table('user_wishlists')->where(['user_id'=>$userId,'image_id'=>$imgId])->first();
        if(!empty($detail))
        {
          return 1;
        }else{
          return 0;
        }
    }else{
      return 0;
    }
  }
  //class end
}
?>