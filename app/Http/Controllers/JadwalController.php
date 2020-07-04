<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MasterJenisUsaha;
use App\MasterBidang;
use App\JadwalModel;
use App\JadwalModul;
use App\InstrukturModel;
use App\JadwalInstruktur;
use App\Peserta;
use App\User;
use App\Imports\PesertaImport;
use App\Imports\SoalPgImport;
use App\Imports\SoalEssayImport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Traits\GlobalFunction;

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
        $data = JadwalModel::all();
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
        $x = Excel::toArray(new PesertaImport, public_path('/File_Peserta/'.$nama_file));
        $id_klp_peserta = $x[0][0][2];

        // Search peserta yang id_user = null
        $createAccountPeserta = Peserta::where('user_id', '=', null)->get();
            foreach($createAccountPeserta as  $value) {
                $id_peserta = $value->id;
                $dataUser['username'] = $value->nik;
                $dataUser['name'] = $value->nama;
                $dataUser['role_id'] = 2;
                $dataUser['is_active'] = 1;
                $dataUser['hint'] = mt_rand(10000000,99999999);
                $dataUser['password'] = Hash::make($dataUser['hint']);
                $dataUser['created_by'] = Auth::id();
                $dataUser['created_at'] = Carbon::now()->toDateTimeString();
                $getIdUser = User::create($dataUser);
                $user_id['user_id'] = $getIdUser->id;

                // Update id_user di table peserta
                Peserta::find($id_peserta)->update($user_id);

                $telepon = $value->no_hp;
                // Gunakan NIK Anda dan kode: 9777 untuk login ke env('APP_URL')
                $message = "Gunakan NIK Anda dan password: ".$dataUser['hint']." untuk login ke ".env('APP_URL');
                $this->kirimPesanSMS($telepon, $message);
            }
        
        }

        if($request->hasFile('excel_soal_pg')){
            // menangkap file excel
            $file2 = $request->file('excel_soal_pg');
            // membuat nama file unik
            $nama_file2 = "Soal_PG_".Carbon::now()->timestamp."_".$file2->getClientOriginalName();
            // upload ke folder file_siswa di dalam folder public
            $file2->move('Soal',$nama_file2);
            // import data
            Excel::import(new SoalPgImport, public_path('/Soal/'.$nama_file2));
            $x = Excel::toArray(new SoalPgImport, public_path('/Soal/'.$nama_file2));
            $id_klp_pg = $x[0][0][1];
     
        }

        if($request->hasFile('excel_soal_essay')){
            // menangkap file excel
            $file3 = $request->file('excel_soal_essay');
            // membuat nama file unik
            $nama_file3 = "Soal_Essay_".Carbon::now()->timestamp."_".$file3->getClientOriginalName();
            // upload ke folder file_siswa di dalam folder public
            $file3->move('Soal',$nama_file3);
            // import data
            Excel::import(new SoalEssayImport, public_path('/Soal/'.$nama_file3));
            $x = Excel::toArray(new SoalEssayImport, public_path('/Soal/'.$nama_file3));
            $id_klp_essay = $x[0][0][1];
         
        }

        $data['tgl_awal'] = Carbon::createFromFormat('d/m/Y',$request->tgl_awal);
        $data['tgl_akhir'] = Carbon::createFromFormat('d/m/Y',$request->tgl_akhir);
        $data['tuk'] = $request->tuk;
        $data['id_jenis_usaha'] = $request->id_jenis_usaha;
        $data['id_bidang'] = $request->id_bidang;
        $data['id_sert_alat'] = $request->id_sert_alat;
        $data['id_klp_soal_pg'] = $id_klp_pg;
        $data['id_klp_peserta'] = $id_klp_peserta;
        $data['id_klp_soal_essay'] = $id_klp_essay;
        $data['created_by'] = Auth::id();
        $data['created_at'] = Carbon::now()->toDateTimeString();

        // Insert ke table jadwal
        $getIdJadwal = JadwalModel::create($data); 
        $idJadwal = $getIdJadwal->id;

        if ($files = $request->file('gambarJadwal')) {
            $destinationPath = 'uploads/GambarJadwal'; // upload path
            $file = "Pdf_Jadwal_".$idJadwal."_".Carbon::now()->timestamp. "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $file);
            $data2['pdf_jadwal'] = $destinationPath."/".$file;
        }
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
                 $dataUser['hint'] = mt_rand(10000000,99999999);
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
}
