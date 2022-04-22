<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Input;
use Image;
use Auth;
use Helper;
use DB;
class Packages extends Model
{
    protected $table = 'packages';
    protected $primaryKey = 'id';
    
    public static function saveData($data)
    {
       $inst = new Packages;
       $inst->name        = trim($data['name']);
       $inst->pack_type   = trim($data['pack_type']);
       $inst->description = trim($data['description']);
       $res = $inst->save();
       if($res)
       {
            $lastId = $inst->id;
            $price = $data['price'];
            $image = $data['image'];
            $title = $data['title'];
            $i=0;
            foreach($price as $p)
            {
                $darray = array(
                                'package_id'=>$lastId,
                                'image'     =>$image[$i],
                                'title'     =>$title[$i],
                                'price'     =>$p
                           );
                $pinst = DB::table('package_details')->insert($darray);
                $i++;
            }
            
       }
       return $res;
    }

    public static function getData($id='')
    {	
    	if($id=='')
    	{
    		$res = Packages::where('packages.status',1);
            $res->orderBy('packages.id','desc');
            $result = $res->paginate(25);
    	}else{
    		$result = Packages::where(['id'=>$id,'status'=>1])->first();
    	}        
        return $result; 
    }

    public static function deleteData($id)
    {	
    	$result = Packages::find($id);     
    	$result->status = 0;
    	$res = $result->save();
        return $res; 
    }

    public static function deleteDetail($id)
    {   
        $result = DB::table('package_details')->where('id',$id)->delete();   
        return $result; 
    }

    public static function updateData($id,$data)
    {	
       $inst = Packages::find($id);
       $inst->name        = trim($data['name']);
       $inst->pack_type   = trim($data['pack_type']);
       $inst->description = trim($data['description']);
       $res = $inst->save();
       if($res)
       {
            if(isset($data['price']))
            {
                $price = $data['price'];
                $title = $data['title'];
                $image = $data['image'];
                $i=0;
                foreach($price as $p)
                {
                    $darray = array(
                                    'package_id'=>$id,
                                    'image'     =>$image[$i],
                                    'title'     =>$title[$i],
                                    'price'     =>$p
                               );
                    DB::table('package_details')->insert($darray);
                    $i++;
                }
            }

            if(isset($data['rowId1']))
            {
                $rowId1 = $data['rowId1'];
                $title1 = $data['title1'];
                $price1 = $data['price1'];
                $image1 = $data['image1'];
                $ii=0;
                foreach($rowId1 as $rid)
                {
                    $darray = array(
                                    'package_id'=>$id,
                                    'image'     =>$image1[$ii],
                                    'title'     =>$title1[$ii],
                                    'price'     =>$price1[$ii]
                               );
                    DB::table('package_details')->where('id',$rid)->update($darray);
                    $ii++;
                }
            }
       }
       return $res;
    }

    //
}
