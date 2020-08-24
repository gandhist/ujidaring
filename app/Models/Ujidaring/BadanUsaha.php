<?php

namespace App\Models\UjiDaring;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BadanUsaha extends Model
{
    //
    use SoftDeletes;
    protected $table = "uji_badan_usaha";
    protected $guarded = ["id"];
}
