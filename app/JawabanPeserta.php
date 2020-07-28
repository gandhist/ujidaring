<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JawabanPeserta extends Model
{
    //
    use SoftDeletes;
    protected $table = "jawaban_peserta";
    protected $guarded = ['id'];

    // relasi ke peserta
    public function peserta_r(){
        return $this->belongsTo('App\Peserta','id_peserta');
    }

    // relasi ke table soal
    public function soal_r(){
        return $this->belongsTo('App\SoalPgModel','id_soal');
    }

    // relasi ke table jadwal
    public function jadwal_r(){
        return $this->belongsTo('App\JadwalModel','id_jadwal');
    }
}
