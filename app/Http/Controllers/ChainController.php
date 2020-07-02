<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MasterSertifikatAlat;
use App\MasterModul;

class ChainController extends Controller
{
    public function bidang(Request $request){
        return $data = MasterSertifikatAlat::where('id_bid', '=', $request->bid)
            ->get(['id','nama_srtf_alat as text']);
}

public function getDataModul(Request $request){
    return $data = MasterModul::where('id_bid_srtf_alat', '=', $request->id_sert_alat)
        ->get();
}

}
