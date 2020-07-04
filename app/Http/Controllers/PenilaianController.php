<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JadwalInstruktur;
use App\InstrukturModel;
use App\JadwalModel;
use App\Peserta;
use Carbon\Carbon;
use App\SoalPgModel;
use App\SoalEssayModel;
use App\JawabanPeserta;
use App\JawabanEssayPeserta;
use Illuminate\Support\Facades\Auth;

class PenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_user = Auth::id();
        $getIdInstruktur = InstrukturModel::where("id_users","=",$id_user)->first();
        $data = JadwalInstruktur::where('id_instruktur','=',$getIdInstruktur->id)->orderBy("id_jadwal","asc")->get();
        $jumlahjadwal = JadwalInstruktur::where('id_instruktur','=',$getIdInstruktur->id)->count();
        return view('penilaian.index')->with(compact('data','jumlahjadwal'));
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
        return view('penilaian.create')->with(compact('data','jumlahPeserta','Peserta','jumlahSoalPg','jumlahSoalEssay'));

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
        $x = "jumlah_jawaban_".$id;
        for ($i=1; $i<=$request->$x ; $i++) { 
            $y = $id."_id_jawaban_".$i;
            $idjawaban = $request->$y;
            $y = $id."_bobot_".$i;
            $bobot = $request->$y;
            $y = $id."_istrue_".$i;
            $istrue = $request->$y;
  
            if($istrue=="on"){
                $istrue = 1;
            }else{
                $istrue = 0;
            }
        
            $nilai['is_true'] = $istrue;
            $nilai['nilai'] = $bobot;
            JawabanEssayPeserta::find($idjawaban)->update($nilai);
        }
        return redirect()->back()->with('message', 'Berhasil!'); 
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
}
