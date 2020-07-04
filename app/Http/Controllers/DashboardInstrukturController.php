<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JadwalModel;
use App\Peserta;
use Carbon\Carbon;
use App\SoalPgModel;
use App\SoalEssayModel;
use App\JadwalInstruktur;
use App\InstrukturModel;
use App\JadwalModul;
use Illuminate\Support\Facades\Auth;

class DashboardInstrukturController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return view('homeInstruktur');
        $id_user = Auth::id();
        $getIdInstruktur = InstrukturModel::where("id_users","=",$id_user)->first();
        $data = JadwalInstruktur::where('id_instruktur','=',$getIdInstruktur->id)->orderBy("id_jadwal","asc")->get();
        $jumlahjadwal = JadwalInstruktur::where('id_instruktur','=',$getIdInstruktur->id)->count();
        return view('homeInstruktur')->with(compact('data','jumlahjadwal'));
    }

    // function view upload modul dan link 
    public function modul($id){
        $getIdInstruktur = InstrukturModel::where("id_users",Auth::id())->first();
        $data = JadwalModul::where('id_jadwal',$id)->orderBy("id_modul","asc")->get();
        return view('instruktur.modul')->with(compact('data'));
    }

    // function view upload modul dan link 
    public function store_modul(Request $request){
        $instruktur = InstrukturModel::where("id_users",Auth::id())->first();
        $px_materi = "materi_";
        $px_link = "link_";
        $anggota = [];
        $anggota_msg = [];
        // return $instruktur->jadwal_r->jadwal_modul_r;
        foreach ($instruktur->jadwal_r->jadwal_modul_r as $key) {
            if ($request->has($px_materi.$key->id)) {
                $anggota += [
                    $px_materi.$key->id => 'mimes:pdf,docx,xls,xlsx|max:5120',
                    // $px_link.$i => 'required',
                ];
                $anggota_msg += [
                    $px_materi.$key->id.".mimes" => 'Upload Hanya format PDF,XLS,DOCX!',
                    $px_materi.$key->id.".max" => 'Maksimal File harus 5MB',
                ];
            }
        }
       $request->validate($anggota, $anggota_msg); 

        foreach ($instruktur->jadwal_r->jadwal_modul_r as $key) {
            if($request->has($px_link.$key->id)){
                $val_mtr = explode("_", $request->input($px_materi.$key->id));
                $val_link = explode("_", $request->input($px_link.$key->id));
                // handle upload Premi bpjs kesehatan
                $data = JadwalModul::find($key->id);
                if ($files = $request->file($px_materi.$key->id)) {
                    $destinationPath = 'uploads/materi/'.$instruktur->jadwal_r->id; // upload path
                    $file = "materi_".Carbon::now()->timestamp. "." . $files->getClientOriginalExtension();
                    $files->move($destinationPath, $file);
                    $data->materi= $instruktur->jadwal_r->id."/".$file;
                }
                $data->link = $request->input($px_link.$key->id);
                $data->save();
                //  JadwalModul::find($key->id)->update([
                //     'link' => $request->input($px_link.$key->id),
                //     'materi' => $file,
                // ]);
            }
        }
       
    }

    public function uploadtugas(Request $request, $id)
    {
        if ($files = $request->file('uploadTugas')) {
            $destinationPath = 'uploads/Tugas'; // upload path
            $file = "Tugas_Jadwal_".$id."_".Carbon::now()->timestamp. "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file);
            $data['pdf_tugas'] = $destinationPath."/".$file;
        }
        $simpan = JadwalModel::find($id)->update($data);
        return redirect()->back()->with('message', 'Berhasil Upload Tugas!'); 
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

        $jadwalUpdate['mulai_ujian'] = Carbon::now()->toDateTimeString();
        $jadwalUpdate['akhir_ujian'] = Carbon::now()->addMinutes($request->durasi)->toDateTimeString();
        $jadwalUpdate['durasi_ujian'] = $request->durasi; 
        $pesertaUpdate['durasi'] = $request->durasi; 
        JadwalModel::find($request->idJadwal)->update($jadwalUpdate);

        $getIdKelompok = JadwalModel::find($request->idJadwal)->first();
        Peserta::where("id_kelompok","=",$getIdKelompok->id_klp_peserta)->update($pesertaUpdate);
        
        return $jadwalUpdate['akhir_ujian'];
    }

    
}
