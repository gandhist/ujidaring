<?php

namespace App\Models\UjiDaring;

use Illuminate\Database\Eloquent\Model;

class MasterSertifikatAlat extends Model
{
    //
    protected $table = "ms_bid_sertifikat_alat";
    protected $guarded = ['id'];

    // relasi ke bidang
    public function bidang_r(){
          return $this->belongsTo('App\Models\Ujidaring\MasterBidang','id_bid');
    }
}
