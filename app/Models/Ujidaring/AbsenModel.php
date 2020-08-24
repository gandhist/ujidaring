<?php

namespace App\Models\UjiDaring;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AbsenModel extends Model
{
    //
    use SoftDeletes;
    protected $table = "uji_absen";
    protected $guarded = ["id"];

    // relasi ke table jadwal
    public function peserta_r(){
        return $this->belongsTo('App\Models\Ujidaring\Peserta','id_peserta');
    }
}
