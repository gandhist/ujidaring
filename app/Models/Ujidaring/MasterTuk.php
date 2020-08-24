<?php

namespace App\Models\UjiDaring;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterTuk extends Model
{
    //
    use SoftDeletes;
    protected $table = "ms_tuk";
    protected $guarded = ["id"];

    // relasi ke table badan usaha 
    public function badan_usaha_r(){
        return $this->belongsTo('App\Models\Ujidaring\BadanUsaha','pjk3');
    }

    // relasi ke table provinsi 
    public function provinsi_r(){
        return $this->belongsTo('App\Models\Ujidaring\MasterProvinsi','prov');
    }

    // relasi ke table provinsi 
    public function kota_r(){
        return $this->belongsTo('App\Models\Ujidaring\MasterKota','kota');
    }

    // relasi ke table bank 
    public function bank_r(){
        return $this->belongsTo('App\Models\Ujidaring\MasterDaftarBank','id_bank');
    }
}
