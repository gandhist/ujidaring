<?php

namespace App\Http\Controllers\Ujidaring\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\Ujidaring\MasterJenisUsaha;
use App\Models\Ujidaring\MasterBidang;
use App\Models\Ujidaring\JadwalModel;
use App\Models\Ujidaring\JadwalModul;
use App\Models\Ujidaring\InstrukturModel;
use App\Models\Ujidaring\JadwalInstruktur;
use App\Models\Ujidaring\JawabanPkl;
use App\Models\Ujidaring\Peserta;
use App\Imports\Ujidaring\PesertaImport;
use App\Imports\Ujidaring\SoalPgImport;
use App\Imports\Ujidaring\SoalEssayImport;
use App\Imports\Ujidaring\SoalPgPreImport;
use App\Imports\Ujidaring\SoalPgPostImport;
use App\Exports\Ujidaring\PesertaQuisExport;
use App\Models\Ujidaring\SoalPgModel;
use App\Models\Ujidaring\SoalEssayModel;
use App\Models\Ujidaring\SoalPgPreModel;
use App\Models\Ujidaring\SoalPgPostModel;
use App\Models\Ujidaring\AbsenModel;
use App\Models\Ujidaring\JadwalRundown;
use App\Models\Ujidaring\InsRundown;
use App\Models\Ujidaring\ModulRundown;
use App\Models\Ujidaring\JawabanEvaluasi;
use App\Models\Ujidaring\JawabanTMPeserta;
use App\Models\Ujidaring\LogActivity;
use App\Models\Ujidaring\JawabanPesertaPgPost;
use App\Models\Ujidaring\JawabanPesertaPgPre;
use App\Models\Ujidaring\PesertaQuis;
use App\Models\Ujidaring\KelompokPeserta;
use App\User;
use Carbon\Carbon;
use App\Traits\Ujidaring\GlobalFunction;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class JadwalController extends Controller
{
    use GlobalFunction;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_user = Auth::id();
        $user_role = User::select('role_id')->where('id','=',$id_user)->first();
        $role =  $user_role['role_id'];
        if($role==1){
            $data = JadwalModel::all();
        }else{
            $getIdInstruktur = InstrukturModel::where("id_users","=",$id_user)->first();
            $datajadwal = JadwalInstruktur::select('id_jadwal')->where('id_instruktur','=',$getIdInstruktur->id)->orderBy("id_jadwal","asc")->get();
            $data = JadwalModel::whereIn('id',$datajadwal)->get();
        }
        return view('ujidaring.jadwal.index')->with(compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bidang = MasterBidang::where('id_jns_usaha','=','1')->get();
        $jenisusaha = MasterJenisUsaha::all();
        return view('ujidaring.jadwal.create')->with(compact('jenisusaha','bidang'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data['tgl_awal'] = Carbon::createFromFormat('d/m/Y',$request->tgl_awal);
        $data['tgl_akhir'] = Carbon::createFromFormat('d/m/Y',$request->tgl_akhir);
        $data['tuk'] = $request->tuk;
        $data['id_jenis_usaha'] = $request->id_jenis_usaha;
        $data['id_bidang'] = $request->id_bidang;
        $data['id_sert_alat'] = $request->id_sert_alat;
        $data['created_by'] = Auth::id();
        $data['created_at'] = Carbon::now()->toDateTimeString();

        // Insert ke table jadwal
        $getIdJadwal = JadwalModel::create($data); 
        $idJadwal = $getIdJadwal->id;

        if($request->hasFile('excel_peserta')){
            // menangkap file excel
            $file = $request->file('excel_peserta');
            // membuat nama file unik
            $nama_file = "Data_Peserta_".Carbon::now()->timestamp."_".$file->getClientOriginalName();
            // upload ke folder file_siswa di dalam folder public
            $file->move('File_Peserta',$nama_file);
            // import data excel ke database
            Excel::import(new PesertaImport, public_path('/File_Peserta/'.$nama_file));

            // Mengambil nilai id_kelompok_peserta
            // $x = Excel::toArray(new PesertaImport, public_path('/File_Peserta/'.$nama_file));
    
            // Search peserta yang id_user = null
            $createAccountPeserta = Peserta::where('user_id', '=', null)->get();
                foreach($createAccountPeserta as  $value) {
                    $id_peserta = $value->id;
                    $dataUser['username'] = $value->nik;
                    $dataUser['name'] = $value->nama;
                    $dataUser['role_id'] = 2;
                    $dataUser['is_active'] = 1;
                    $dataUser['hint'] = str_random(8);
                    $dataUser['password'] = Hash::make($dataUser['hint']);
                    $dataUser['created_by'] = Auth::id();
                    $dataUser['created_at'] = Carbon::now()->toDateTimeString();
                    $getIdUser = User::create($dataUser);
                    $user_id['user_id'] = $getIdUser->id;
                    $user_id['id_kelompok'] = $idJadwal;
    
                    // Update id_user di table peserta
                    Peserta::find($id_peserta)->update($user_id);
                }
            }

                // Insert ke table rowndown
                $from = Carbon::parse(Carbon::createFromFormat('d/m/Y', $request->tgl_awal)->format('Y-m-d'));
                $to = Carbon::parse(Carbon::createFromFormat('d/m/Y', $request->tgl_akhir)->format('Y-m-d'));
                $dates = [];
                
                for($d = $from; $d->lte($to); $d->addDay()) {
                    // Cek hari minggu
                    // $nameofday = strtolower($d->format('l'));
                    // if($nameofday!="sunday"){
                        $data_schedule['id_jadwal'] = $idJadwal;
                        $data_schedule['tanggal'] = $d->format('Y-m-d'); 
                        $data_schedule['created_by'] = Auth::id();
                        $data_schedule['created_at'] = Carbon::now()->toDateTimeString();
                        JadwalRundown::create($data_schedule);

                        $idpesertaall = Peserta::select('id')->where("id_kelompok",$idJadwal)->get()->toArray();
                        foreach ($idpesertaall as $key) {
                            $data_absen['id_peserta'] = $key['id']; 
                            $data_absen['tanggal'] = $d->format('Y-m-d');
                            $data_absen['created_by'] = Auth::id();
                            $data_absen['created_at'] = Carbon::now()->toDateTimeString();
                            AbsenModel::create($data_absen); 
                        }

                    // }
                }

        if ($files = $request->file('gambarJadwal')) {
            $destinationPath = 'uploads/GambarJadwal'; // upload path
            $file = "Pdf_Jadwal_".$idJadwal."_".Carbon::now()->timestamp. "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file);
            $data2['pdf_jadwal'] = $destinationPath."/".$file;
        }

        // Memberi Nilai kelompok soal pg dan kelompok soal essay dan idkelompok peserta pada table jadwal
        $data2['id_klp_peserta'] = $idJadwal;
        $data2['id_klp_soal_pg'] = $idJadwal;
        $data2['id_klp_soal_essay'] = $idJadwal;

        JadwalModel::find($idJadwal)->update($data2); 

        if ($request->id_detail_instruktur!='' )
        {
            $jumlah_detail = explode(',', $request->id_detail_instruktur);
            foreach($jumlah_detail as $jumlah_detail) {
                $x = "nik_instruktur_".$jumlah_detail;
                $dataDetail['nik'] = $request->$x;
                $dataUser['username'] = $request->$x;
                $x = "nama_instruktur_".$jumlah_detail;
                $dataDetail['nama'] = $request->$x;
                $dataUser['name'] = $request->$x;
                $x = "no_hp_instruktur_".$jumlah_detail;
                $dataDetail['no_hp'] = $request->$x;

                $x = "foto_instruktur_".$jumlah_detail;
                // handle upload foto instruktur 
                if ($files = $request->file($x)) {
                    $destinationPath = 'FotoInstruktur'; // upload path
                    $file = "Foto_".$dataDetail['nik']."_".$dataDetail['nama']. "." .$files->getClientOriginalExtension();
                    $files->move($destinationPath, $file);
                    $dataDetail['foto'] = $destinationPath."/".$file;
                 }

                 $x = "pdf_instruktur_".$jumlah_detail;
                // handle upload ktp instruktur 
                if ($files = $request->file($x)) {
                    $destinationPath = 'PdfInstruktur'; // upload path
                    $file = "Pdf_".$dataDetail['nik']."_".$dataDetail['nama']. "." .$files->getClientOriginalExtension();
                    $files->move($destinationPath, $file);
                    $dataDetail['ktp'] = $destinationPath."/".$file;
                 }

                 // Menetukan role instruktur full / view
                 $x = "tipe_instruktur_".$jumlah_detail;
                 if($request->$x=="on"){
                    $role_id = 3 ;
                 }else{
                    $role_id = 4 ;
                 }
                 $dataDetail['role_id'] = $role_id;
                 $dataUser['role_id'] = $role_id;
                 $dataDetail['created_by'] = Auth::id();
                 $dataDetail['created_at'] = Carbon::now()->toDateTimeString();

                 $dataUser['is_active'] = 1;
                 $dataUser['hint'] = str_random(8);
                 $dataUser['password'] = Hash::make($dataUser['hint']);
                 $dataUser['created_by'] = Auth::id();
                 $dataUser['created_at'] = Carbon::now()->toDateTimeString();

                 // Insert data user instruktur ke table user
                 $getIdUser = User::create($dataUser);
                 $dataDetail['id_users'] = $getIdUser->id;

                 // Insert data instruktur ke table instruktur
                 $getIdInstruktur = InstrukturModel::create($dataDetail);
                 $idInstruktur = $getIdInstruktur->id;

                 // Insert ke table jadwal_instruktur
                 $dataJadwalInstruktur['id_jadwal'] = $idJadwal;
                 $dataJadwalInstruktur['id_instruktur'] = $idInstruktur;
                 JadwalInstruktur::create($dataJadwalInstruktur);
            } 
        }
       
        if ($request->id_jumlah_detail!='' ){
            $jml_dtl_modul = explode(',', $request->id_jumlah_detail);
            foreach($jml_dtl_modul as $jml_dtl_modul) {
                $dataModul['id_jadwal'] = $idJadwal;
                $x = "id_modul_".$jml_dtl_modul;
                $dataModul['id_modul'] = $request->$x;
                $dataModul['created_by'] = Auth::id();
                $dataModul['created_at'] = Carbon::now()->toDateTimeString();

                // Insert data modul yang ada pada jadwal ini
                JadwalModul::create($dataModul); 
            }
        }
            
        return redirect('jadwal')->with('message', 'Data berhasil ditambahkan');
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
        return view('ujidaring.jadwal.show')->with(compact('data','jumlahPeserta','Peserta','jumlahSoalPg','jumlahSoalEssay'));
    }

    public function dashboard($id)
    {
        $data = JadwalModel::find($id);
        $jumlahkelompok = KelompokPeserta::where('id_jadwal',$id)->groupBy('no_kelompok')->count();
        $jumlahJadwal = JadwalRundown::where('id_jadwal','=',$id)->count();
        $id_klp_peserta = Peserta::select('id')->where('id_kelompok','=',$data->id_klp_peserta)->get();
        $jumlahabsen = AbsenModel::whereIn("id_peserta",$id_klp_peserta)->count();
        $modul = JadwalModul::where('id_jadwal','=',$data->id)->count();
        $instruktur = JadwalInstruktur::where('id_jadwal','=',$data->id)->count();
        $Peserta = Peserta::where("id_kelompok","=",$data->id_klp_peserta)->orderBy('nama','asc')->get();
        $jumlahPeserta = Peserta::where("id_kelompok","=",$data->id_klp_peserta)->count();
        $jumlahSoalPg = SoalPgModel::where("kelompok_soal","=",$data->id_klp_soal_pg)->count();
        $jumlahSoalEssay = SoalEssayModel::where("kelompok_soal","=",$data->id_klp_soal_essay)->count();

        $idjadwalmodul = JadwalModul::select('id')->where('id_jadwal',$id)->get()->toArray();
        $jumlahnilaipeserta = PesertaQuis::whereIn('id_jadwal_modul',$idjadwalmodul)->count();
        return view('ujidaring.jadwal.dashboard')->with(compact('jumlahnilaipeserta','data','jumlahPeserta','Peserta','jumlahSoalPg','jumlahSoalEssay','instruktur','modul','jumlahabsen','jumlahJadwal','jumlahkelompok'));
    }

    public function peserta($id)
    {
        $data = JadwalModel::find($id);
        $Peserta = Peserta::where("id_kelompok","=",$data->id_klp_peserta)->orderBy('nama','asc')->get();
        // dd($Peserta->);

        $jumlahPeserta = Peserta::where("id_kelompok","=",$data->id_klp_peserta)->count();
        $jumlahSoalPg = SoalPgModel::where("kelompok_soal","=",$data->id_klp_soal_pg)->count();
        $jumlahSoalEssay = SoalEssayModel::where("kelompok_soal","=",$data->id_klp_soal_essay)->count();
        return view('ujidaring.jadwal.peserta')->with(compact('data','jumlahPeserta','Peserta','jumlahSoalPg','jumlahSoalEssay'));
    }

    public function pesertadetail($id_jadwal,$id_peserta)
    {
        $data = JadwalModel::find($id_jadwal);
        $no_kelompok = KelompokPeserta::select('no_kelompok')->where('id_peserta',$id_peserta)->first();
        $kelompok = KelompokPeserta::where('no_kelompok',$no_kelompok['no_kelompok'])->where('id_jadwal',$id_jadwal)->get();
        $Peserta = Peserta::where("id_kelompok","=",$data->id_klp_peserta)->where('id','=',$id_peserta)->first();
        $jumlahSoalPg = SoalPgModel::where("kelompok_soal","=",$data->id_klp_soal_pg)->count();
        $jumlahSoalEssay = SoalEssayModel::where("kelompok_soal","=",$data->id_klp_soal_essay)->count();
        $jawaban_evaluasi = JawabanEvaluasi::where('id_peserta','=',$id_peserta)->where('id_jadwal','=',$id_jadwal)->groupBy('id_instruktur')->groupBy('tanggal')->orderBy('tanggal','asc')->orderBy('id_instruktur','asc')->get();
        $modul_rundown = ModulRundown::orderBy('id_rundown','asc')->whereHas('jadwal_rundown_r', function ($query) use($id_jadwal){
            return $query->where('id_jadwal', '=', $id_jadwal);
        })->get();
        $jadwalrundown = JadwalRundown::where('id_jadwal',$id_jadwal)->orderBy('tanggal','asc')->get();
        $logs = LogActivity::where('user_id', $Peserta->user_id)->orderBy('id','desc')->get();
        return view('ujidaring.jadwal.pesertadetail')->with(compact('data','Peserta','modul_rundown','jumlahSoalPg','jumlahSoalEssay','jawaban_evaluasi','logs','kelompok','no_kelompok','jadwalrundown'));
    }

    public function pesertatm(Request $request){
        // $jaw_eval_all = JawabanEvaluasi::where('id_jadwal','=',$jaw_evaluasi['id_jadwal'])->where('id_instruktur','=',$jaw_evaluasi['id_instruktur'])->where('id_peserta','=',$request->id_peserta)->where('tanggal','=',$jaw_evaluasi['tanggal'])->with('soal_r')->with('peserta_r')->get();
        $data = JawabanTMPeserta::where('id_jadwal_modul','=',$request->id_jadwal_modul)->where('id_peserta','=',$request->id_peserta)->with('jadwal_modul_r.modul_r')->get();
        return $data;
    }

    public function pesertaquisioner(Request $request){
        $jaw_eval = JawabanEvaluasi::select('id_jadwal','id_instruktur','id_peserta','tanggal')->where('id','=',$request->id_jawaban)->first();
        $jaw_eval_group = JawabanEvaluasi::where('id_jadwal','=',$jaw_eval['id_jadwal'])->where('id_instruktur','=',$jaw_eval['id_instruktur'])->where('id_peserta','=',$jaw_eval['id_peserta'])->where('tanggal','=',$jaw_eval['tanggal'])->with('instruktur_r')->with('soal_r')->get();
        // $data = JawabanTMPeserta::where('id_jadwal_modul','=',$request->id_jadwal_modul)->where('id_peserta','=',$request->id_peserta)->with('jadwal_modul_r.modul_r')->get();
        return $jaw_eval_group;
    }

    public function aturjadwal($id)
    {
        // $data = JadwalModel::find($id);
        $id_jadwal = $id;
        $rundown = JadwalRundown::where('id_jadwal','=',$id_jadwal)->orderBy('tanggal','asc')->get();
        $instrukturjadwal = JadwalInstruktur::where('id_jadwal','=',$id_jadwal)->get();
        $JadwalModul = JadwalModul::where('id_jadwal','=',$id_jadwal)->get();
        return view('ujidaring.jadwal.aturjadwal')->with(compact('rundown','id_jadwal','JadwalModul','instrukturjadwal'));
    }

    public function aturjadwalstore(Request $request)
    {
        for ($i=1; $i<=$request->jumlah ; $i++) {
            $dataNotdeleteIns = [];
            $dataNotdeleteModul = [];
            // Insert ke table instruktur rowndown
            $x = "instruktur_".$i;
            $loop = $request->$x;

            $y = "id_rowdown_".$i;
            $idrundown = $request->$y;
            
            if($loop==null || $loop==""){

            }else{
                $length = count($loop);
                for ($j=0; $j < $length ; $j++) { 
                    $datarowins['id_rundown'] = $idrundown;
                    $datarowins['id_jadwal_instruktur'] = $loop[$j];
                    $datarowins['created_by'] = Auth::id();
                    $datarowins['created_at'] = Carbon::now()->toDateTimeString();
                    $cekdata = InsRundown::select('id')->where('id_rundown','=',$datarowins['id_rundown'])->where('id_jadwal_instruktur','=',$datarowins['id_jadwal_instruktur'])->first();
                    if($cekdata==null){
                        $insertInsRun = InsRundown::create($datarowins);
                        array_push($dataNotdeleteIns,$insertInsRun->id);
                    }else{
                        array_push($dataNotdeleteIns,$cekdata['id']);
                    }
                }
            }
            $user_data = [
                'deleted_by' => Auth::id(),
                'deleted_at' => Carbon::now()->toDateTimeString()
            ];
            $jadwalrundown = JadwalRundown::select('tanggal','id_jadwal')->where('id',$idrundown)->first();
            $tanggal = $jadwalrundown['tanggal'];
            $idjadwal = $jadwalrundown['id_jadwal'];

            InsRundown::where('id_rundown','=',$idrundown)->whereNotIn('id', $dataNotdeleteIns)->update($user_data);
            JawabanEvaluasi::where('id_jadwal',$idjadwal)->where('tanggal',$tanggal)->whereNotIn('id_instruktur', $dataNotdeleteIns)->update($user_data);

            // Insert ke table modul rowndown
            $x = "modul_".$i;
            $loop = $request->$x;
            if($loop==null || $loop==""){

            }else{
                $length = count($loop);
                for ($j=0; $j < $length ; $j++) { 
                    $datarowmodul['id_rundown'] = $idrundown;
                    $datarowmodul['id_jadwal_modul'] = $loop[$j];
                    $datarowmodul['created_by'] = Auth::id();
                    $datarowmodul['created_at'] = Carbon::now()->toDateTimeString();
                    $cekdata = ModulRundown::select('id')->where('id_rundown','=',$datarowmodul['id_rundown'])->where('id_jadwal_modul','=',$datarowmodul['id_jadwal_modul'])->first();
                    if($cekdata==null){
                        $insertModRun = ModulRundown::create($datarowmodul);
                        array_push($dataNotdeleteModul,$insertModRun->id);
                    }else{
                        array_push($dataNotdeleteModul,$cekdata['id']);
                    }
                }
            }
            $user_data = [
                'deleted_by' => Auth::id(),
                'deleted_at' => Carbon::now()->toDateTimeString()
            ];
            ModulRundown::where('id_rundown','=',$idrundown)->whereNotIn('id', $dataNotdeleteModul)->update($user_data);
        }
        return redirect()->back()->with('message', 'Berhasil Input Rundown!'); 
    }

    public function uploadquiz($id_jadwal,$id)
    {
        $tanggal = JadwalRundown::select('tanggal')->where('id','=',$id)->first();
        $tanggal = $tanggal['tanggal'];
        $modulrundown = ModulRundown::where('id_rundown','=',$id)->orderBy('id','asc')->get();
       
        return view('ujidaring.jadwal.uploadquiz')->with(compact('modulrundown','id_jadwal','tanggal'));
    }
    
    public function uploadquizstore(Request $request)
    {
        $id_jadwal = $request->id_jadwal;
        for ($i=1; $i<=$request->jumlah ; $i++) {

            $x = "id_modul_rundown_".$i;
            $id_modul_rundown = $request->$x;


            // $tanggal_jadwal_rundown = ModulRundown::where('id','=',$id_modul_rundown)->first();
            // $tanggal_awal_jadwal = JadwalModel::select('tgl_awal')->where('id','=',$request->id_jadwal)->first();
            
            $x = "id_jadwalmodul_".$i;
            $id_jadwal_modul = $request->$x;
            
            $x = "pre_quiz_".$i;
            if ($files = $request->file($x)) {
                // Update waktu awal dan akhir quiz
                // if($tanggal_awal_jadwal['tgl_awal']==$tanggal_jadwal_rundown->jadwal_rundown_r->tanggal){
                //     $dataDetail['awal_pre_quiz']=Carbon::parse($tanggal_awal_jadwal['tgl_awal'])->addDay(-1)->format('Y-m-d 08:00:00');
                //     $dataDetail['akhir_pre_quiz']=Carbon::parse($tanggal_awal_jadwal['tgl_awal'])->addDay(-1)->format('Y-m-d 22:00:00');
                // }else{
                //     $dataDetail['awal_pre_quiz']=Carbon::parse($tanggal_jadwal_rundown->jadwal_rundown_r->tanggal)->addDay(-1)->format('Y-m-d 13:00:00');
                //     $dataDetail['akhir_pre_quiz']=Carbon::parse($tanggal_jadwal_rundown->jadwal_rundown_r->tanggal)->addDay(-1)->format('Y-m-d 22:00:00');
                // }

                // Delete Jika ada file soal sebelumnya
                $user_data = [
                    'deleted_by' => Auth::id(),
                    'deleted_at' => Carbon::now()->toDateTimeString()
                ];
                SoalPgPreModel::where('id_jadwal_modul','=', $id_jadwal_modul)->update($user_data);
                JawabanPesertaPgPre::where('id_jadwal_modul','=', $id_jadwal_modul)->update($user_data);

                $destinationPath = 'uploads/soal_prequiz'; // upload path
                $file = "Soal_Prequiz_Jadwal_Modul_".$id_jadwal_modul."_".Carbon::now()->timestamp.".".$files->getClientOriginalExtension();
                $files->move($destinationPath, $file);
                $file_pre['f_pre_quiz'] = $destinationPath."/".$file;

                // Update file pre quiz ke table jadwal modul
                JadwalModul::find($id_jadwal_modul)->update($file_pre);

                // Perbaikan update file pre quiz ke table modul rundown
                ModulRundown::find($id_modul_rundown)->update($file_pre);

                // import data excel ke database
                Excel::import(new SoalPgPreImport($id_jadwal_modul), public_path('/uploads/soal_prequiz/'.$file));
             } 
             
             $x = "post_quiz_".$i;
             if ($files = $request->file($x)) {
                // Update waktu awal dan akhir quiz
         
                // $dataDetail['awal_post_quiz']=Carbon::parse($tanggal_jadwal_rundown->jadwal_rundown_r->tanggal)->format('Y-m-d 13:00:00');
                // $dataDetail['akhir_post_quiz']=Carbon::parse($tanggal_jadwal_rundown->jadwal_rundown_r->tanggal)->format('Y-m-d 22:00:00');                
                
                 // Delete Jika ada file soal sebelumnya
                 $user_data = [
                     'deleted_by' => Auth::id(),
                     'deleted_at' => Carbon::now()->toDateTimeString()
                 ];
                 SoalPgPostModel::where('id_jadwal_modul','=', $id_jadwal_modul)->update($user_data);
                 JawabanPesertaPgPost::where('id_jadwal_modul','=', $id_jadwal_modul)->update($user_data);
 
                 $destinationPath = 'uploads/soal_postquiz'; // upload path
                 $file = "Soal_Postquiz_Jadwal_Modul_".$id_jadwal_modul."_".Carbon::now()->timestamp.".".$files->getClientOriginalExtension();
                 $files->move($destinationPath, $file);
                 $file_post['f_post_quiz'] = $destinationPath."/".$file;

                 // Update file post quiz ke table jadwal modul
                 JadwalModul::find($id_jadwal_modul)->update($file_post);

                // Perbaikan update file post quiz ke table modul rundown
                ModulRundown::find($id_modul_rundown)->update($file_post);
                 
                  // import data excel ke database
                 Excel::import(new SoalPgPostImport($id_jadwal_modul), public_path('/uploads/soal_postquiz/'.$file));

              }
              
              $x = "awal_pre_".$i;
              $data['awal_pre_quiz'] = $request->$x;
              $x = "durasi_pre_".$i;
              $data['durasi_pre'] = $request->$x;
              $akhir_pre = Carbon::parse($data['awal_pre_quiz'])->addMinutes($data['durasi_pre']);
              $data['akhir_pre_quiz'] = $akhir_pre;

              $x = "awal_post_".$i;
              $data['awal_post_quiz'] = $request->$x;
              $x = "durasi_post_".$i;
              $data['durasi_post'] = $request->$x;
              $akhir_post = Carbon::parse($data['awal_post_quiz'])->addMinutes($data['durasi_post']);
              $data['akhir_post_quiz'] = $akhir_post;

              $x = "tm_".$i;
              $data['jumlah_tm'] = $request->$x;

              // Update data ke table jadwal modul
              JadwalModul::find($id_jadwal_modul)->update($data);
            
              // Perbaikan update data ke table modul rundown
              ModulRundown::find($id_modul_rundown)->update($data);
        }
        return redirect()->back()->with('message', 'Soal Quiz Berhasil di Upload');
        // return redirect('jadwal/aturjadwal/'.$id_jadwal)->with('message', 'Soal Quiz Berhasil di Upload');
    }

    public function absen($id)
    {
        $data = JadwalModel::find($id);
        $id_jadwal = $id;
        $id_klp_peserta = Peserta::select('id')->where('id_kelompok','=',$data->id_klp_peserta)->get();
        $absen = AbsenModel::whereIn("id_peserta",$id_klp_peserta)->where('tanggal',Carbon::now()->format('Y-m-d'))->get();
        $jumlahPeserta = Peserta::where("id_kelompok","=",$data->id_klp_peserta)->count();
        $jumlahSoalPg = SoalPgModel::where("kelompok_soal","=",$data->id_klp_soal_pg)->count();
        $jumlahSoalEssay = SoalEssayModel::where("kelompok_soal","=",$data->id_klp_soal_essay)->count();
        return view('ujidaring.jadwal.absen')->with(compact('data','jumlahPeserta','absen','jumlahSoalPg','jumlahSoalEssay','id_jadwal'));
    }

    public function lihatnilai($id)
    {
        
        $data = JadwalModel::find($id);
        $idjadwalmodul = JadwalModul::select('id')->where('id_jadwal',$id)->get()->toArray();
        $datanilai = PesertaQuis::whereIn('id_jadwal_modul',$idjadwalmodul)->orderBy('created_at','desc')->get();
        
        $id_jadwal = $id;
        // $id_klp_peserta = Peserta::select('id')->where('id_kelompok','=',$data->id_klp_peserta)->get();
        // $absen = AbsenModel::whereIn("id_peserta",$id_klp_peserta)->where('tanggal',Carbon::now()->format('Y-m-d'))->get();
        // $jumlahPeserta = Peserta::where("id_kelompok","=",$data->id_klp_peserta)->count();
        // $jumlahSoalPg = SoalPgModel::where("kelompok_soal","=",$data->id_klp_soal_pg)->count();
        // $jumlahSoalEssay = SoalEssayModel::where("kelompok_soal","=",$data->id_klp_soal_essay)->count();
        return view('ujidaring.jadwal.lihatnilai')->with(compact('data','id_jadwal','datanilai'));
    }

    // public function nilaiexport($tglawal,$tglakhir,$idjadwal)
    // {
    //     return Excel::download(new PesertaQuisExport($idjadwal), 'NilaiPeserta.xlsx');
    // }

    public function filter_absen(Request $request)
    {
        $id_jadwal = $request->id_jadwal;
        $data = JadwalModel::find($id_jadwal);
        $id_klp_peserta = Peserta::select('id')->where('id_kelompok','=',$data->id_klp_peserta)->get();
        $absen = AbsenModel::whereIn("id_peserta",$id_klp_peserta);

        if($request->f_tgl_awal != null && $request->f_tgl_akhir != null){
            $absen->whereBetween('tanggal', [Carbon::createFromFormat('d/m/Y',$request->f_tgl_awal)->format('Y-m-d'), Carbon::createFromFormat('d/m/Y',$request->f_tgl_akhir)->format('Y-m-d')]);
        }

        if($request->jenis_absen != null && $request->jenis_absen != null){
            if($request->jenis_absen=="absen"){
                $absen->whereNotNull('jam_cek_in');
            }else if ($request->jenis_absen=="belumabsen"){
                $absen->whereNull('jam_cek_in');
            }
        }

        $absen->get();
        $absen = $absen->get();

        return view('ujidaring.jadwal.absen')->with(compact('absen','id_jadwal','data'));
    }

    public function filter_lihatnilai(Request $request)
    {
        $id_jadwal = $request->id_jadwal;

        if($request->jenis=="filter"){
            // Filter
            $data = JadwalModel::find($id_jadwal);
            $idjadwalmodul = JadwalModul::select('id')->where('id_jadwal',$id_jadwal)->get()->toArray();
            $datanilai = PesertaQuis::whereIn('id_jadwal_modul',$idjadwalmodul)->orderBy('created_at','desc');
    
            if($request->f_tgl_awal != null && $request->f_tgl_akhir != null){
                $datanilai->whereBetween('created_at', [Carbon::createFromFormat('d/m/Y',$request->f_tgl_awal)->format('Y-m-d 00:00:00'), Carbon::createFromFormat('d/m/Y',$request->f_tgl_akhir)->format('Y-m-d 23:59:59')]);
            }
    
            $datanilai->get();
            $datanilai = $datanilai->get();
    
            return view('ujidaring.jadwal.lihatnilai')->with(compact('datanilai','id_jadwal','data'));
            // Akhir Filter

        }else if ($request->jenis=="export"){
            return Excel::download(new PesertaQuisExport($id_jadwal,$request->f_tgl_awal,$request->f_tgl_akhir), 'NilaiPeserta.xlsx');
        }else{
            return "Error";
        }
  
    }

    public function instruktur($id)
    {
        $data = JadwalModel::find($id);
        $Instruktur = JadwalInstruktur::where("id_jadwal","=",$data->id)->orderBy('id','asc')->get();
        $jumlahPeserta = Peserta::where("id_kelompok","=",$data->id_klp_peserta)->count();
        $jumlahSoalPg = SoalPgModel::where("kelompok_soal","=",$data->id_klp_soal_pg)->count();
        $jumlahSoalEssay = SoalEssayModel::where("kelompok_soal","=",$data->id_klp_soal_essay)->count();
        return view('ujidaring.jadwal.instruktur')->with(compact('data','jumlahPeserta','Instruktur','jumlahSoalPg','jumlahSoalEssay'));
    }

    public function instrukturKuisioner($id_jadwal, $id_inst, $id_peserta){
        $jadwal = JadwalModel::find($id_jadwal);
        $inst = JawabanEvaluasi::where('id_jadwal',$id_jadwal)->where('id_instruktur',$id_inst)->where('id_peserta',$id_peserta)->get();
        $tanggal = $inst[0]->tanggal;
        $peserta = Peserta::find($id_peserta);
        $instruktur = InstrukturModel::find($id_inst);
        $jadwal_rn = JadwalRundown::where('id_jadwal',$id_jadwal)->where('tanggal',$tanggal)->first();
        $modul = ModulRundown::where('id_rundown',$jadwal_rn->id)->get();
        $pdf = PDF::loadview('ujidaring.instruktur.hasil_kuisioner',compact('inst','jadwal','peserta','instruktur','modul','tanggal'));
        $pdf->setPaper('A4','potrait');
        return $pdf->stream("kuisioner.pdf");
    }

    public function evaluasi($id)
    {
        $data = JadwalModel::find($id);
        $Instruktur = JadwalInstruktur::where("id_jadwal","=",$data->id)->orderBy('id','asc')->get();
        $jumlahPeserta = Peserta::where("id_kelompok","=",$data->id_klp_peserta)->count();
        $jumlahSoalPg = SoalPgModel::where("kelompok_soal","=",$data->id_klp_soal_pg)->count();
        $jumlahSoalEssay = SoalEssayModel::where("kelompok_soal","=",$data->id_klp_soal_essay)->count();
        return view('ujidaring.jadwal.evaluasi')->with(compact('data','jumlahPeserta','Instruktur','jumlahSoalPg','jumlahSoalEssay'));
    }

    public function evaluasishow($id_jadwal,$id)
    {
        $instruktur = InstrukturModel::find($id);
        $data = JadwalModel::find($id_jadwal);
        $jawEvaluasi = JawabanEvaluasi::where('id_jadwal','=',$id_jadwal)->where('id_instruktur','=',$id)->groupBy('tanggal')->orderBy('tanggal','asc')->get();
        $id_klp_peserta = Peserta::select('id')->where('id_kelompok','=',$data->id_klp_peserta)->get();
        $jumlahPeserta = Peserta::where("id_kelompok","=",$data->id_klp_peserta)->count();
        $jumlahSoalPg = SoalPgModel::where("kelompok_soal","=",$data->id_klp_soal_pg)->count();
        $jumlahSoalEssay = SoalEssayModel::where("kelompok_soal","=",$data->id_klp_soal_essay)->count();
        return view('ujidaring.jadwal.evaluasishow')->with(compact('data','jawEvaluasi','jumlahPeserta','jumlahSoalPg','jumlahSoalEssay','id_jadwal','instruktur'));
    }

    public function evaluasifilter(Request $request , $id_jadwal,$id)
    {
        $instruktur = InstrukturModel::find($id);
        $data = JadwalModel::find($id_jadwal);
        $jawEvaluasi = JawabanEvaluasi::where('id_jadwal','=',$id_jadwal)->where('id_instruktur','=',$id)->groupBy('tanggal')->orderBy('tanggal','asc');
        if($request->f_tgl_awal != null && $request->f_tgl_akhir != null){
            $jawEvaluasi->whereBetween('tanggal', [Carbon::createFromFormat('d/m/Y',$request->f_tgl_awal), Carbon::createFromFormat('d/m/Y',$request->f_tgl_akhir)]);
        }
        $jawEvaluasi->get();
        $jawEvaluasi = $jawEvaluasi->get();

        $id_klp_peserta = Peserta::select('id')->where('id_kelompok','=',$data->id_klp_peserta)->get();
        $jumlahPeserta = Peserta::where("id_kelompok","=",$data->id_klp_peserta)->count();
        $jumlahSoalPg = SoalPgModel::where("kelompok_soal","=",$data->id_klp_soal_pg)->count();
        $jumlahSoalEssay = SoalEssayModel::where("kelompok_soal","=",$data->id_klp_soal_essay)->count();
        return view('ujidaring.jadwal.evaluasishow')->with(compact('data','jawEvaluasi','jumlahPeserta','jumlahSoalPg','jumlahSoalEssay','id_jadwal','instruktur'));
    }

    public function evaluasipeserta($id_jadwal,$id)
    {
        $jaw_evaluasi = JawabanEvaluasi::select('id','id_instruktur')->where('id','=',$id)->first();
        $id_instruktur = $jaw_evaluasi['id_instruktur']; 
        $id_jaw_evaluasi = $jaw_evaluasi['id']; 
        // $tgl_eva = JawabanEvaluasi::select('tanggal','id_instruktur')->where('id','=',$id)->first();
        // $jawEvaluasi = JawabanEvaluasi::where('id_jadwal','=',$id_jadwal)->where('id_instruktur','=',$tgl_eva['id_instruktur'])->where('tanggal','=',$tgl_eva['tanggal'])->groupBy('id_peserta')->orderBy('tanggal','asc')->get();
        $data = JadwalModel::find($id_jadwal);
        $Peserta = Peserta::where("id_kelompok","=",$data->id_klp_peserta)->get();
        return view('ujidaring.jadwal.evaluasipeserta')->with(compact('Peserta','id','id_jadwal','id_instruktur','id_jaw_evaluasi'));
    }

    public function soal($id)
    {
        $data = JadwalModel::find($id);
        $SoalPg = SoalPgModel::where("kelompok_soal","=",$data->id_klp_soal_pg)->orderBy('no_soal','asc')->get();
        $SoalEssay = SoalEssayModel::where("kelompok_soal","=",$data->id_klp_soal_essay)->orderBy('no_soal','asc')->get();
        $jumlahPeserta = Peserta::where("id_kelompok","=",$data->id_klp_peserta)->count();
        $jumlahSoalPg = SoalPgModel::where("kelompok_soal","=",$data->id_klp_soal_pg)->count();
        $jumlahSoalEssay = SoalEssayModel::where("kelompok_soal","=",$data->id_klp_soal_essay)->count();
        return view('ujidaring.jadwal.soal')->with(compact('data','jumlahPeserta','SoalPg','SoalEssay','jumlahSoalPg','jumlahSoalEssay'));
    }

    public function tugas($id)
    {
        $data = JadwalModel::find($id);
        $SoalPg = SoalPgModel::where("kelompok_soal","=",$data->id_klp_soal_pg)->orderBy('no_soal','asc')->get();
        $SoalEssay = SoalEssayModel::where("kelompok_soal","=",$data->id_klp_soal_essay)->orderBy('no_soal','asc')->get();
        $jumlahPeserta = Peserta::where("id_kelompok","=",$data->id_klp_peserta)->count();
        $jumlahSoalPg = SoalPgModel::where("kelompok_soal","=",$data->id_klp_soal_pg)->count();
        $jumlahSoalEssay = SoalEssayModel::where("kelompok_soal","=",$data->id_klp_soal_essay)->count();
        return view('ujidaring.jadwal.tugas')->with(compact('data','jumlahPeserta','SoalPg','SoalEssay','jumlahSoalPg','jumlahSoalEssay'));
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
    public function destroy(Request $request)
    {   
        $user_data = [
            'deleted_by' => Auth::id(),
            'deleted_at' => Carbon::now()->toDateTimeString()
        ];
        $idData = explode(',', $request->idHapusData);
        $user_id_peserta = Peserta::select('user_id')->whereIn('id_kelompok', $idData)->get()->toArray();
        $id_instruktur = JadwalInstruktur::select('id_instruktur')->whereIn('id_jadwal', $idData)->get()->toArray();
        $user_id_inst = InstrukturModel::select('id_users')->whereIn('id', $id_instruktur)->get()->toArray();
        JadwalModel::whereIn('id', $idData)->update($user_data);
        User::whereIn('id', $user_id_peserta)->update($user_data);
        User::whereIn('id', $user_id_inst)->update($user_data);
        Peserta::whereIn('id_kelompok', $idData)->update($user_data);
        InstrukturModel::whereIn('id', $id_instruktur)->update($user_data);

        return redirect()->back()->with('message', 'Data Telah dihapus!'); 
    }

    public function AccountPeserta(Request $request)
    {
        $idData = explode(',', $request->idHapusData);
        foreach ($idData as $idData) {
            $user_id =  Peserta::select('user_id','no_hp','nama')->find($idData);
            $no_hp = $user_id['no_hp'];
            $nama = $user_id['nama'];
            $user_account =  User::select('username','hint')->where('id',"=",$user_id['user_id'])->first();
            $telepon = $no_hp;
            $message = "Gunakan NIK Anda dan kode: ".$user_account['hint']." untuk login ke https://bit.ly/2AMNeS3";
            // $message = "Gunakan NIK Anda dan kode: 1234 untuk login ke uji.disnakerdki.org";
            $sms = $this->kirimPesanSMS($telepon, $message);
            Peserta::find($idData)->update([
                'status_sms' => $sms['status'],
                'text_sms' => $sms['text']
            ]);
        }
        return back()->with('message', 'Account telah dikirim');
    }

    // function update data peserta 
    public function pesertaupdate(request $request){

        $request->validate(
            [
                'nama' => 'required',
                'no_hp' => 'required',
            ],[
                'nama.required' => "Nama tidak boleh kosong",
                'no_hp.required' => "No Hp tidak boleh kosong"
            ]);
            
        $data['nama'] = $request->nama;
        $data['no_hp'] = $request->no_hp;
        Peserta::find($request->iddatapeserta)->update($data);
        
        $user['name'] = $request->nama;

        $id_user = Peserta::select('user_id')->find($request->iddatapeserta); 
        User::find($id_user['user_id'])->update($user);

        return response()->json([
            'status' => true,
            'icon' => "success",
            'message' => 'Data peserta berhasil dirubah!'
        ]);
    } 

    public function ResetAccountPeserta(Request $request)
    {
        $idData = explode(',', $request->idResetData);
        foreach ($idData as $idData) {
            $user_id =  Peserta::select('user_id')->find($idData);
            $reset_login['is_login'] = 0;
            $reset_account =  User::where('id',"=",$user_id['user_id'])->update($reset_login);
        }
        return back()->with('message', 'Account peserta telah di reset!');
    }

    public function AccountInstruktur(Request $request)
    {
        $idData = explode(',', $request->idHapusData);
        foreach ($idData as $idData) {
            $user_id =  InstrukturModel::select('id_users','no_hp','nama')->find($idData);
            $no_hp = $user_id['no_hp'];
            $nama = $user_id['nama'];
            $user_account =  User::select('username','hint')->where('id',"=",$user_id['id_users'])->first();
            $telepon = $no_hp;
            $message = "Gunakan NIK Anda dan kode: ".$user_account['hint']." untuk login ke https://bit.ly/2AMNeS3";
            $sms = $this->kirimPesanSMS($telepon, $message);
            InstrukturModel::find($idData)->update([
                'status_sms' => $sms['status'],
                'text_sms' => $sms['text']
            ]);
        }   
        return back()->with('message', 'Account telah dikirim');
    }

    public function ResetAccountInstruktur(Request $request)
    {
        $idData = explode(',', $request->idResetData);
        foreach ($idData as $idData) {
            $user_id =  InstrukturModel::select('id_users')->find($idData);
            $reset_login['is_login'] = 0;
            $reset_account =  User::where('id',"=",$user_id['id_users'])->update($reset_login);
        }
        return back()->with('message', 'Account Instruktur telah di reset!');
    }

            // function generate kelompok peserta 
            public function getdatainstruktur(request $request){
                $instruktur = InstrukturModel::where('id','=',$request->idinstruktur)->first();
                return $instruktur;
            }

        // function update data instruktur 
        public function instrukturupdate(request $request){

            $request->validate(
                [
                    'nama' => 'required',
                    'no_hp' => 'required',
                ],[
                    'nama.required' => "Nama tidak boleh kosong",
                    'no_hp.required' => "No Hp tidak boleh kosong"
                ]);
                
            $data['nama'] = $request->nama;
            $data['no_hp'] = $request->no_hp;
            InstrukturModel::find($request->idins)->update($data);
            
            $user['name'] = $request->nama;
    
            $id_user = InstrukturModel::select('id_users')->find($request->idins); 
            User::find($id_user['id_users'])->update($user);
    
            return response()->json([
                'status' => true,
                'icon' => "success",
                'message' => 'Data instruktur berhasil dirubah!'
            ]);
        }

    // fungsi tampil form upload jadwal pkl
    public function pkl($id){
        $jadwal = JadwalModel::find($id);
        $makalah = JawabanPkl::where('id_jadwal',$id)->orderBy('id');
        $makalah = $makalah->get();
        return view('ujidaring.jadwal.pkl')->with(compact('id','jadwal','makalah'));
    }

    // fungsi upload jadwal pkl
    public function upload_pkl_store(Request $request){
        // return $request->all();
        // handle upload Premi bpjs kesehatan
        $request->validate(
            [
                'materiPkl' => 'mimes:flv,mp4,avi,pdf|max:20480',
                'batas_up_makalah' => 'required',
            ],[
                'materiPkl.required' => "Materi PKL Harus di isi",
                'batas_up_makalah.required' => "Batas Waktu Makalah Harus di isi",
                'materiPkl.mimes' => "Materi PKL hanya format FLV, MP4, AVI, PDF",
                'materiPkl.max' => "Maksimal ukuran file 20MB"
            ]);
        $data = JadwalModel::find($request->id_jadwal);
        $data->batas_up_makalah = $request->batas_up_makalah;
        $data->l_pkl = $request->l_pkl;
        if ($files = $request->file('materiPkl')) {
            // return "test";
            $destinationPath = 'uploads/pkl/'.$request->id_jadwal; // upload path
            $file = "materi_PKL_".Carbon::now()->timestamp. "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file);
            $data->f_pkl= $request->id_jadwal."/".$file;
        }
        
        $data->save();
        return response()->json([
            'status' => true,
            'message' => 'Materi PKL berhasil diupload'
        ]);
    }

    // fungsi tampil daftar presentasi
    public function presentasi($id){
        $data = JadwalModel::find($id);
        return view('ujidaring.jadwal.presentasi')->with(compact('data'));
    }

    // function generate kelompok peserta 
    public function getdatapeserta(request $request){
        $peserta = Peserta::where('id','=',$request->idpeserta)->first();
        return $peserta;
    }
    
    // function generate kelompok peserta 
    public function gen(request $request){

        $request->validate(
            [
                'jumlahkelompok' => 'required'
            ],[
                'jumlahkelompok.required' => "Jumlah Kelompok Harus di isi"
            ]);

        // $jumlahPeserta = Peserta::where('id_kelompok','=',$request->idjadwal)->count();
        // if($jumlahPeserta<7){
        //     return response()->json([
        //         'icon' => 'error',
        //         'status' => true,
        //         'message' => 'Minimal Peserta 7 Orang !'
        //     ]);
        // }
        if($request->jumlahkelompok<=0){
            return response()->json([
                'icon' => 'warning',
                'status' => true,
                'message' => "Minimal Kelompok 1!"
            ]);
        }


        $is_kelompok = JadwalModel::select('is_kelompok')->where('id','=',$request->idjadwal)->first();
        if($is_kelompok['is_kelompok']==1){
            return response()->json([
                'icon' => 'warning',
                'status' => true,
                'message' => "Kelompok sudah ada !"
            ]);
        }

        $dataupdate['is_kelompok'] = 1;
        JadwalModel::find($request->idjadwal)->update($dataupdate);
        $data = $this->buat_kelompok($request->idjadwal,$request->jumlahkelompok);
        $no_kelompok=1;
  
        for ($i=1; $i <= count($data) ; $i++) { 
                foreach($data[$i] as $id_peserta){
                    $datakelompok['id_jadwal'] = $request->idjadwal;
                    $datakelompok['id_peserta'] = $id_peserta;
                    $datakelompok['id_ketua'] = $data[$i][0];
                    $datakelompok['no_kelompok'] = $no_kelompok; 
                    $datakelompok['created_by'] = Auth::id();
                    $datakelompok['created_at'] = Carbon::now()->toDateTimeString();
                    KelompokPeserta::create($datakelompok);
                }
        $no_kelompok++;
        }

        // $dataupdate['is_kelompok'] = 1;
        // JadwalModel::find($request->idjadwal)->update($dataupdate);
        // $data = $this->generate_kelompok($request->idjadwal);
        // $no_kelompok = 1;
        // foreach ($data as $row) {
        //     foreach ($row as $idpeserta) {
        //         $datakelompok['id_jadwal'] = $request->idjadwal;
        //         $datakelompok['id_peserta'] = $idpeserta;
        //         $datakelompok['id_ketua'] = $row[0];
        //         $datakelompok['no_kelompok'] = $no_kelompok; 
        //         $datakelompok['created_by'] = Auth::id();
        //         $datakelompok['created_at'] = Carbon::now()->toDateTimeString();
        //         KelompokPeserta::create($datakelompok);
        //     }
        //     $no_kelompok++;
        // }

        return response()->json([
            'icon' => 'success',
            'status' => true,
            'message' => 'Kelompok berhasil dibuat!'
        ]);
    }

    public function lihatkelompok($id){
        $datakelompok = KelompokPeserta::where('id_jadwal',$id)->groupBy('no_kelompok')->get();
        $datapeserta = KelompokPeserta::where('id_jadwal',$id)->get();
        $data = JadwalModel::find($id);
        $Peserta = Peserta::where("id_kelompok","=",$data->id_klp_peserta)->orderBy('nama','asc')->get();
        $jumlahPeserta = Peserta::where("id_kelompok","=",$data->id_klp_peserta)->count();
        $jumlahSoalPg = SoalPgModel::where("kelompok_soal","=",$data->id_klp_soal_pg)->count();
        $jumlahSoalEssay = SoalEssayModel::where("kelompok_soal","=",$data->id_klp_soal_essay)->count();
        return view('ujidaring.jadwal.kelompok')->with(compact('data','jumlahPeserta','Peserta','jumlahSoalPg','jumlahSoalEssay','datakelompok','datapeserta'));
    } 

    public function lihatsoalpre (Request $request){
        $datasoal = SoalPgPreModel::where('id_jadwal_modul','=',$request->value_id)->with('jadwal_modul_r.modul_r')->get();
        return $datasoal;
    }

    public function lihatsoalpost (Request $request){
        $datasoal = SoalPgPostModel::where('id_jadwal_modul','=',$request->value_id)->with('jadwal_modul_r.modul_r')->get();
        return $datasoal;
    }

}
