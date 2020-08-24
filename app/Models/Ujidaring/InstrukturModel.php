<?php

namespace App\Models\UjiDaring;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstrukturModel extends Model
{
        //
        use SoftDeletes;
        protected $table = "uji_instruktur";
        protected $guarded = ["id"];

        // relasi ke table user
        public function user_r(){
             return $this->belongsTo('App\Models\Ujidaring\User','id_users');
        }

        // relasi ke table jadwal
        public function jadwal_r(){
                return $this->belongsTo('App\Models\Ujidaring\JadwalInstruktur','id','id_instruktur');
        }
}
