<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JadwalModel;
use App\Peserta;
use App\SoalPgModel;
use App\SoalEssayModel;

class DashboardInstrukturController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('homeInstruktur');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = JadwalModel::find($id);
        $Peserta = Peserta::where("id_kelompok","=",$data->id_klp_peserta)->orderBy('nama','asc')->get();
        $jumlahPeserta = Peserta::where("id_kelompok","=",$data->id_klp_peserta)->count();
        $jumlahSoalPg = SoalPgModel::where("kelompok_soal","=",$data->id_klp_soal_pg)->count();
        $jumlahSoalEssay = SoalEssayModel::where("kelompok_soal","=",$data->id_klp_soal_essay)->count();
        return view('mulaiujian.create')->with(compact('data','jumlahPeserta','Peserta','jumlahSoalPg','jumlahSoalEssay'));
        // dd('x');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function updateDurasiUjian (Request $request){
        $jadwalUpdate['durasi_ujian'] = $request->durasi; 
        $pesertaUpdate['durasi'] = $request->durasi; 
        JadwalModel::find($request->idJadwal)->update($jadwalUpdate);

        $getIdKelompok = JadwalModel::find($request->idJadwal)->first();
        Peserta::where("id_kelompok","=",$getIdKelompok->id_klp_peserta)->update($pesertaUpdate);
        
        return "Sukses";
    }

    
}
