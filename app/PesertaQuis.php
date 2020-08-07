<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PesertaQuis extends Model
{
    //
    use SoftDeletes;
    protected $table ="peserta_quis";
    protected $guarded = ['id'];

    // relasi ke bidang
    public function peserta_r(){
        return $this->belongsTo('App\Peserta','id_peserta');
    }

    // relasi ke bidang
    public function jumlah_soal_pre_r(){
        return $this->hasMany('App\SoalPgPreModel','id_jadwal_modul','id_jadwal_modul');
    }

    // relasi ke bidang
    public function jumlah_soal_post_r(){
        return $this->hasMany('App\SoalPgPostModel','id_jadwal_modul','id_jadwal_modul');
    }

}
