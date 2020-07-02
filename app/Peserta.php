<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Peserta extends Model
{
    //
    use SoftDeletes;
    protected $table = "peserta";
    protected $guarded = ["id"];

    // relasi ke table user
    public function user_r(){
        return $this->belongsTo('App\User','user_id');
    }

    // relasi ke table jadwal
    public function jadwal_r(){
        return $this->belongsTo('App\JadwalModel','id_kelompok','id_klp_peserta');
    }
}
