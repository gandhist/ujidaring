<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class JawabanPkl extends Model
{
    //
    use SoftDeletes;
    protected $table = "jawaban_pkl";
    protected $guarded = ['id'];

    // relsi ke table peserta 
    public function peserta_r(){
        return $this->belongsTo("App\Peserta","id_peserta");
    }
}
