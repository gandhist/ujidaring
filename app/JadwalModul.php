<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JadwalModul extends Model
{
    //
    use SoftDeletes;
    protected $table = "jadwal_modul";
    protected $guarded = ["id"];

    // relasi ke table ms modul
    public function modul_r(){
        return $this->belongsTo('App\MasterModul','id_modul');
    }
}
