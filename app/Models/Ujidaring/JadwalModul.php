<?php

namespace App\Models\UjiDaring;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JadwalModul extends Model
{
    //
    use SoftDeletes;
    protected $table = "uji_jadwal_modul";
    protected $guarded = ["id"];

    // relasi ke table ms modul
    public function modul_r(){
        return $this->belongsTo('App\Models\Ujidaring\MasterModul','id_modul');
    }

    // relasi has many soal pre
    public function soal_pre(){
        return $this->hasMany('App\Models\Ujidaring\SoalPgPreModel','id_jadwal_modul');
    }

    // relasi has many soal pre
    public function soal_post(){
        return $this->hasMany('App\Models\Ujidaring\SoalPgPostModel','id_jadwal_modul');
    }

     // relasi has many soal pre
     public function soal_pre_today(){
        return $this->hasMany('App\Models\Ujidaring\SoalPgPreModel','id_jadwal_modul');
    }
}
