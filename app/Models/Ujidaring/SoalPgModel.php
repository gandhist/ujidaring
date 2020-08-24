<?php

namespace App\Models\UjiDaring;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SoalPgModel extends Model
{
    //
    use SoftDeletes;
    protected $table = 'uji_soal_pg';
    protected $guarded = ["id"];
}
