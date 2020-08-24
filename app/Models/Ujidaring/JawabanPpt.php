<?php

namespace App\Models\UjiDaring;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JawabanPpt extends Model
{
    //
    use SoftDeletes;
    protected $table = "uji_jawaban_ppt";
    protected $guarded = ['id'];

    // relsi ke table peserta 
    public function peserta_r(){
        return $this->belongsTo("App\Models\Ujidaring\Peserta","id_peserta");
    }
}
