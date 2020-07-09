<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JadwalModel;
use App\Peserta;
use Carbon\Carbon;
use App\SoalPgModel;
use App\Imports\SoalPgImport;
use App\SoalEssayModel;
use App\Imports\SoalEssayImport;
use App\JadwalInstruktur;
use App\InstrukturModel;
use App\JadwalModul;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

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
        $id_jadwal = $id;
        $getIdInstruktur = InstrukturModel::where("id_users",Auth::id())->first();
        $data = JadwalModul::where('id_jadwal',$id)->orderBy("id_modul","asc")->get();
        return view('instruktur.modul')->with(compact('data','id_jadwal'));
    }

    // function view upload modul dan link 
    public function store_modul(Request $request){
        // return $request->all();
        // $instruktur = InstrukturModel::where("id_users",Auth::id())->first();
        $jadwal = JadwalModel::find($request->id_jadwal);
        $px_materi = "materi_";
        $px_link = "link_";
        $anggota = [];
        $anggota_msg = [];
        // return $instruktur->jadwal_r->jadwal_modul_r;
        foreach ($jadwal->jadwal_modul_r as $key) {
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

        foreach ($jadwal->jadwal_modul_r as $key) {
            if($request->has($px_link.$key->id)){
                $val_mtr = explode("_", $request->input($px_materi.$key->id));
                $val_link = explode("_", $request->input($px_link.$key->id));
                // handle upload Premi bpjs kesehatan
                $data = JadwalModul::find($key->id);
                if ($files = $request->file($px_materi.$key->id)) {
                    $destinationPath = 'uploads/materi/'.$jadwal->id; // upload path
                    $file = "materi_".Carbon::now()->timestamp. "." . $files->getClientOriginalExtension();
                    $files->move($destinationPath, $file);
                    $data->materi= $jadwal->id."/".$file;
                }
                $data->link = $request->input($px_link.$key->id);
                $data->save();
                //  JadwalModul::find($key->id)->update([
                //     'link' => $request->input($px_link.$key->id),
                //     'materi' => $file,
                // ]);
            }
        }
        return response()->json([
            'id_jadwal' => $request->id_jadwal,
            'status' => true,
            'message' => 'Materi berhasil di upload',
        ],200);
       
    }

    public function uploadtugas(Request $request, $id)
    {

        $request->validate([
            'BatasUpload'=>'required',
            'uploadTugas' => 'required',
            'uploadTugas'=>'mimes:pdf'
        ],
        ['uploadTugas.required'=>'Kolom upload tugas harus diisi',
        'uploadTugas.mimes'=>'File harus berupa pdf',
        'BatasUpload.required' => 'Kolom batas upload harus diisi'
        ]
        );

        if ($files = $request->file('uploadTugas')) {
            $destinationPath = 'uploads/Tugas'; // upload path
            $file = "Tugas_Jadwal_".$id."_".Carbon::now()->timestamp. "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file);
            $data['pdf_tugas'] = $destinationPath."/".$file;
        }
        $data['batas_up_tugas'] = Carbon::createFromFormat('d/m/Y',$request->BatasUpload);
        JadwalModel::find($id)->update($data);
        return redirect()->back()->with('message', 'Berhasil Upload Tugas!'); 
    }

    public function uploadsoal(Request $request, $id)
    {

        $request->validate([
            'soalPg' => 'required',
            'soalPg'=>'mimes:xls,xlsx',
            'soalEssay' => 'required',
            'soalEssay'=>'mimes:xls,xlsx'
        ],
        ['soalPg.required'=>'Kolom upload soal PG harus diisi',
        'soalPg.mimes'=>'File harus berupa excel',
        'soalEssay.required'=>'Kolom upload soal essay harus diisi',
        'soalEssay.mimes'=>'File harus berupa excel'
        ]
        );

        if($request->hasFile('soalPg')){
            $user_data = [
                'deleted_by' => Auth::id(),
                'deleted_at' => Carbon::now()->toDateTimeString()
            ];
            SoalPgModel::where('kelompok_soal', $id)->update($user_data);
            // menangkap file excel
            $file2 = $request->file('soalPg');
            // membuat nama file unik
            $nama_file2 = "Soal_PG_".$id."_".Carbon::now()->timestamp."_".$file2->getClientOriginalName();
            // upload ke folder file_siswa di dalam folder public
            $file2->move('uploads/Soal',$nama_file2);
            // import data
            Excel::import(new SoalPgImport($id), public_path('uploads/Soal/'.$nama_file2));   
            $data['f_soal_pg'] = "/uploads/Soal/".$nama_file2 ;
            JadwalModel::find($id)->update($data); 
        }

        if($request->hasFile('soalEssay')){
            $user_data = [
                'deleted_by' => Auth::id(),
                'deleted_at' => Carbon::now()->toDateTimeString()
            ];
            SoalEssayModel::where('kelompok_soal', $id)->update($user_data);
            // menangkap file excel
            $file2 = $request->file('soalEssay');
            // membuat nama file unik
            $nama_file2 = "Soal_Essay_".$id."_".Carbon::now()->timestamp."_".$file2->getClientOriginalName();
            // upload ke folder file_siswa di dalam folder public
            $file2->move('uploads/Soal',$nama_file2);
            // import data
            Excel::import(new SoalEssayImport($id), public_path('uploads/Soal/'.$nama_file2)); 
            $data['f_soal_essay'] = "/uploads/Soal/".$nama_file2 ;
            JadwalModel::find($id)->update($data);   
        }
        // $simpan = JadwalModel::find($id)->update($data);
        return redirect()->back()->with('message', 'Berhasil Upload Soal!'); 
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

    public function cekDurasiUjian (Request $request){

        $data['waktusekarang'] = Carbon::now()->toDateTimeString();
        $x = JadwalModel::select('akhir_ujian','mulai_ujian')->where('id','=',$request->idJadwal)->first();
        $data['akhir_ujian'] = $x['akhir_ujian'];
        $data['mulai_ujian'] = $x['mulai_ujian'];
        return $data;
    }
}
