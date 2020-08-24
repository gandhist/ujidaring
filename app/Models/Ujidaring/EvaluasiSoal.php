<?php

namespace App\Models\UjiDaring;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EvaluasiSoal extends Model
{
    //
    use SoftDeletes;
    protected $table = "uji_soal_evaluasi";
    protected $guarded = ['id'];

}
