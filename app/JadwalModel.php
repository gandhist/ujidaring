<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JadwalModel extends Model
{
    //
    use SoftDeletes;
    protected $table = "jadwal";
    protected $guarded = ["id"];

    // relasi has many ke table soal pg
    public function soalpg_r(){
        return $this->hasMany('App\SoalPgModel','kelompok_soal','id_klp_soal_pg')->orderBy('no_soal','asc');
    }

    // relasi has many ke table soal essay
    public function soales_r(){
        return $this->hasMany('App\SoalEssayModel','kelompok_soal','id_klp_soal_essay')->orderBy('no_soal','asc');
    }

    // relasi ke bidang 
    public function bidang_r(){
        return $this->belongsTo('App\MasterBidang','id_bidang');
    }

    // relasi ke jenis udaha
    public function jenis_usaha_r(){
        return $this->belongsTo('App\MasterJenisUsaha','id_jenis_usaha');
    }

    // relasi ke table sertifikat alat 
    public function sertifikat_alat_r(){
        return $this->belongsTo('App\MasterSertifikatAlat','id_sert_alat');
    }

    // relasi has many ke table jadwal modul
    public function jadwal_modul_r(){
        return $this->hasMany('App\JadwalModul','id_jadwal');
    }


}
