<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JawabanPesertaPgPre extends Model
{
    //
    use SoftDeletes;
    protected $table = "jawaban_peserta_pg_pre";
    protected $guarded = ['id'];

    // relasi ke modul_rundown
    public function modul_rundown_r(){
        return $this->belongsTo('App\ModulRundown','id_modul_rundown');
    }

    // relasi ke table soal
    public function soal_r(){
        return $this->belongsTo('App\SoalPgPreModel','id_soal_pg_pre');
    }
}
