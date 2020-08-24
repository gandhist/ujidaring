<?php

namespace App\Models\UjiDaring;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InsRundown extends Model
{
    //
    use SoftDeletes;
    protected $table = "uji_instruktur_rundown";
    protected $guarded = ["id"];

    // relasi belong to instruktur
    public function instruktur_r(){
        return $this->belongsTo('App\Models\Ujidaring\InstrukturModel','id_instruktur');
    }

    // relasi belongs to modul
    public function jadwal_rundown_r(){
        return $this->belongsTo('App\Models\Ujidaring\JadwalRundown','id_rundown');
    }

    // relasi ke jadwal modul
    // agar dapat materi dan link zoom
    public function jadwal_instruktur_r(){
        return $this->belongsTo('App\Models\Ujidaring\JadwalInstruktur','id_jadwal_instruktur');
    }
}
