<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BadanUsaha extends Model
{
    //
    use SoftDeletes;
    protected $table = "badan_usaha";
    protected $guarded = ["id"];
}
