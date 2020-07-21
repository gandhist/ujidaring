<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogActivity extends Model
{
    //
    use SoftDeletes;
    protected $table = "log_activity";
    protected $guarded = ['id'];
}
