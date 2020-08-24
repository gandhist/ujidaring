<?php

namespace App\Models\UjiDaring;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PesertaQuis extends Model
{
    //
    use SoftDeletes;
    protected $table = "uji_peserta_quis";
    protected $guarded = ['id'];

    // relasi ke peserta
    public function peserta_r(){
        return $this->belongsTo('App\Models\Ujidaring\Peserta','id_peserta');
    }

    // relasi ke soalpgpre
    public function jumlah_soal_pre_r(){
        return $this->hasMany('App\Models\Ujidaring\SoalPgPreModel','id_jadwal_modul','id_jadwal_modul');
    }

    // relasi ke soalpgpost
    public function jumlah_soal_post_r(){
        return $this->hasMany('App\Models\Ujidaring\SoalPgPostModel','id_jadwal_modul','id_jadwal_modul');
    }

    // relasi ke jadwalmodul
    public function jadwal_modul_r(){
        return $this->belongsTo('App\Models\Ujidaring\JadwalModul','id_jadwal_modul');
    }
}
