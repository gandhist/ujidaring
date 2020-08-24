<?php

namespace App\Models\UjiDaring;

use Illuminate\Database\Eloquent\Model;

class JawabanEssayPeserta extends Model
{
    //
    protected $table = "uji_jawaban_essay_peserta";
    protected $guarded = ['id'];

    // relasi ke peserta
    public function peserta_r(){
        return $this->belongsTo('App\Models\Ujidaring\Peserta','id_peserta');
    }

    // relasi ke table soal
    public function soal_r(){
        return $this->belongsTo('App\Models\Ujidaring\SoalEssayModel','id_soal');
    }

    // relasi ke table jadwal
    public function jadwal_r(){
        return $this->belongsTo('App\Models\Ujidaring\JadwalModel','id_jadwal');
    }
}
