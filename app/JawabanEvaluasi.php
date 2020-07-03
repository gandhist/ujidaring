<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JawabanEvaluasi extends Model
{
    //
    use SoftDeletes;
    protected $table = "jawaban_evaluasi";
    protected $guarded = ['id'];

    // relasi ke table soal eva
    public function soal_r(){
        return $this->belongsTo('App\EvaluasiSoal','id_evaluasi');
    }
}
