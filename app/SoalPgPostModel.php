<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SoalPgPostModel extends Model
{
    //
    use SoftDeletes;
    protected $table = 'soal_pg_post';
    protected $guarded = ["id"];

    // Relasi ke table jadwal modul
    public function jadwal_modul_r(){
        return $this->belongsTo('App\JadwalModul','id_jadwal_modul');
    }
}
