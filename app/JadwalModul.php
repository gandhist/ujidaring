<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JadwalModul extends Model
{
    //
    use SoftDeletes;
    protected $table = "jadwal_modul";
    protected $guarded = ["id"];

    // relasi ke table ms modul
    public function modul_r(){
        return $this->belongsTo('App\MasterModul','id_modul');
    }

    // relasi has many soal pre
    public function soal_pre(){
        return $this->hasMany('App\SoalPgPreModel','id_jadwal_modul');
    }

    // relasi has many soal pre
    public function soal_post(){
        return $this->hasMany('App\SoalPgPostModel','id_jadwal_modul');
    }

     // relasi has many soal pre
     public function soal_pre_today(){
        return $this->hasMany('App\SoalPgPreModel','id_jadwal_modul');
    }
}
