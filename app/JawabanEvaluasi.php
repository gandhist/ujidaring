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

    // relasi ke bidang 
    public function instruktur_r(){
        return $this->belongsTo('App\InstrukturModel','id_instruktur');
    }

    // relasi ke bidang 
    public function peserta_r(){
        return $this->belongsTo('App\Peserta','id_peserta');
    }
}
