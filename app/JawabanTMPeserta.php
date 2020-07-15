<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JawabanTMPeserta extends Model
{
       //
       protected $table = "jawaban_tm";
       protected $guarded = ['id'];

       // relasi ke jadwal_modul
       public function jadwal_modul_r(){
            return $this->belongsTo('App\JadwalModul','id_jadwal_modul');
       }
   
}
