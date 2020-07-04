<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use App\JadwalInstruktur;
// use App\InstrukturModel;
// use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        // $id_user = Auth::id();
        // $getIdInstruktur = InstrukturModel::where("id_users","=",$id_user)->first();
        // $data = JadwalInstruktur::where('id_instruktur','=',$getIdInstruktur->id)->orderBy("id_jadwal","asc")->get();
        // $jumlahjadwal = JadwalInstruktur::where('id_instruktur','=',$getIdInstruktur->id)->count();
        return view('home');
    }
}
