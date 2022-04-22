<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Input;
use Image;
use Auth;
use Helper;
use App\Model\What_we_do;

class What_we_do extends Model
{
    protected $table = 'what_we_do';
    protected $primaryKey = 'id';
  
}
