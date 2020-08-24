<?php

namespace App\Models\UjiDaring;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KelompokPeserta extends Model
{
    //
    use SoftDeletes;
    protected $table = "uji_kelompok_peserta";
    protected $guarded = ["id"];

    // relasi ke peserta
    public function peserta_r(){
        return $this->belongsTo('App\Models\Ujidaring\Peserta','id_peserta');
    }

     // relasi ke peserta
     public function ketua_r(){
        return $this->belongsTo('App\Models\Ujidaring\Peserta','id_ketua');
    }
        
}
