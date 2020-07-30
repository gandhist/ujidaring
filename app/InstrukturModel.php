<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstrukturModel extends Model
{
        //
        use SoftDeletes;
        protected $table = "instruktur";
        protected $guarded = ["id"];

        // relasi ke table user
        public function user_r(){
             return $this->belongsTo('App\User','id_users');
        }

        // relasi ke table jadwal
        public function jadwal_r(){
                return $this->belongsTo('App\JadwalInstruktur','id','id_instruktur');
        }
}
