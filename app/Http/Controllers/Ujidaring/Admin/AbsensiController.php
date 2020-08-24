<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AbsenModel;
use App\Peserta;

class AbsensiController extends Controller
{
    //

    // index 
    public function index($id){
        $jadwal = Peserta::where('id_kelompok',$id)->get(['id']);
        return $jadwal;
        $data = AbsenModel::orderBy('id','asc');
        $data = $data->get();
        return view('ujidaring.presensi.index')->with(compact('data'));
    }
}
