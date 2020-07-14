<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JawabanPesertaPgPre extends Model
{
           //
           protected $table = "jawaban_peserta_pg_pre";
           protected $guarded = ['id'];
       
           // relasi ke peserta
           public function modul_rundown_r(){
               return $this->belongsTo('App\ModulRundown','id_modul_rundown');
           }
}
