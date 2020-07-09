<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModulRundown extends Model
{
    //
    use SoftDeletes;
    protected $table = "modul_rundown";
    protected $guarded = ["id"];

    // relasi belong to modul
    public function modul_r(){
        return $this->belongsTo('App\MasterModul','id_instruktur');
    }

    // relasi belongs to modul
    public function jadwal_rundown_r(){
        return $this->belongsTo('App\JadwalRundown','id_rundown');
    }

    // relasi ke jadwal modul
    // agar dapat materi dan link zoom
    public function jadwal_modul_r(){
        return $this->hasMany('App\JadwalModul','id_jadwal_modul');
    }
}
