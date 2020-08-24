<?php

namespace App\Models\UjiDaring;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JawabanPeserta extends Model
{
    //
    use SoftDeletes;
    protected $table = "uji_jawaban_peserta";
    protected $guarded = ['id'];

    // relasi ke peserta
    public function peserta_r(){
        return $this->belongsTo('App\Models\Ujidaring\Peserta','id_peserta');
    }

    // relasi ke table soal
    public function soal_r(){
        return $this->belongsTo('App\Models\Ujidaring\SoalPgModel','id_soal');
    }

    // relasi ke table jadwal
    public function jadwal_r(){
        return $this->belongsTo('App\Models\Ujidaring\JadwalModel','id_jadwal');
    }
}
