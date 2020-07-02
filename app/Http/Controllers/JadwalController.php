<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MasterJenisUsaha;
use App\MasterBidang;
use App\JadwalModel;
use App\Peserta;
use App\Imports\PesertaImport;
use App\Imports\SoalPgImport;
use App\Imports\SoalEssayImport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('jadwal.index');
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
        $nama_file = Carbon::now()->timestamp.$file->getClientOriginalName();
        // upload ke folder file_siswa di dalam folder public
	    $file->move('File_Peserta',$nama_file);
    	// import data
        Excel::import(new PesertaImport, public_path('/File_Peserta/'.$nama_file));
        
        $x = Excel::toArray(new PesertaImport, public_path('/File_Peserta/'.$nama_file));
        $id_klp_peserta = $x[0][0][2];
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
        JadwalModel::create($data); 
            
        return view('jadwal.index');
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
