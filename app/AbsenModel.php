<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AbsenModel extends Model
{
    //
    use SoftDeletes;
    protected $table = "absen";
    protected $guarded = ["id"];

    // relasi ke table jadwal
    public function peserta_r(){
        return $this->belongsTo('App\Peserta','id_peserta');
    }
}
