<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JadwalInstruktur extends Model
{
        //
        use SoftDeletes;
        protected $table = "jadwal_instruktur";
        protected $guarded = ["id"];

        // relasi ke table jadwal
        public function jadwal_r(){
            return $this->belongsTo('App\JadwalModel','id_jadwal');
        }
}
