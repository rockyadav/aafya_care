<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','mobile','status','role','token','verify'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function getData($id='',$type='',$username='',$name='')
    {   

        if($type!='' && $id=='')
        {
            $res = User::where(['users.role'=>$type,'users.status'=>1]);
            $res->leftJoin('centres', function ($query) {
                $query->on('centres.id', '=', 'users.centre_id')
                    ->where('centres.status',1);
            });
            $res->leftJoin('states', function ($query) {
                $query->on('states.id', '=', 'users.state_id')
                    ->where('states.status',1);
            });
            $res->leftJoin('cities', function ($query) {
                $query->on('cities.id', '=', 'users.city_id')
                    ->where('cities.status',1);
            });
            if($username!='')
            {
                $res->where('users.username',$username);
            }
            if($name!='')
            {
                $res->where('users.name',$name);
            }
            $res->select('users.*','centres.centre_area as center_name','states.state_name','cities.city_name');
            $res->orderBy('users.id','desc');
            $result = $res->paginate(25);
        }elseif($id=='')
        {
            $result = User::join('centres','centres.id','=','users.centre_id')->where(['users.status'=>1])->select('users.*','centres.centre_area as center_name')->orderBy('users.id','desc')->paginate(25);
        }elseif($id!='' && $type!=''){
            $result = User::where(['id'=>$id,'role'=>$type])->first();
        }else{
            $result = User::where(['id'=>$id,'role'=>3])->first();
        }         
        return $result; 
    }
    
    public static function saveData($data)
    {
        $role = 3;
        if(isset($data['role']))
        {
            $role = $data['role'];
        }
        $user               =  new User();
        $user->state_id      = trim($data['state_name']);
        if($role==3)
        {
            $user->city_id      = trim($data['city_name']);
            $user->centre_id    = trim($data['centre_area']);
        }        
        $user->email        = trim($data['email']);
        $user->mobile       = trim($data['mobile_number']);
        $user->username     = trim($data['username']);
        $user->password     = bcrypt(trim($data['password']));
        $user->role         = $role;
        return $res         = $user->save(); 
    }

     public static function updateData($id,$data)
    {

        $role = 3;
        if(isset($data['role']))
        {
            $role = $data['role'];
        }

        $user               = User::find($id);
        $user->state_id     = trim($data['state_name']);
        if($role==3)
        {
            $user->city_id      = trim($data['city_name']);
            $user->centre_id    = trim($data['centre_area']);
        } 
        $user->email        = trim($data['email']);
        $user->mobile       = trim($data['mobile_number']);
        $user->username     = trim($data['username']);
        $user->isLogin      = trim($data['isLogin']);

        if($data['password']!='')
        {
            $user->password     = bcrypt(trim($data['password']));
        }
        
        $res = $user->save(); 
        $modify = $user->getChanges();
        if(isset($modify['isLogin']))
        {
           DB::table('users')->where('centre_manager_id',$id)->update(['isLogin'=>$data['isLogin']]);
        }
        return $res;
    }

    public static function saveStudentData($data)
    {
        $user                     =  new User();
        $user->name               = trim($data['name']);
        $user->username           = trim($data['username']);
        $user->mobile             = trim($data['mobile_number']);
        $user->email              = trim($data['email']);
        $user->alternate_mobile   = trim($data['alternate_mobile']);
        $user->country_id         = trim($data['country_name']);
        $user->state_id           = trim($data['state_name']);
        $user->std_level_id       = trim($data['level_name']);
        if($data['year_of_birth']>0)
        {
            $user->year_of_birth    = trim($data['year_of_birth']);
        }
        $user->age                  = trim($data['age']);
        $user->age_group            = trim($data['group']);
        $user->password             = bcrypt(trim($data['password']));
        $user->role                 = 2;
        $user->join_referral_number = trim($data['referral_code']);
        $res = $user->save(); 
        if($res)
        {
           $up = User::where('id',$user->id)->first();
           $up->my_referral_number = $up->username.''.$up->id;
           $up->save();
        }
        return $res;
    }

    public static function updateStudentData($id,$data)
    {
        $user                     =  User::find($id);
        $user->name               = trim($data['name']);
        $user->username           = trim($data['username']);
        $user->mobile             = trim($data['mobile_number']);
        $user->email              = trim($data['email']);
        $user->alternate_mobile   = trim($data['alternate_mobile']);
        $user->country_id         = trim($data['country_name']);
        $user->state_id           = trim($data['state_name']);
        $user->std_level_id       = trim($data['level_name']);
        if($data['year_of_birth']>0)
        {
            $user->year_of_birth      = trim($data['year_of_birth']);
        }
        $user->age                = trim($data['age']);
        $user->age_group          = trim($data['group']);
        $user->isLogin            = trim($data['isLogin']);

        if(trim($data['password'])!='')
        {
            $user->password           = bcrypt(trim($data['password']));
        }
        
        $user->role               = 2;
        $user->my_referral_number = trim($data['username']).''.$id;
        return $res = $user->save(); 
    }

    public static function deleteData($id)
    {   
        $result = User::find($id);     
        $result->status = 0;
        $result->save();
        return $result; 
    }
}
