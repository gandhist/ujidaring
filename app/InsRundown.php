<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InsRundown extends Model
{
    //
    use SoftDeletes;
    protected $table = "instruktur_rundown";
    protected $guarded = ["id"];

    // relasi belong to instruktur
    public function instruktur_r(){
        return $this->belongsTo('App\InstrukturModel','id_instruktur');
    }

    // relasi belongs to modul
    public function jadwal_rundown_r(){
        return $this->belongsTo('App\JadwalRundown','id_rundown');
    }
}
