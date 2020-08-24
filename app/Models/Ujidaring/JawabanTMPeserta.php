<?php

namespace App\Models\UjiDaring;

use Illuminate\Database\Eloquent\Model;

class JawabanTMPeserta extends Model
{
       //
       protected $table = "uji_jawaban_tm";
       protected $guarded = ['id'];

       // relasi ke jadwal_modul
       public function jadwal_modul_r(){
            return $this->belongsTo('App\Models\Ujidaring\JadwalModul','id_jadwal_modul');
       }
   
}
