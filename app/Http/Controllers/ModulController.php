<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MasterModul;
use App\MasterBidang;
use App\MasterJenisUsaha;
use App\MasterSertifikatAlat;
use Carbon\Carbon;

class ModulController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MasterModul::orderBy("id","asc")->groupBy('id_bid_srtf_alat')->get();
        return view('modul.index')->with(compact('data'));
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
        return view('modul.create')->with(compact('jenisusaha','bidang'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $px_materi = "file_modul_";
        $px_modul = "modul_";
        $px_jp = "jp_";
        $anggota = [];
        $anggota_msg = [];
        // $jumlahdetail = $request->jumlah_detail;
        $idData = explode(',', $request->jumlah_detail);
        foreach ($idData as $idData) {
            if ($request->has($px_modul.$idData)) {
                $anggota += [
                    $px_modul.$idData => 'required',
                    $px_jp.$idData => 'required',
                    $px_materi.$idData => 'mimes:pdf,docx,xls,xlsx,mp4,ppt,pptx|max:20480'
                ];
                $anggota_msg += [
                    $px_materi.$idData.".mimes" => 'Upload Hanya format PDF,XLS,DOCX, MP4!',
                    $px_materi.$idData.".max" => 'Maksimal File 20MB!',
                    $px_modul.$idData.".required" => 'Modul harus diisi!',
                    $px_jp.$idData.".required" => 'Jam Pertemuan harus diisi!'
                ];
            } 
        }
        $anggota += [
            'id_bidang'=>'required',
            'id_sert_alat' => 'required',
            'id_jumlah_hari'=>'required',
            'id_syarat'=>'required',
        ];

        $anggota_msg += ['id_bidang.required'=>'Kolom bidang harus diisi!',
        'id_sert_alat.required'=>'Kolom sertifikat alat harus diisi!',
        'id_jumlah_hari.required' => 'Kolom jumlah hari harus diisi!',
        'id_syarat.required' => 'Kolom syarat harus diisi!'
    ];
       $request->validate($anggota, $anggota_msg); 
       
        // $request->validate([
        //     'id_bidang'=>'required',
        //     'id_sert_alat' => 'required',
        //     'id_jumlah_hari'=>'required',
        //     'id_syarat'=>'required',
        // ],
        // ['id_bidang.required'=>'Kolom bidang harus diisi',
        // 'id_sert_alat.required'=>'Kolom sertifikat alat harus diisi',
        // 'id_jumlah_hari.required' => 'Kolom jumlah hari harus diisi',
        // 'id_syarat.required' => 'Kolom syarat harus diisi'
        // ]
        // );

        $id_bidang = $request->id_bidang; 
        $id_sert_alat = $request->id_sert_alat;
        $jumlah_hari = $request->id_jumlah_hari;
        $syarat = $request->id_syarat;
  
        if ($request->jumlah_detail!='' )
        {
            $jumlah_detail = explode(',', $request->jumlah_detail);
            foreach($jumlah_detail as $jumlah_detail) {
                $x = "modul_".$jumlah_detail;
                $dataDetail['modul'] = $request->$x;
                $x = "jp_".$jumlah_detail;
                $dataDetail['jp'] = $request->$x;
                $x = "link_modul_".$jumlah_detail;
                $dataDetail['link'] = $request->$x;
                $dataDetail['persyaratan'] = $syarat;
                $dataDetail['hari'] = $jumlah_hari;
                $dataDetail['id_bid_srtf_alat'] = $id_sert_alat;
                $create_data = MasterModul::create($dataDetail);
                $id = $create_data->id;

                $x = "file_modul_".$jumlah_detail;
                // handle upload master modul file 
                if ($files = $request->file($x)) {
                    $destinationPath = 'uploads/modul'; // upload path
                    $file = "Modul_".$id."_".Carbon::now()->timestamp. "." .$files->getClientOriginalExtension();
                    $files->move($destinationPath, $file);
                    $dataDetail2['materi'] = $destinationPath."/".$file;
                    MasterModul::find($id)->update($dataDetail2);
                 }

            }
            $message = "Data berhasil ditambahkan";
            $icon = "success";
        }else{
            $message = "Harap Tambahkan Modul Terlebih Dahulu";
            $icon = "warning";
        }
        return response()->json([
            'status' => true,
            'message' => $message,
            'icon' => $icon
        ],200);
        // return redirect('mastermodul')->with('message', $message);
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
        $ms_modul = MasterModul::find($id);
        $bid = $ms_modul->bidang_srtf_alat_r->bidang_r->id;
        $srtf_bid_alat = MasterSertifikatAlat::where('id_bid','=',$bid)->get();
        $bidang = MasterBidang::where('id_jns_usaha','=','1')->get();
        $jenisusaha = MasterJenisUsaha::all();
        $detailModul = MasterModul::where('id_bid_srtf_alat','=',$ms_modul->id_bid_srtf_alat)->get();
        return view('modul.edit')->with(compact('jenisusaha','bidang','ms_modul','srtf_bid_alat','detailModul'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $px_materi = "file_modul_";
        $px_modul = "modul_";
        $px_jp = "jp_";
        $anggota = [];
        $anggota_msg = [];
        // $jumlahdetail = $request->jumlah_detail;
        $idData = explode(',', $request->jumlah_detail);
        foreach ($idData as $idData) {
            if ($request->has($px_modul.$idData)) {
                $anggota += [
                    $px_modul.$idData => 'required',
                    $px_jp.$idData => 'required',
                    $px_materi.$idData => 'mimes:pdf,docx,xls,xlsx,mp4,ppt,pptx|max:20480'
                ];
                $anggota_msg += [
                    $px_materi.$idData.".mimes" => 'Upload Hanya format PDF,XLS,DOCX, MP4!',
                    $px_materi.$idData.".max" => 'Maksimal File 20MB!',
                    $px_modul.$idData.".required" => 'Modul harus diisi!',
                    $px_jp.$idData.".required" => 'Jam Pertemuan harus diisi!'
                ];
            } 
        }
        $anggota += [
            'id_bidang'=>'required',
            'id_sert_alat' => 'required',
            'id_jumlah_hari'=>'required',
            'id_syarat'=>'required',
        ];

        $anggota_msg += ['id_bidang.required'=>'Kolom bidang harus diisi!',
        'id_sert_alat.required'=>'Kolom sertifikat alat harus diisi!',
        'id_jumlah_hari.required' => 'Kolom jumlah hari harus diisi!',
        'id_syarat.required' => 'Kolom syarat harus diisi!'
    ];
       $request->validate($anggota, $anggota_msg); 

        // $id_bidang = $request->id_bidang; 
        // $id_sert_alat = $request->id_sert_alat;
        $jumlah_hari = $request->id_jumlah_hari;
        $syarat = $request->id_syarat;
        if ($request->jumlah_detail!='' )
        {
            $jumlah_detail = explode(',', $request->jumlah_detail);
            foreach($jumlah_detail as $jumlah_detail) {
                $dataDetail=[];
                $x = "id_ms_modul_".$jumlah_detail;
                $id_ms_modul = $request->$x;
                $x = "modul_".$jumlah_detail;
                $dataDetail['modul'] = $request->$x;
                $x = "jp_".$jumlah_detail;
                $dataDetail['jp'] = $request->$x;
                $x = "link_modul_".$jumlah_detail;
                $dataDetail['link'] = $request->$x;
                $dataDetail['persyaratan'] = $syarat;
                $dataDetail['hari'] = $jumlah_hari;
                // $dataDetail['id_bid_srtf_alat'] = $id_sert_alat;
                // handle upload master modul file 
                $x = "file_modul_".$jumlah_detail;
                    if ($files = $request->file($x)) {
                        $destinationPath = 'uploads/modul'; // upload path
                        $file = "Modul_".$id_ms_modul."_".Carbon::now()->timestamp."." .$files->getClientOriginalExtension();
                        $files->move($destinationPath, $file);
                        $dataDetail['materi'] = $destinationPath."/".$file;
                    }
                $update_data = MasterModul::find($id_ms_modul)->update($dataDetail);
            }
            $message = "Data berhasil diedit";
            $icon = "success";
        }else{
            $message = "Tidak ada data modul";
            $icon = "warning";
        }
        return response()->json([
            'status' => true,
            'message' => $message,
            'icon' => $icon
        ],200);
        // return redirect('mastermodul')->with('message',  $message);
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
