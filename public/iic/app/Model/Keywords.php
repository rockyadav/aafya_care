<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Keywords extends Model
{
    protected $table = 'keywords';
    protected $primaryKey = 'id';
    
    public static function saveData($cat_data)
    {
        $page_url = Keywords::craeteUrl($cat_data['name']);
        $savedata = new Keywords();
        $savedata->name     = $cat_data['name'];
        $savedata->page_url = $page_url;
        $res = $savedata->save();
        return $res; 
    }

    public static function getData($id='')
    {	
    	if($id=='')
    	{
    		$result = Keywords::where('status',1)->orderBy('id','desc')->get();
    	}else{
    		$result = Keywords::where(['id'=>$id,'status'=>1])->first();
    	}        
        return $result; 
    }

    public static function deleteData($id)
    {	
    	$result = Keywords::find($id);     
    	$result->status = 0;
    	$res = $result->save();
        return $res; 
    }

    public static function updateData($id,$cat_data)
    {	
        $page_url = Keywords::craeteUrl($cat_data['name']);
    	$savedata = Keywords::find($id);
        $savedata->name     = $cat_data['name'];
        $savedata->page_url = $page_url;
        $res = $savedata->save();
        return $res;  
    }


     public static function updateStatus($id,$status){  
        $savedata = Keywords::find($id);
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
        return strtolower($page_url);
    }

    //
}
