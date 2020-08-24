<?php

namespace App\Models\UjiDaring;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JadwalInstruktur extends Model
{
        //
        use SoftDeletes;
        protected $table = "uji_jadwal_instruktur";
        protected $guarded = ["id"];

        // relasi ke table jadwal
        public function jadwal_r(){
            return $this->belongsTo('App\Models\Ujidaring\JadwalModel','id_jadwal');
        }

        // relasi belongs to ke table instruktur
        public function instruktur_r(){
            return $this->belongsTo('App\Models\Ujidaring\InstrukturModel','id_instruktur');
        }

        // relasi has many ke table jadwal modul
        public function jadwal_modul_r(){
            return $this->hasMany('App\Models\Ujidaring\JadwalModul','id_jadwal');
        }
}
