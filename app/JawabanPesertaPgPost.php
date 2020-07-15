<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JawabanPesertaPgPost extends Model
{
       //
       protected $table = "jawaban_peserta_pg_post";
       protected $guarded = ['id'];
   
       // relasi ke modul_rundown
       public function modul_rundown_r(){
           return $this->belongsTo('App\ModulRundown','id_modul_rundown');
       }
}
