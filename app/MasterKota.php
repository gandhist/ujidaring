<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterKota extends Model
{
    //
    use SoftDeletes;
    protected $table = "ms_kota";
    protected $guarded = ['id'];
}
