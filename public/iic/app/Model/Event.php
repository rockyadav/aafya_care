<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use Image;

class Event extends Model
{
    protected $table = 'events';
    protected $primaryKey = 'id';
    
}
