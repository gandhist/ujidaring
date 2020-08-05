<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\JadwalModel;
// use App\JadwalInstruktur;
// use App\InstrukturModel;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        $data = JadwalModel::orderBy("id","asc")->get();
        $jumlahjadwal = JadwalModel::count();
        if(Auth::user()->role_id == 2){
            return redirect('peserta/dashboard');
        }
        return view('home')->with(compact('data','jumlahjadwal'));
    }
}
