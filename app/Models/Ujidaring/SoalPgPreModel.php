<?php

namespace App\Models\UjiDaring;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SoalPgPreModel extends Model
{
    //
    use SoftDeletes;
    protected $table = 'uji_soal_pg_pre';
    protected $guarded = ["id"];
    
    // Relasi ke table jadwal modul
    public function jadwal_modul_r(){
        return $this->belongsTo('App\Models\Ujidaring\JadwalModul','id_jadwal_modul');
    }
    
}
