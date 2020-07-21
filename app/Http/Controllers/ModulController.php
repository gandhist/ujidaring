<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MasterModul;
use App\MasterBidang;
use App\MasterJenisUsaha;

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
        
        $request->validate([
            'id_bidang'=>'required',
            'id_sert_alat' => 'required',
            'id_jumlah_hari'=>'required',
            'id_syarat'=>'required',
        ],
        ['id_bidang.required'=>'Kolom bidang harus diisi',
        'id_sert_alat.required'=>'Kolom sertifikat alat harus diisi',
        'id_jumlah_hari.required' => 'Kolom jumlah hari harus diisi',
        'id_syarat.required' => 'Kolom syarat harus diisi'
        ]
        );

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
                // handle upload foto instruktur 
                if ($files = $request->file($x)) {
                    $destinationPath = 'uploads/modul'; // upload path
                    $file = "Modul_".$id."_".$id_sert_alat. "." .$files->getClientOriginalExtension();
                    $files->move($destinationPath, $file);
                    $dataDetail2['materi'] = $destinationPath."/".$file;
                    MasterModul::find($id)->update($dataDetail2);
                 }

            }
        }
        return redirect('mastermodul')->with('message', 'Data berhasil ditambahkan');
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
