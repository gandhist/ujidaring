<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JadwalModul extends Model
{
    //
    protected $table = "jadwal_modul";

    // relasi ke table ms modul
    public function modul_r(){
        return $this->belongsTo('App\MasterModul','id_modul');
    }
}
