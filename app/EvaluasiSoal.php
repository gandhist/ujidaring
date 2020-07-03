<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EvaluasiSoal extends Model
{
    //
    use SoftDeletes;
    protected $table ="soal_evaluasi";
    protected $guarded = ['id'];

}
