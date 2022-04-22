<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use Image;

class SubCategories extends Model
{
    protected $table = 'sub_categories';
    protected $primaryKey = 'id';
    
    public static function saveData($cat_data)
    {
        $page_url = SubCategories::craeteUrl($cat_data['name']);
        $savedata = new SubCategories();
        $savedata->cat_id   = $cat_data['category'];
        $savedata->name     = ucwords(trim($cat_data['name']));;
        $savedata->page_url = $page_url;

        if (isset($cat_data['image'])) {
            $file = Input::file('image');
            $imageName = time().'.'.$file->extension();
            $destinationPath = public_path('images');
            $img = Image::make($file->path());
            $img->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$imageName);
            $savedata->image = $imageName;
        }

        $res = $savedata->save();
        return $res; 
    }

    public static function getData($id='')
    {	
    	if($id=='')
    	{
    		$result = SubCategories::join('categories','categories.id','=','sub_categories.cat_id')->where('sub_categories.status',1)->orderBy('sub_categories.id','desc')->select('sub_categories.id','sub_categories.name','sub_categories.image','categories.name as category')->get();
    	}else{
    		$result = SubCategories::join('categories','categories.id','=','sub_categories.cat_id')->where('sub_categories.status',1)->orderBy('sub_categories.id','desc')->select('sub_categories.id','sub_categories.name','sub_categories.image','categories.name as category')->where(['sub_categories.id'=>$id,'sub_categories.status'=>1])->first();
    	}        
        return $result; 
    }

    public static function deleteData($id)
    {	
    	$result = SubCategories::find($id);     
    	$result->status = 0;
    	$res = $result->save();
        return $res; 
    }

    public static function updateData($id,$cat_data)
    {	
        $page_url = SubCategories::craeteUrl($cat_data['name']);
    	$savedata = SubCategories::find($id);
        $savedata->name     = ucwords(trim($cat_data['name']));;
        $savedata->cat_id   = $cat_data['category'];
        $savedata->page_url = $page_url;
        $oldimg = $savedata->image;
        if (isset($cat_data['image'])) {
            $file = Input::file('image');
            $imageName = time().'.'.$file->extension();
            $destinationPath = public_path('images');
            $img = Image::make($file->path());
            $img->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$imageName);
            $savedata->image = $imageName;

            if ($oldimg!='' && file_exists(public_path('images/'.$oldimg)))
            {
                unlink(public_path('images/'.$oldimg));   
            }
        }
        $res = $savedata->save();
        return $res;  
    }


     public static function updateStatus($id,$status){  
        $savedata = SubCategories::find($id);
        $savedata->status   = $status;
        $res = $savedata->save();
        return $res; 
    }

    public static function craeteUrl($name)
    {
        $page_url=str_replace(' ','-', $name);
        $page_url=str_replace('.','-', $page_url);
        $page_url=str_replace('/','-', $page_url);
        $page_url=str_replace('?','-', $page_url);
        $page_url=str_replace('%','-', $page_url);
        return strtolower($page_url);
    }

    //
}
