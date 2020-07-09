<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JadwalRundown extends Model
{
    //
    use SoftDeletes;
    protected $table = "jadwal_rundown";

    // relasi has many ke table ins rundown
    public function ins_rundown_r(){
        return $this->hasMany('App\InsRundown','id_rundown');
    }

    // relasi has many ke table modul rundown
    public function modul_rundown_r(){
        return $this->hasMany('App\ModulRundown','id_rundown');
    }

    // relasi belongs to ke table jadwal
    public function jadwal_r(){
        return $this->belongsTo('App\JadwalModel','id_jadwal');
    }
}
