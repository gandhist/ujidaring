<?php

namespace App\Models\Ujidaring;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JadwalModel extends Model
{
    //
    use SoftDeletes;
    protected $table = "uji_jadwal";
    protected $guarded = ["id"];

    // relasi has many ke table soal pg
    public function soalpg_r(){
        return $this->hasMany('App\Models\Ujidaring\SoalPgModel','kelompok_soal','id_klp_soal_pg')->orderBy('no_soal','asc');
    }

    // relasi has many ke table soal essay
    public function soales_r(){
        return $this->hasMany('App\Models\Ujidaring\SoalEssayModel','kelompok_soal','id_klp_soal_essay')->orderBy('no_soal','asc');
    }

    // relasi ke bidang 
    public function bidang_r(){
        return $this->belongsTo('App\Models\Ujidaring\MasterBidang','id_bidang');
    }

    // relasi ke jenis udaha
    public function jenis_usaha_r(){
        return $this->belongsTo('App\Models\Ujidaring\MasterJenisUsaha','id_jenis_usaha');
    }

    // relasi ke table sertifikat alat 
    public function sertifikat_alat_r(){
        return $this->belongsTo('App\Models\Ujidaring\MasterSertifikatAlat','id_sert_alat');
    }

    // relasi has many ke table jadwal modul
    public function jadwal_modul_r(){
        return $this->hasMany('App\Models\Ujidaring\JadwalModul','id_jadwal');
    }

    // relasi ke has manny ke table instruktur
    public function instruktur_r(){
        return $this->hasMany('App\Models\Ujidaring\JadwalInstruktur','id_jadwal');
    }

    // relasi ke has manny ke table peserta
    public function peserta_r(){
        return $this->hasMany('App\Models\Ujidaring\Peserta','id_kelompok','id_klp_peserta');
    }

    // relasi ke has many ke table jadwal rundown
    public function jadwal_rundown_r(){
        return $this->hasMany('App\Models\Ujidaring\JadwalRundown','id_jadwal','id');
    }


}
