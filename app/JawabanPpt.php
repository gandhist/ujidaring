<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JawabanPpt extends Model
{
    //
    use SoftDeletes;
    protected $table = "jawaban_ppt";
    protected $guarded = ['id'];

    // relsi ke table peserta 
    public function peserta_r(){
        return $this->belongsTo("App\Peserta","id_peserta");
    }
}
