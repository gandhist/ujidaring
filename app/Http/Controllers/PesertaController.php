<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SoalPgModel;
use App\Peserta;
use App\JadwalModel;
use App\JadwalModul;
use App\JawabanEvaluasi;
use App\EvaluasiSoal;
use App\JawabanPeserta;
use App\JawabanTugas;
use App\JawabanEssayPeserta;
use App\AbsenModel;
use App\JawabanPkl;
use App\JawabanPpt;
use App\JadwalRundown;
use App\KirimWa;
use App\ModulRundown;
use App\MasterModul;
use App\KelompokPeserta;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use App\Traits\GlobalFunction;

class PesertaController extends Controller
{
    use GlobalFunction;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // generate soal pre quis
        $is_pre_quis = $this->_is_pre_quis(); // buat soal pre jika ada
        $is_post_quis = $this->_is_post_quis();
        $peserta = Peserta::where('user_id',Auth::id())->first();
        $cek = JawabanEvaluasi::where('id_peserta',$peserta->id)->where('id_jadwal',$peserta->jadwal_r->id)->count();
        if($cek == 0){
           $this->_generate_soal_eva($peserta->id);
        }
        $awal_uji = strtotime($peserta->jadwal_r->mulai_ujian);
        $akhir_uji = strtotime($peserta->jadwal_r->akhir_ujian);
        $pst_mulai_uji = $peserta->mulai_ujian ? strtotime($peserta->mulai_ujian) : Carbon::now()->timestamp;
        if($pst_mulai_uji >= $awal_uji && Carbon::now()->timestamp <= $akhir_uji){
            $durasi = $peserta->jadwal_r->durasi_ujian - (($pst_mulai_uji - $awal_uji) / 60);
            $peserta->durasi = $durasi;
            $peserta->save();
            $is_allow = true;
        }
        else {
            $is_allow = false;
        }
        $is_allow_uji = $is_allow;
        $is_allow_tugas = $this->_check_allow_tugas();
        $is_absen = $this->is_allow_masuk();
        $rd = JadwalRundown::where('id_jadwal',$peserta->jadwal_r->id)->get();
        $is_pre_today = $this->is_pre_today();
        $is_post_today = $this->is_post_today();
        $is_ketua = false;
        $anggota_klp = "";
        if($peserta->kelompok){
            if($peserta->kelompok->id_ketua == $peserta->id)
            $is_ketua = true;
            $anggota_klp = KelompokPeserta::where('no_kelompok',$peserta->kelompok->no_kelompok)->where('id_jadwal',$peserta->jadwal_r->id)->get();
        }
        if($is_absen){
            \LogActivity::addToLog('peserta ditolak kedashboard karena belum login');
            return redirect('peserta/presensi')->with('status', 'Anda harus absen, untuk bisa mengakses halaman dashboard');
        }
        else {
            // \LogActivity::addToLog('peserta ke menu dashboard');
            return view('peserta.dashboard')->with(compact('peserta','is_allow_uji','is_allow_tugas','rd','is_pre_quis','is_pre_today','is_ketua','anggota_klp'));
        }
    }

    // view tugas
    public function tugas(){
        $peserta = Peserta::where('user_id',Auth::id())->first();
        \LogActivity::addToLog("peserta membuka halaman tugas");
        return view('peserta.tugas')->with(compact('peserta'));
    }

    // simpan tugas
    public function tugas_store(Request $request){
        $request->validate(
        [
            'tugas' => 'required|mimes:pdf|max:5120'
        ],[
            'tugas.required' => "PDF Tugas Harus di isi",
            'tugas.mimes' => "Upload hanya format PDF",
            'tugas.max' => "Maksimal ukuran file 5MB"
        ]);
        $peserta = Peserta::where('user_id',Auth::id())->first();
        // handle upload tugas
        if ($files = $request->file('tugas')) {
            $destinationPath = 'uploads/tugas/peserta'; // upload path
            $file = Auth::id()."_tugas_".Carbon::now()->timestamp. "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file);
            $pdf_tugas = $file;
        }
        JawabanTugas::updateOrCreate([
            'id_jadwal' => $peserta->jadwal_r->id,
            'id_peserta' => $peserta->id
        ],[
            'tgl_upload' => Carbon::now()->isoFormat('YYYY-MM-DD'),
            'created_at' => Carbon::now()->toDateTimeString(),
            'created_by' => Auth::id(),
            'pdf_tugas' => $pdf_tugas
        ]);
        \LogActivity::addToLog("peserta mengirim/upload tugas");
        return response()->json([
            'status' => true,
            'message' => 'Berhasil Mengirim Tugas'
        ],200);
    }

    // view kuisioner
    public function kuisioner(){
        $peserta = Peserta::where('user_id',Auth::id())->first();
        $cek = JawabanEvaluasi::where('id_peserta',$peserta->id)->where('id_jadwal',$peserta->jadwal_r->id)->count();
        if($cek == 0){
           $this->_generate_soal_eva($peserta->id);
        }

        $rd = JadwalRundown::where('id_jadwal',$peserta->jadwal_r->id)->where('tanggal',Carbon::now()->isoFormat('YYYY-MM-DD'))->first();
        \LogActivity::addToLog("peserta membuka halaman pengisian kuisioner/evaluasi pada ". Carbon::now()->toDateTimeString());
        return view('peserta.kuisioner')->with(compact('peserta','rd'));
    }

    // save jawaban kuisioner
    public function kuisioner_store(Request $request){
        // return $request->all();
        $peserta = Peserta::where('user_id',Auth::id())->first();
        $px = "nilai_";
        $data =[];
        // for ($i=1; $i <= $request->total ; $i++) { 
            foreach ($peserta->jawaban_eva_r as $key) {
                if($request->has($px.$key->id)){
                    $val_exp = explode("#", $request->input($px.$key->id));
                    JawabanEvaluasi::updateOrCreate([
                        'id' => $val_exp[0],
                    ],[
                        'nilai' => $val_exp[1],
                    ]);
                }
            }
        // }
        // foreach ($peserta->jawaban_eva_r as $key) {
        //     if($request->has($px.$key->id)){
        //         $val_exp = explode("#", $request->input($px.$key->id));
        //         JawabanEvaluasi::updateOrCreate([
        //              'id_jadwal' => $request->id_jadwal,
        //              'tanggal' => Carbon::now()->isoFormat('YYYY-MM-DD'),
        //              'id_peserta' => $peserta->id,
        //              'id' => $val_exp[0],
        //              'id_instruktur' => $request->id_instruktur
        //          ],[
        //              'nilai' => $val_exp[1],
        //              'id_instruktur' => $request->id_instruktur,
        //          ]);
        //     }
        // }

        \LogActivity::addToLog("peserta mengisi kuisioner/evaluasi pada ". Carbon::now()->toDateTimeString());
        return response()->json([
            'status' => true,
            'message' => 'Berhasil memberikan evaluasi, Penilaian anda di jamin kerahasiaannya',
        ],200);
    }

    // view absen
    public function absen(){
        $peserta = Peserta::where('user_id',Auth::id())->first();
        $allow_tugas = $this->is_make_eva($peserta->id);
        $allow_cekin = $this->is_allow_masuk();
        $allow_cekout = $this->is_allow_pulang();
        $data = AbsenModel::where('id_peserta',$peserta->id)->get();
        \LogActivity::addToLog("peserta membuka halaman absensi ");
        return view('peserta.absen')->with(compact('data','allow_cekout','allow_cekin','allow_tugas'));
    }

    // absen masuk
    public function datang(Request $request){
        $folderPath = "uploads/peserta/";
        $image_parts = explode(";base64,", $request->image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = Auth::id()."_".Carbon::now()->timestamp . '.png';
        $file = $folderPath . $fileName;
        $masuk = new AbsenModel;
        $masuk->id_peserta = Peserta::where('user_id',Auth::id())->first()->id;
        $masuk->jam_cek_in = Carbon::now()->toDateTimeString();
        $masuk->created_by = Auth::id();
        $masuk->created_at = Carbon::now()->toDateTimeString();
        $masuk->tanggal = Carbon::now()->isoFormat("YYYY-MM-DD");
        $masuk->foto_cek_in = $fileName;
        $masuk->save();
        file_put_contents($file, $image_base64);
        \LogActivity::addToLog("peserta melakukan absen masuk pada ". Carbon::now()->toDateTimeString());
    
        return response()->json([
            'status' => true,
            'message' => 'Berhasil Absen',
        ]);
    }

    // absen keluar
    public function pulang(Request $request){
        $folderPath = "uploads/peserta/";
        $image_parts = explode(";base64,", $request->image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = Auth::id()."_".Carbon::now()->timestamp . '.png';
        $file = $folderPath . $fileName;
        $masuk = AbsenModel::where('id_peserta',Peserta::where('user_id',Auth::id())->first()->id)->orderBy('id','desc')->first();
        $masuk->id_peserta = Peserta::where('user_id',Auth::id())->first()->id;
        $masuk->jam_cekout = Carbon::now()->toDateTimeString();
        $masuk->updated_by = Auth::id();
        $masuk->updated_at = Carbon::now()->toDateTimeString();
        // $masuk->tanggal = Carbon::now()->isoFormat("YYYY-MM-DD");
        $masuk->foto_cekout = $fileName;
        $masuk->save();
        file_put_contents($file, $image_base64);
        \LogActivity::addToLog("peserta melakukan absen pulang pada ". Carbon::now()->toDateTimeString());
        return response()->json([
            'status' => true,
            'message' => 'Berhasil Absen',
        ]);
    }


    // function menampilkan form ujian online
    public function ujian_pg(Request $request){
        if($this->_check_allow_ujian() == false){
            return redirect('peserta/dashboard')->with('status', 'Waktu ujian telah habis');
        }
        $peserta = Peserta::where('user_id',Auth::id())->first();
        if($peserta->durasi == null && $peserta->mulai_ujian == null){
            $peserta->mulai_ujian = Carbon::now()->toDateTimeString();
            $peserta->durasi = $peserta->jadwal_r->durasi_ujian;
            $peserta->save();
        }
        $cek = JawabanPeserta::where('id_peserta',$peserta->id)->where('id_jadwal',$peserta->jadwal_r->id)->first();
        if(!$cek){
            $this->_generate_soal($peserta->id);
        }
        $pg = JawabanPeserta::where('id_peserta',$peserta->id)->where('id_jadwal',$peserta->jadwal_r->id)->paginate(10);
        $soal_essay = JawabanEssayPeserta::where('id_peserta',$peserta->id)->where('id_jadwal',$peserta->jadwal_r->id)->orderBy('id_soal','asc')->get();
        if($request->ajax()){
            return view('quis.pre.soal',[
                'pg' => $pg,
                'modul_today' => $peserta->jadwal_r,
            ])->render();
        }
        $modul_today = $peserta->jadwal_r;
        \LogActivity::addToLog("peserta membuka halaman ujian pilihan ganda");
        return view('ujian.pg')->with(compact('peserta','pg','soal_essay','modul_today'));
    }

    // function save pilihan ke table temp
    public function pg_save(Request $request){
        // return $request->all();
        if(!$request->has('jawaban')){
            return response()->json([
                'status' => false,
                'message' => 'Anda belum mengisi jawaban'
            ],200);
        }
        // return $this->cek_jawaban(2, "c");
        $peserta = Peserta::where('user_id',Auth::id())->first();
        $data=[];
        foreach($request->jawaban as $key => $value){
            
            $val_exp = explode("#", $value);
            JawabanPeserta::updateOrCreate([
                'id_jadwal' => $request->id_jadwal,
                'id_peserta' => $peserta->id,
                'id_soal' => $val_exp[0],
            ],[
                'jawaban' => $val_exp[1],
                'is_true' => $this->cek_jawaban($val_exp[0], $val_exp[1])
            ]);
            // $dt_jw->save();
        }
        $benar = JawabanPeserta::where('id_jadwal',$request->id_jadwal)
        ->where('id_peserta',$peserta->id)
        // ->where('id_soal',$val_exp[0])
        ->where('is_true',1)->count();
        // return $benar;
        \LogActivity::addToLog("peserta menyimpan semua jawaban pilihan ganda");
        return response()->json([
            'status' => true,
            'message' => 'Jawaban Anda Berhasil Disimpan'
        ],200);
    }

    // function save parsial
    public function pg_save_parsial(Request $request){
        $val_exp = explode("#", $request->jawaban);
        $peserta = Peserta::where('user_id',Auth::id())->first();
        JawabanPeserta::updateOrCreate([
            'id_jadwal' => $request->id_jadwal,
            'id_peserta' => $peserta->id,
            'id_soal' => $val_exp[0],
        ],[
            'jawaban' => $val_exp[1],
            'is_true' => $this->cek_jawaban($val_exp[0], $val_exp[1])
        ]);
        return response()->json([
            'status' => true
        ],200);
    }

    // save all essay
    public function es_save(Request $request){
        // belum bisa save. karena belum bisa dapet id_soal dari form
        return $request->all();
        $peserta = Peserta::where('user_id',Auth::id())->first();
        $px = "essay_";
       for($i=1; $i<= 10; $i++){
           if($request->has($px.$i)){
            //    echo  $request->input($px.$i)."<br>";
                JawabanEssayPeserta::updateOrCreate([
                    'id_jadwal' => $request->id_jadwal,
                    'id_peserta' => $peserta->id,
                    'id_soal' => $request->input($px.$i),
                ],[
                    'jawaban' => $request->input($px.$i)
                ]);
           }
       }
    }

    // function save parsial essay
    public function es_save_parsial(Request $request){
        $val_exp = explode("_", $request->id_soal);
        $peserta = Peserta::where('user_id',Auth::id())->first();
        // return $peserta->id.$request->id_jadwal.$val_exp[1];
        JawabanEssayPeserta::updateOrCreate([
            'id_jadwal' => $request->id_jadwal,
            'id_peserta' => $peserta->id,
            'id_soal' => $val_exp[1],
        ],[
            'jawaban' => $request->jawaban
        ]);
        return response()->json([
            'status' => true
        ],200);
    }

    public function cek_jawaban($id_soal, $jwb_peserta){
        $data = SoalPgModel::find($id_soal);
        if ($data->jawaban == $jwb_peserta) {
            $jwb = 1;
        }
        else {
            $jwb = 0;
        }
        return $jwb;
    }

    // function menampilkan form upload makalah
    public function makalah(){
        $peserta = Peserta::where('user_id',Auth::id())->first();
        \LogActivity::addToLog("peserta membuka halaman makalah PKL");
        return view('peserta.makalah')->with(compact('peserta'));
    }

    // simpan makalah
    public function makalah_store(Request $request){
        $request->validate(
        [
            'pdf_makalah' => 'required|mimes:pdf|max:5120'
        ],[
            'pdf_makalah.required' => "PDF Tugas Harus di isi",
            'pdf_makalah.mimes' => "Upload hanya format PDF",
            'pdf_makalah.max' => "Maksimal ukuran file 5MB"
        ]);
        $peserta = Peserta::where('user_id',Auth::id())->first();
        // handle upload tugas
        if ($files = $request->file('pdf_makalah')) {
            $destinationPath = 'uploads/makalah/peserta'; // upload path
            $file = Auth::id()."_makalah_".Carbon::now()->timestamp. "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file);
            $pdf_tugas = $file;
        }
        JawabanPkl::updateOrCreate([
            'id_jadwal' => $peserta->jadwal_r->id,
            'id_peserta' => $peserta->id
        ],[
            'tgl_upload' => Carbon::now()->isoFormat('YYYY-MM-DD'),
            'created_at' => Carbon::now()->toDateTimeString(),
            'created_by' => Auth::id(),
            'pdf_makalah' => $pdf_tugas
        ]);
        \LogActivity::addToLog("peserta menyimpan/upload makalah PKL");
        return response()->json([
            'status' => true,
            'message' => 'Berhasil Mengirim Makalah'
        ],200);
    }

    // function menampilkan form upload presentasi
    public function presentasi(){
        $peserta = Peserta::where('user_id',Auth::id())->first();
        \LogActivity::addToLog("peserta membuka halaman upload Presentasi");
        return view('peserta.presentasi')->with(compact('peserta'));
    }

    // simpan presentasi
    public function presentasi_store(Request $request){
        $request->validate(
        [
            'f_ppt' => 'required|mimes:pptx,ppt|max:5120'
        ],[
            'f_ppt.required' => "PDF Tugas Harus di isi",
            'f_ppt.mimes' => "Upload hanya format PPT",
            'f_ppt.max' => "Maksimal ukuran file 5MB"
        ]);
        $peserta = Peserta::where('user_id',Auth::id())->first();
        // handle upload tugas
        if ($files = $request->file('f_ppt')) {
            $destinationPath = 'uploads/ppt/peserta'; // upload path
            $file = Auth::id()."_makalah_".Carbon::now()->timestamp. "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file);
            $pdf_tugas = $file;
        }
        JawabanPpt::updateOrCreate([
            'id_jadwal' => $peserta->jadwal_r->id,
            'id_peserta' => $peserta->id
        ],[
            'tgl_upload' => Carbon::now()->isoFormat('YYYY-MM-DD'),
            'created_at' => Carbon::now()->toDateTimeString(),
            'created_by' => Auth::id(),
            'f_ppt' => $pdf_tugas
        ]);
        \LogActivity::addToLog("peserta menyimpan/upload Presentasi");

        return response()->json([
            'status' => true,
            'message' => 'Berhasil Mengirim Presentasi'
        ],200);
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
        //
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

    public function bukaMateri($id){
        
        $file_materi = ModulRundown::find($id);
        // $file_materi = JadwalModul::find($id);
        $url = url($file_materi->jadwal_modul_r->materi);
        $nm_materi = $file_materi->jadwal_modul_r->modul_r->modul;
        \LogActivity::addToLog("peserta membuka materi Instruktur # $nm_materi ");
        return view('pdfviewer')->with(compact('url')); // pdf cant download
        return redirect($url);

    }

    public function bukaMateriModul($id){
        
        

        $file_materi = MasterModul::find($id);
        // $file_materi = JadwalModul::find($id);
        $url = url($file_materi->materi);
        $nm_materi = $file_materi->modul;
        \LogActivity::addToLog("peserta membuka materi Modul # $nm_materi ");
        return view('pdfviewer')->with(compact('url')); // pdf cant download
        return redirect($url);

    }

    public function kirimSMS(){
        $telepon = '081240353913';
        // Gunakan NIK Anda dan kode: 9777 untuk login ke env('APP_URL')
        $message = "Gunakan NIK Anda dan password: untuk login ke ";
        return $this->kirimPesanSMS($telepon, $message);
    }

    public function tombolWa(){
        $url = url('wa');
        $pesan = "";
        // $pesan = session()->all();
        $data = '    
        <a href="'.$url.'" >hajar</a>
        ';
        print_r(session()->all());
        return $data;
    }

    public function kirimWA(){
        // $now = Carbon::parse("2020-07-21 22:00:00");
        // $now = Carbon::now();
        
        // echo Carbon::now()->isoFormat('YYYY-MM-DD HH:mm:s');
        // echo "<br>";
        // $data = KirimWa::where('is_sent',0)->get();
        // $data = KirimWa::all();
        // foreach($data as $key){
            
        //     $now->addSeconds(5)->isoFormat('YYYY-MM-DD HH:mm:s');
        //     KirimWa::find($key->id)->update([
        //         'waktu_kirim' => $now,
        //     ]);
             
        // }
        // return "buat waktu";
        $telepon = '081240353913';
        // return $data;

        $message = '
        Salam Hormat,

Bapak/ Ibu/ Sdr/ Sdri bersama ini kami  sampaikan dari *Perkumpulan Pemangku Kepentingan Keselamatan dan Kesehatan Kerja (PPK-K3)* bahwa tidak ada waktu yang lebih tepat dibanding saat ini dimana kondisi sektor konstruksi sedang mendapat ujian terberat melalui adanya Pandemi COVID-19 dimana harus kita secara bersama menyikapi dengan salah satunya melalui *"Peningkatan Kompetensi Tenaga Kerja Konstruksi seiring dengan Pelaksanaan Kebiasaan Baru di Indonesia"*.

Untuk itu, kami kembali mengingatkan bahwa webinar terkait pembahasan tema di atas akan diselenggarakan pada *Sabtu, 25 Juli 2020 (09:00 - 12:30 WIB)*.

Link Pendaftaran dapat melalui:

bit.ly/webinarkebiasaanbaru


informasi lebih lanjut dapat menghubungi 0812-9448-1238

Terima Kasih
        ';
        // $message = "test test test";
        // informasi lebih lanjut dapat menghubungi 0812-9448-1238
        //081294481238
        // $wa =  $this->kirimPesanWA($telepon, $message);
        // return $wa;

        $data = KirimWa::where('is_sent',0)->first();
        $wa =  $this->kirimPesanWA($data->no, $message);
        // print_r($wa);
        KirimWa::find($data->id)->update([
            'is_sent' => $wa['status'],
            'messageId' => $wa['messageId'],
            'text' => $wa['text'],
        ]);
        return redirect('tombolWa')->with('message',$wa['text']);

        foreach($data as $key){
            if( strtotime(Carbon::parse($key->waktu_kirim)->isoFormat('YYYY-MM-DD HH:mm:s')) <= strtotime(Carbon::now()->isoFormat('YYYY-MM-DD HH:mm:s')) ){
                echo 'here'. $key->no."<br>";
                $wa =  $this->kirimPesanWA($key->no, $message);
                print_r($wa);
                KirimWa::find($key->id)->update([
                    'is_sent' => $wa['status'],
                    'messageId' => $wa['messageId'],
                    'text' => $wa['text'],
                ]);
            }
            
        }
        return 'ok';
$a = false;
        do {
            $data = KirimWa::where('is_sent',0)->get();
            
        } while ($a);
        
        return $wa;
        // return 'pesan terkirim semua';

    }

    // function generate soal peserta ke table jawaban_peserta
    public function _generate_soal($id){
        $peserta = Peserta::find($id);
        // return $peserta->jadwal_r->soalpg_r;
        // loop to save table jawaban peserta
        $no = 1;
        foreach ($peserta->jadwal_r->soalpg_r->shuffle() as $key) {
            $jwb_soal = new JawabanPeserta;
            $jwb_soal->id_jadwal = $peserta->jadwal_r->id;
            $jwb_soal->id_soal = $key->id;
            $jwb_soal->id_peserta = $id;
            $jwb_soal->no_soal = $no;
            $jwb_soal->created_by = Auth::id();
            $jwb_soal->created_at = Carbon::now()->toDateTimeString();
            $jwb_soal->save();
            $no++;
        }
        // loop to save table jawaban essay peserta
        foreach ($peserta->jadwal_r->soales_r->shuffle() as $key) {
            $jwb_soal = new JawabanEssayPeserta;
            $jwb_soal->id_jadwal = $peserta->jadwal_r->id;
            $jwb_soal->id_soal = $key->id;
            $jwb_soal->id_peserta = $id;
            $jwb_soal->created_by = Auth::id();
            $jwb_soal->created_at = Carbon::now()->toDateTimeString();
            $jwb_soal->save();
        }
    }

    // function generate evaluasi peserta ke table jawaban evaluasi
    public function _generate_soal_eva($id){
        $peserta = Peserta::find($id);
        $period = CarbonPeriod::create( Carbon::parse($peserta->jadwal_r->tgl_awal), Carbon::parse($peserta->jadwal_r->tgl_akhir));
        $data = EvaluasiSoal::all();
        $jml_ins = JadwalRundown::where('id_jadwal',$peserta->jadwal_r->id)->get();
        // looping tanggal jadawl
        foreach($jml_ins as $key){
            foreach($key->ins_rundown_r as $ins){
                foreach($data as $eva){
                    $jwb = new JawabanEvaluasi;
                    $jwb->id_evaluasi = $eva->id;
                    $jwb->id_jadwal = $peserta->jadwal_r->id;
                    $jwb->id_peserta = $peserta->id;
                    $jwb->id_instruktur = $ins->jadwal_instruktur_r->instruktur_r->id;
                    $jwb->tanggal = $key->tanggal;
                    $jwb->save();
                }
                // echo $ins->jadwal_instruktur_r->instruktur_r->id."<br>"; // id instruktur
                // echo $key->tanggal."<br>";
            }
        }

        // foreach ($period as $key => $date) {
        //     foreach($data as $key){
        //         $jwb = new JawabanEvaluasi;
        //         $jwb->id_evaluasi = $key->id;
        //         $jwb->id_jadwal = $peserta->jadwal_r->id;
        //         $jwb->id_peserta = $peserta->id;
        //         $jwb->tanggal = $date->format('Y-m-d');
        //         $jwb->save();
        //     }
        // }
        
    }

    // function cek in time ujian / tidak
    public function _check_allow_ujian(){
        $peserta = Peserta::where('user_id',Auth::id())->first();
        $awal_uji = strtotime($peserta->jadwal_r->mulai_ujian);
        $akhir_uji = strtotime($peserta->jadwal_r->akhir_ujian);
        // $pst_mulai_uji = strtotime($peserta->mulai_ujian);
        $pst_mulai_uji = $peserta->mulai_ujian ? strtotime($peserta->mulai_ujian) : Carbon::now()->timestamp;
        if($pst_mulai_uji >= $awal_uji && $pst_mulai_uji <= $akhir_uji){
            $durasi = $peserta->jadwal_r->durasi_ujian - (($pst_mulai_uji - $awal_uji) / 60);
            $peserta->durasi = $durasi;
            $peserta->save();
            $is_allow = true;
        }
        else {
            $is_allow = false;
        }
        return $is_allow;
    }

    // function check today peserta already submit evaluasi before checkout?
    public function is_make_eva($id){
        $peserta = Peserta::find($id);
        $today = Carbon::now()->isoFormat('YYYY-MM-DD');
        $cek_db = JawabanEvaluasi::where('tanggal', $today)->where('id_peserta', $id)->first();
        // return $cek_db;
        if($cek_db){
            if($cek_db->nilai == null){
                $allow_cekout = true;
            }
            else{
                $allow_cekout = false;
            }
        }
        else{
            $allow_cekout = false;
        }
        return $allow_cekout;

    }

    // fuction check allow input tugas 2 day after date end
    public function _check_allow_tugas(){
        $peserta = Peserta::where('user_id',Auth::id())->first();
        // $awal_uji = strtotime($peserta->jadwal_r->mulai_ujian);
        $akhir_uji = strtotime($peserta->jadwal_r->akhir_ujian);
        $akhir_uji = Carbon::parse($akhir_uji)->timestamp;
        $two_after = Carbon::parse($akhir_uji)->addDays(2)->timestamp;
        $now = Carbon::now()->timestamp;
        if($now >= $akhir_uji && $now <= $two_after){
            $is_allow = true;
        }
        else {
            $is_allow = false;
        }
        return $is_allow;
    }

    // function check is allow absen masuk
    public function is_allow_masuk(){
        $peserta = Peserta::where('user_id',Auth::id())->first();
        $cek_cekin = AbsenModel::where('tanggal', Carbon::now()->isoFormat('YYYY-MM-DD'))->where('id_peserta', $peserta->id)->first();
        if($cek_cekin){
            $allow = false;
        }
        else {
            $allow = true;
        }
        return $allow;
    }

    // function check is allow absen pulang
    public function is_allow_pulang(){
        $peserta = Peserta::where('user_id',Auth::id())->first();
        $cek_cekin = AbsenModel::where('tanggal', Carbon::now()->isoFormat('YYYY-MM-DD'))->where('id_peserta', $peserta->id)->whereNotNull('jam_cekout')->first();
        if($cek_cekin){
            $allow = false;
        }
        else {
            $allow = true;
        }
        return $allow;
    }
}
