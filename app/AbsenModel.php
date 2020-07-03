<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AbsenModel extends Model
{
    //
    use SoftDeletes;
    protected $table = "absen";
}
