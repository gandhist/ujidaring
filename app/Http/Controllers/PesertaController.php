<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SoalPgModel;
use App\Peserta;
use App\JadwalModel;
use App\JawabanPeserta;
use Illuminate\Support\Facades\Auth;

class PesertaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $peserta = Peserta::where('user_id',Auth::id())->first();
        return view('peserta.dashboard')->with(compact('peserta'));
    }

    // function menampilkan form ujian online
    public function ujian_pg(){
        $peserta = Peserta::where('user_id',Auth::id())->first();
        return view('ujian.pg')->with(compact('peserta'));
    }

    // function save pilihan ke table temp
    public function pg_save(Request $request){
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
            // $data['id_jadwal'] = $request->id_jadwal;
            // $data['id_soal'] = $val_exp[0];
            // $data['jawaban'] = $val_exp[1];
            // $data['id_peserta'] = $peserta->id;
            // $dt_jw = new JawabanPeserta;
            // $dt_jw->id_jadwal =  $request->id_jadwal;
            // $dt_jw->id_soal = $val_exp[0];
            // $dt_jw->jawaban = $val_exp[1];
            // $dt_jw->id_peserta = $peserta->id;
            // $dt_jw->is_true = $this->cek_jawaban($val_exp[0], $val_exp[1]);
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
        return response()->json([
            'status' => true,
            'message' => 'Jawaban Benar '.$benar
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

    // function menampilkan form ujian essay
    public function ujian_essay(){

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

    public function kirimSMS(){
        $userkey = '43c6df9a2fb6';
        $passkey = 'bry8ntb4y5';
        $telepon = '081240353913';
        $message = 'Hi Jon Snow, you really know nothing.';
        $url = 'https://gsm.zenziva.net/api/sendsms/';
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $url);
        curl_setopt($curlHandle, CURLOPT_HEADER, 0);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curlHandle, CURLOPT_TIMEOUT,30);
        curl_setopt($curlHandle, CURLOPT_POST, 1);
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, array(
            'userkey' => $userkey,
            'passkey' => $passkey,
            'nohp' => $telepon,
            'pesan' => $message
        ));
        $results = json_decode(curl_exec($curlHandle), true);
        curl_close($curlHandle);
        return 'SMS berhasil dikirim';
    }

    public function kirimWA(){
        $userkey = '43c6df9a2fb6';
        $passkey = 'bry8ntb4y5';
        $telepon = '081240353913';
        $message = 'Hallo Jon f Snow, this message send automatically from your laralove';
        $url = 'https://gsm.zenziva.net/api/sendWA/';
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $url);
        curl_setopt($curlHandle, CURLOPT_HEADER, 0);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curlHandle, CURLOPT_TIMEOUT,30);
        curl_setopt($curlHandle, CURLOPT_POST, 1);
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, array(
            'userkey' => $userkey,
            'passkey' => $passkey,
            'nohp' => $telepon,
            'pesan' => $message
        ));
        $results = json_decode(curl_exec($curlHandle), true);
        curl_close($curlHandle);
        return 'WA berhasil dikirim';

    }
}
