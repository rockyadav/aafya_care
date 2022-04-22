<?php 
namespace App\Helpers;
use App\User;
use DB;
class Helper
{
	
    public static function getUser($id)
    {
        $user = User::where('id',$id)->first();
        return $user;
    }

    public static function getManuals($manualid='') 
    {
        $id = explode(',', $manualid);
        $data = DB::table('manuals')->whereIn('id',$id)->get();
        return  $data;
       
    }
	
	public static function getTableRow($tablename="",$arrayid="")
    {
        $row = DB::table($tablename)
                    ->where($arrayid)
                    ->first();
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

    
    //class end
}
?>