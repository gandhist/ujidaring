<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Peserta extends Model
{
    //
    use SoftDeletes;
    protected $table = "peserta";
    protected $guarded = ["id"];

    // relasi ke table user
    public function user_r(){
        return $this->belongsTo('App\User','user_id');
    }

    // relasi ke table jadwal
    public function jadwal_r(){
        return $this->belongsTo('App\JadwalModel','id_kelompok','id_klp_peserta');
    }

    // relasi ke jawaban pg
    public function jawaban_r(){
        return $this->hasMany('App\JawabanPeserta','id_peserta');
    }

    // relasi ke jawaban pg
    public function jawaban_essay_r(){
        return $this->hasMany('App\JawabanEssayPeserta','id_peserta');
    }

    // relasi ke jawaban evaluasi
    public function jawaban_eva_r(){
        return $this->hasMany('App\JawabanEvaluasi','id_peserta')->where('tanggal',\Carbon\Carbon::now()->isoFormat('YYYY-MM-DD'));
    }
}
