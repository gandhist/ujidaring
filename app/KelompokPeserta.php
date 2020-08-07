<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KelompokPeserta extends Model
{
    //
    use SoftDeletes;
    protected $table = "kelompok_peserta";
    protected $guarded = ["id"];

    // relasi ke peserta
    public function peserta_r(){
        return $this->belongsTo('App\Peserta','id_peserta');
    }

     // relasi ke peserta
     public function ketua_r(){
        return $this->belongsTo('App\Peserta','id_ketua');
    }
        
}
