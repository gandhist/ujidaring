<?php

namespace App\Http\Controllers\Ujidaring\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ujidaring\MasterSertifikatAlat;
use App\Models\Ujidaring\MasterModul;
use DB;

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

public function chained_prov(Request $req){
    if ($req->prov) {
        return $data = DB::table('ms_kota')
            ->where('provinsi_id', '=', $req->prov)
            ->get(['id','nama as text']);
    }
    else {
        return $data = DB::table('ms_kota')
            ->where('id', '=', $req->kota)
            ->get(['provinsi_id']);
    }
}

}
