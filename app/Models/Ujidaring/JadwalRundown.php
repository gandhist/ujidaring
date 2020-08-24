<?php

namespace App\Models\UjiDaring;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JadwalRundown extends Model
{
    //
    use SoftDeletes;
    protected $table = "uji_jadwal_rundown";
    protected $guarded = ["id"];

    // relasi has many ke table ins rundown
    public function ins_rundown_r(){
        return $this->hasMany('App\Models\Ujidaring\InsRundown','id_rundown');
    }

    // relasi has many ke table modul rundown
    public function modul_rundown_r(){
        return $this->hasMany('App\Models\Ujidaring\ModulRundown','id_rundown');
    }

    // relasi belongs to ke table jadwal
    public function jadwal_r(){
        return $this->belongsTo('App\Models\Ujidaring\JadwalModel','id_jadwal');
    }
}
