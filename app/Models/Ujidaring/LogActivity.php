<?php

namespace App\Models\UjiDaring;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogActivity extends Model
{
    //
    use SoftDeletes;
    protected $table = "uji_log_activity";
    protected $guarded = ['id'];
}
