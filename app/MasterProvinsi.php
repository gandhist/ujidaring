<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterProvinsi extends Model
{
    //
    use SoftDeletes;
    protected $table = "ms_provinsi";
    protected $guarded = ['id'];
}
