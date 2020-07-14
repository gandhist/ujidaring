<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MasterJenisUsaha;
use App\MasterBidang;
use App\JadwalModel;
use App\JadwalModul;
use App\InstrukturModel;
use App\JadwalInstruktur;
use App\JawabanPkl;
use App\Peserta;
use App\User;
use App\Imports\PesertaImport;
use App\Imports\SoalPgImport;
use App\Imports\SoalEssayImport;
use App\Imports\SoalPgPreImport;
use App\Imports\SoalPgPostImport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\GlobalFunction;
use App\SoalPgModel;
use App\SoalEssayModel;
use App\SoalPgPreModel;
use App\SoalPgPostModel;
use App\AbsenModel;
use App\JadwalRundown;
use App\InsRundown;
use App\ModulRundown;
use App\JawabanEvaluasi;


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
        return view('jadwal.index')->with(compact('data'));
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
        return view('jadwal.create')->with(compact('jenisusaha','bidang'));
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

        // Insert ke table rowndown
        $from = Carbon::parse(Carbon::createFromFormat('d/m/Y', $request->tgl_awal)->format('Y-m-d'));
        $to = Carbon::parse(Carbon::createFromFormat('d/m/Y', $request->tgl_akhir)->format('Y-m-d'));
        $dates = [];
        
        for($d = $from; $d->lte($to); $d->addDay()) {
            $data_schedule['id_jadwal'] = $idJadwal;
            $data_schedule['tanggal'] = $d->format('Y-m-d'); 
            $data_schedule['created_by'] = Auth::id();
            $data_schedule['created_at'] = Carbon::now()->toDateTimeString();
            JadwalRundown::create($data_schedule);
        }

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
        return view('jadwal.show')->with(compact('data','jumlahPeserta','Peserta','jumlahSoalPg','jumlahSoalEssay'));
    }

    public function dashboard($id)
    {
        $data = JadwalModel::find($id);
        $jumlahJadwal = JadwalRundown::where('id_jadwal','=',$id)->count();
        $id_klp_peserta = Peserta::select('id')->where('id_kelompok','=',$data->id_klp_peserta)->get();
        $jumlahabsen = AbsenModel::whereIn("id_peserta",$id_klp_peserta)->count();
        $modul = JadwalModul::where('id_jadwal','=',$data->id)->count();
        $instruktur = JadwalInstruktur::where('id_jadwal','=',$data->id)->count();
        $Peserta = Peserta::where("id_kelompok","=",$data->id_klp_peserta)->orderBy('nama','asc')->get();
        $jumlahPeserta = Peserta::where("id_kelompok","=",$data->id_klp_peserta)->count();
        $jumlahSoalPg = SoalPgModel::where("kelompok_soal","=",$data->id_klp_soal_pg)->count();
        $jumlahSoalEssay = SoalEssayModel::where("kelompok_soal","=",$data->id_klp_soal_essay)->count();
        return view('jadwal.dashboard')->with(compact('data','jumlahPeserta','Peserta','jumlahSoalPg','jumlahSoalEssay','instruktur','modul','jumlahabsen','jumlahJadwal'));
    }

    public function peserta($id)
    {
        $data = JadwalModel::find($id);
        $Peserta = Peserta::where("id_kelompok","=",$data->id_klp_peserta)->orderBy('nama','asc')->get();
        $jumlahPeserta = Peserta::where("id_kelompok","=",$data->id_klp_peserta)->count();
        $jumlahSoalPg = SoalPgModel::where("kelompok_soal","=",$data->id_klp_soal_pg)->count();
        $jumlahSoalEssay = SoalEssayModel::where("kelompok_soal","=",$data->id_klp_soal_essay)->count();
        return view('jadwal.peserta')->with(compact('data','jumlahPeserta','Peserta','jumlahSoalPg','jumlahSoalEssay'));
    }

    public function aturjadwal($id)
    {
        // $data = JadwalModel::find($id);
        $id_jadwal = $id;
        $rundown = JadwalRundown::where('id_jadwal','=',$id_jadwal)->orderBy('tanggal','asc')->get();
        $instrukturjadwal = JadwalInstruktur::where('id_jadwal','=',$id_jadwal)->get();
        $JadwalModul = JadwalModul::where('id_jadwal','=',$id_jadwal)->get();
        return view('jadwal.aturjadwal')->with(compact('rundown','id_jadwal','JadwalModul','instrukturjadwal'));
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
            InsRundown::where('id_rundown','=',$idrundown)->whereNotIn('id', $dataNotdeleteIns)->update($user_data);

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
       
        return view('jadwal.uploadquiz')->with(compact('modulrundown','id_jadwal','tanggal'));
    }
    
    public function uploadquizstore(Request $request)
    {
        $id_jadwal = $request->id_jadwal;
        for ($i=1; $i<=$request->jumlah ; $i++) {
            $x = "id_modul_rundown_".$i;
            $id_modul_rundown = $request->$x;
            $tanggal_jadwal_rundown = ModulRundown::where('id','=',$id_modul_rundown)->first();
            $tanggal_awal_jadwal = JadwalModel::select('tgl_awal')->where('id','=',$request->id_jadwal)->first();
            
            $x = "id_jadwalmodul_".$i;
            $id_jadwal_modul = $request->$x;
            
            $x = "pre_quiz_".$i;
            if ($files = $request->file($x)) {
                // Update waktu awal dan akhir quiz
                if($tanggal_awal_jadwal['tgl_awal']==$tanggal_jadwal_rundown->jadwal_rundown_r->tanggal){
                    $dataDetail['awal_pre_quiz']=Carbon::parse($tanggal_awal_jadwal['tgl_awal'])->addDay(-1)->format('Y-m-d 08:00:00');
                    $dataDetail['akhir_pre_quiz']=Carbon::parse($tanggal_awal_jadwal['tgl_awal'])->addDay(-1)->format('Y-m-d 22:00:00');
                }else{
                    $dataDetail['awal_pre_quiz']=Carbon::parse($tanggal_awal_jadwal['tgl_awal'])->addDay(-1)->format('Y-m-d 13:00:00');
                    $dataDetail['akhir_pre_quiz']=Carbon::parse($tanggal_awal_jadwal['tgl_awal'])->addDay(-1)->format('Y-m-d 22:00:00');
                }

                // Delete Jika ada file soal sebelumnya
                $user_data = [
                    'deleted_by' => Auth::id(),
                    'deleted_at' => Carbon::now()->toDateTimeString()
                ];
                SoalPgPreModel::where('id_jadwal_modul','=', $id_jadwal_modul)->update($user_data);

                $destinationPath = 'uploads/soal_prequiz'; // upload path
                $file = "Soal_Prequiz_Jadwal_Modul_".$id_jadwal_modul."_".Carbon::now()->timestamp.".".$files->getClientOriginalExtension();
                $files->move($destinationPath, $file);
                $dataDetail['f_pre_quiz'] = $destinationPath."/".$file;
                $f_pre_quiz = JadwalModul::find($id_jadwal_modul)->update($dataDetail);
                // import data excel ke database
                Excel::import(new SoalPgPreImport($id_jadwal_modul), public_path('/uploads/soal_prequiz/'.$file));
             } 
             
             $x = "post_quiz_".$i;
             if ($files = $request->file($x)) {
                // Update waktu awal dan akhir quiz
         
                $dataDetail['awal_post_quiz']=Carbon::parse($tanggal_jadwal_rundown->jadwal_rundown_r->tanggal)->format('Y-m-d 13:00:00');
                $dataDetail['akhir_post_quiz']=Carbon::parse($tanggal_jadwal_rundown->jadwal_rundown_r->tanggal)->format('Y-m-d 22:00:00');                
                
                 // Delete Jika ada file soal sebelumnya
                 $user_data = [
                     'deleted_by' => Auth::id(),
                     'deleted_at' => Carbon::now()->toDateTimeString()
                 ];
                 SoalPgPostModel::where('id_jadwal_modul','=', $id_jadwal_modul)->update($user_data);
 
                 $destinationPath = 'uploads/soal_postquiz'; // upload path
                 $file = "Soal_Postquiz_Jadwal_Modul_".$id_jadwal_modul."_".Carbon::now()->timestamp.".".$files->getClientOriginalExtension();
                 $files->move($destinationPath, $file);
                 $dataDetail['f_post_quiz'] = $destinationPath."/".$file;
                 $f_pre_quiz = JadwalModul::find($id_jadwal_modul)->update($dataDetail);
                 // import data excel ke database
                 Excel::import(new SoalPgPostImport($id_jadwal_modul), public_path('/uploads/soal_postquiz/'.$file));
              } 
              $x = "tm_".$i;
              $dataDetail2['jumlah_tm'] = $request->$x;
              JadwalModul::find($id_jadwal_modul)->update($dataDetail2);
        }
        return redirect()->back()->with('message', 'Soal Quiz Berhasil di Upload');
        // return redirect('jadwal/aturjadwal/'.$id_jadwal)->with('message', 'Soal Quiz Berhasil di Upload');
    }

    public function absen($id)
    {
        $data = JadwalModel::find($id);
        $id_jadwal = $id;
        $id_klp_peserta = Peserta::select('id')->where('id_kelompok','=',$data->id_klp_peserta)->get();
        $absen = AbsenModel::whereIn("id_peserta",$id_klp_peserta)->get();
        $jumlahPeserta = Peserta::where("id_kelompok","=",$data->id_klp_peserta)->count();
        $jumlahSoalPg = SoalPgModel::where("kelompok_soal","=",$data->id_klp_soal_pg)->count();
        $jumlahSoalEssay = SoalEssayModel::where("kelompok_soal","=",$data->id_klp_soal_essay)->count();
        return view('jadwal.absen')->with(compact('data','jumlahPeserta','absen','jumlahSoalPg','jumlahSoalEssay','id_jadwal'));
    }

    public function filter_absen(Request $request)
    {
        $id_jadwal = $request->id_jadwal;
        $data = JadwalModel::find($id_jadwal);
        $id_klp_peserta = Peserta::select('id')->where('id_kelompok','=',$data->id_klp_peserta)->get();
        $absen = AbsenModel::whereIn("id_peserta",$id_klp_peserta);

        if($request->f_tgl_awal != null && $request->f_tgl_akhir != null){
            $absen->whereBetween('tanggal', [Carbon::createFromFormat('d/m/Y',$request->f_tgl_awal), Carbon::createFromFormat('d/m/Y',$request->f_tgl_akhir)]);
        }
        $absen->get();
        $absen = $absen->get();

        return view('jadwal.absen')->with(compact('absen','id_jadwal','data'));
    }

    public function instruktur($id)
    {
        $data = JadwalModel::find($id);
        $Instruktur = JadwalInstruktur::where("id_jadwal","=",$data->id)->orderBy('id','asc')->get();
        $jumlahPeserta = Peserta::where("id_kelompok","=",$data->id_klp_peserta)->count();
        $jumlahSoalPg = SoalPgModel::where("kelompok_soal","=",$data->id_klp_soal_pg)->count();
        $jumlahSoalEssay = SoalEssayModel::where("kelompok_soal","=",$data->id_klp_soal_essay)->count();
        return view('jadwal.instruktur')->with(compact('data','jumlahPeserta','Instruktur','jumlahSoalPg','jumlahSoalEssay'));
    }

    public function evaluasi($id)
    {
        $data = JadwalModel::find($id);
        $Instruktur = JadwalInstruktur::where("id_jadwal","=",$data->id)->orderBy('id','asc')->get();
        $jumlahPeserta = Peserta::where("id_kelompok","=",$data->id_klp_peserta)->count();
        $jumlahSoalPg = SoalPgModel::where("kelompok_soal","=",$data->id_klp_soal_pg)->count();
        $jumlahSoalEssay = SoalEssayModel::where("kelompok_soal","=",$data->id_klp_soal_essay)->count();
        return view('jadwal.evaluasi')->with(compact('data','jumlahPeserta','Instruktur','jumlahSoalPg','jumlahSoalEssay'));
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
        return view('jadwal.evaluasishow')->with(compact('data','jawEvaluasi','jumlahPeserta','jumlahSoalPg','jumlahSoalEssay','id_jadwal','instruktur'));
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
        return view('jadwal.evaluasishow')->with(compact('data','jawEvaluasi','jumlahPeserta','jumlahSoalPg','jumlahSoalEssay','id_jadwal','instruktur'));
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
        return view('jadwal.evaluasipeserta')->with(compact('Peserta','id','id_jadwal','id_instruktur','id_jaw_evaluasi'));
    }

    public function soal($id)
    {
        $data = JadwalModel::find($id);
        $SoalPg = SoalPgModel::where("kelompok_soal","=",$data->id_klp_soal_pg)->orderBy('no_soal','asc')->get();
        $SoalEssay = SoalEssayModel::where("kelompok_soal","=",$data->id_klp_soal_essay)->orderBy('no_soal','asc')->get();
        $jumlahPeserta = Peserta::where("id_kelompok","=",$data->id_klp_peserta)->count();
        $jumlahSoalPg = SoalPgModel::where("kelompok_soal","=",$data->id_klp_soal_pg)->count();
        $jumlahSoalEssay = SoalEssayModel::where("kelompok_soal","=",$data->id_klp_soal_essay)->count();
        return view('jadwal.soal')->with(compact('data','jumlahPeserta','SoalPg','SoalEssay','jumlahSoalPg','jumlahSoalEssay'));
    }

    public function tugas($id)
    {
        $data = JadwalModel::find($id);
        $SoalPg = SoalPgModel::where("kelompok_soal","=",$data->id_klp_soal_pg)->orderBy('no_soal','asc')->get();
        $SoalEssay = SoalEssayModel::where("kelompok_soal","=",$data->id_klp_soal_essay)->orderBy('no_soal','asc')->get();
        $jumlahPeserta = Peserta::where("id_kelompok","=",$data->id_klp_peserta)->count();
        $jumlahSoalPg = SoalPgModel::where("kelompok_soal","=",$data->id_klp_soal_pg)->count();
        $jumlahSoalEssay = SoalEssayModel::where("kelompok_soal","=",$data->id_klp_soal_essay)->count();
        return view('jadwal.tugas')->with(compact('data','jumlahPeserta','SoalPg','SoalEssay','jumlahSoalPg','jumlahSoalEssay'));
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
            $message = "Gunakan NIK Anda dan kode: ".$user_account['hint']." untuk login ke cdg.sh/ujitulis";
            // $message = "Gunakan NIK Anda dan kode: 1234 untuk login ke uji.disnakerdki.org";
            $this->kirimPesanSMS($telepon, $message);
        }   
        return back()->with('message', 'Account telah dikirim');
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
            $message = "Gunakan NIK Anda dan kode: ".$user_account['hint']." untuk login ke cdg.sh/ujitulis";
            $this->kirimPesanSMS($telepon, $message);
        }   
        return back()->with('message', 'Account telah dikirim');
    }

    // fungsi tampil form upload jadwal pkl
    public function pkl($id){
        $jadwal = JadwalModel::find($id);
        $makalah = JawabanPkl::where('id_jadwal',$id)->orderBy('id');
        $makalah = $makalah->get();
        return view('jadwal.pkl')->with(compact('id','jadwal','makalah'));
    }

    // fungsi upload jadwal pkl
    public function upload_pkl_store(Request $request){
        // return $request->all();
        // handle upload Premi bpjs kesehatan
        $request->validate(
            [
                'materiPkl' => 'mimes:flv,mp4,avi|max:20480',
                'batas_up_makalah' => 'required'
            ],[
                'materiPkl.required' => "Materi PKL Harus di isi",
                'batas_up_makalah.required' => "Batas Waktu Makalah Harus di isi",
                'materiPkl.mimes' => "Materi PKL hanya format FLV, MP4, AVI",
                'materiPkl.max' => "Maksimal ukuran file 20MB"
            ]);
        $data = JadwalModel::find($request->id_jadwal);
        $data->batas_up_makalah = $request->batas_up_makalah;
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
            'message' => 'materi PKL berhasil di upload'
        ]);
    }

    // fungsi tampil daftar presentasi
    public function presentasi($id){
        $data = JadwalModel::find($id);
        return view('jadwal.presentasi')->with(compact('data'));
    }

    // function generate kelompok peserta 
    public function gen($id_jadwal){
        return $this->generate_kelompok($id_jadwal);
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
