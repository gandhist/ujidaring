<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterModul extends Model
{
    //
    use SoftDeletes;
    protected $table = "ms_modul";
    protected $guarded = ['id'];

    // relasi ke bidang
    public function bidang_srtf_alat_r(){
          return $this->belongsTo('App\MasterSertifikatAlat','id_bid_srtf_alat');
    }
}
