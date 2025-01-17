<?php

namespace App\Models\UjiDaring;

use Illuminate\Database\Eloquent\Model;

class MasterBidang extends Model
{
    //
    protected $table = "ms_bidang";
    protected $guarded = ["id"];
    // relasi ke jenis usaha
    public function jenis_usaha_r(){
        return $this->belongsTo('App\Models\Ujidaring\MasterJenisUsaha','id_jns_usaha');
    }
}
