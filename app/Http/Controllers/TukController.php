<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MasterTuk;
use App\BadanUsaha;
use App\MasterProvinsi;
use App\MasterKota;
use App\MasterDaftarBank;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MasterTuk::all();
        return view('tuk.index')->with(compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $badanusaha = BadanUsaha::all();
        $provinsi = MasterProvinsi::all();
        $kota = MasterKota::all();
        $bank = MasterDaftarBank::all();
        return view('tuk.create')->with(compact('badanusaha','provinsi','kota','bank'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'id_badan_usaha' => 'required',
                'id_nama_tuk' => 'required',
                'id_alamat_tuk' => 'required',
                'id_provinsi' => 'required',
                'id_kota' => 'required',
                'id_no_tlp' => 'required',
                'id_email' => 'required',
                'id_pengelola' => 'required',
                'id_nama_kp' => 'required',
                'id_hp_kp' => 'required',
                'id_no_rek' => 'required',
                'id_nama_rek' => 'required',
                'id_bank' => 'required',
            ],[
                'id_badan_usaha.required' => "PJK3 harus diisi!",
                'id_nama_tuk.required' => "Nama TUK Observasi harus diisi",
                'id_alamat_tuk.required' => "Alamat harus diisi!",
                'id_provinsi.required' => "Provinsi harus diisi!",
                'id_kota.required' => "Kota harus diisi!",
                'id_no_tlp.required' => "No Tlp harus diisi!",
                'id_email.required' => "Email harus diisi!",
                'id_pengelola.required' => "Instansi Pengelola harus diisi!",
                'id_nama_kp.required' => "Nama Kontak Person harus diisi!",
                'id_hp_kp.required' => "No Hp Kontak Person harus diisi!",
                'id_no_rek.required' => "No Rekening Bank harus diisi!",
                'id_nama_rek.required' => "Nama Rekening Bank harus diisi!",
                'id_bank.required' => "Nama Bank harus diisi!"
            ]);

            $data['pjk3'] = $request->id_badan_usaha;
            $data['nama_tuk'] = $request->id_nama_tuk;
            $data['prov'] = $request->id_provinsi;
            $data['kota'] = $request->id_kota;
            $data['alamat'] = $request->id_alamat_tuk;
            $data['email'] = $request->id_email;
            $data['no_hp'] = $request->id_no_tlp;
            $data['pengelola'] = $request->id_pengelola;
            $data['kontak_p'] = $request->id_nama_kp;
            $data['jab_kontak_p'] = $request->id_jab_kp;
            $data['no_hp_kontak_p'] = $request->id_hp_kp;
            $data['email_kontak_p'] = $request->id_eml_kp;
            $data['no_rek'] = $request->id_no_rek;
            $data['id_bank'] = $request->id_bank;
            $data['nama_rek'] = $request->id_nama_rek;
            $data['keterangan'] = $request->id_keterangan;
            $data['created_by'] = Auth::id();
            $data['created_at'] = Carbon::now()->toDateTimeString();

            MasterTuk::create($data);

            return response()->json([
                'status' => true,
                'message' => "Data berhasil di tambahkan!",
                'icon' => "success"
            ],200);
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
        dd($id);
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
