<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AllCode extends Model {
   
   use SoftDeletes;
   protected $fillable = ['codeTypeId', 'codeTitle', 'code'];
}