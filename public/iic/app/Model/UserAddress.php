<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use Image;

class UserAddress extends Model
{
    protected $table = 'user_address';
    protected $primaryKey = 'id';
    public $timestamps = false;
}