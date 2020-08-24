<?php

namespace App\Http\Controllers\Ujidaring\Peserta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Ujidaring\Peserta;
use App\Models\Ujidaring\JawabanPeserta;
use App\Models\Ujidaring\JawabanEssayPeserta;
use App\Models\Ujidaring\JawabanPesertaPgPost;
use App\Models\Ujidaring\JawabanTMPeserta;
use App\Models\Ujidaring\JadwalModul;
use App\Models\Ujidaring\SoalPgPostModel;
use App\Models\Ujidaring\PesertaQuis;
use App\Traits\Ujidaring\GlobalFunction;

class PostQuisController extends Controller
{
    //
    use GlobalFunction;

    public function index(){
        $peserta = Peserta::where('user_id',Auth::id())->first();
        $modul_today = JadwalModul::where($peserta->jadwal_r->id);
        $modul_today = $this->is_post_today(); // 
        // return $modul_today;
        // $pg = JawabanPesertaPgPre::where('id_peserta',$peserta->id)->where('id_jadwal',$peserta->jadwal_r->id)->paginate(10);
        // $tm = JawabanEssayPeserta::where('id_peserta',$peserta->id)->where('id_modul_rundown',$peserta->jadwal_r->id)->get();
        \LogActivity::addToLog('Membuka halaman post quis harian');
        return view('ujidaring.quis.pasca.index')->with(compact('peserta','modul_today'));
    }

    public function show(Request $request, $id_p, $id_jdw_mod){
        $peserta = Peserta::where('user_id',Auth::id())->first();
        $pg = JawabanPesertaPgPost::where('id_peserta',$peserta->id)->where('id_jadwal_modul',$id_jdw_mod)->paginate(10);
        $tm = JawabanTMPeserta::where('id_peserta',$peserta->id)->where('id_jadwal_modul',$id_jdw_mod)->where('tipe','post')->get();
        $modul_today = JadwalModul::find($id_jdw_mod);
        if($request->ajax()){
            return view('ujidaring.quis.pre.soal',[
                'pg' => $pg,
                'modul_today' => $modul_today,
            ])->render();
        }
        \LogActivity::addToLog("Membuka halaman Post quis ". $modul_today->modul_r->modul);
        return view('ujidaring.quis.pasca.uji')->with(compact('peserta','pg','tm','modul_today'));
    }

    // function save parsial
    public function pg_save_parsial(Request $request){
        // return $request->all();
        $val_exp = explode("#", $request->jawaban);
        $peserta = Peserta::where('user_id',Auth::id())->first();
        JawabanPesertaPgPost::updateOrCreate([
            'id_jadwal_modul' => $request->id_jadwal,
            'id_peserta' => $peserta->id,
            'id_soal_pg_post' => $val_exp[0],
        ],[
            'jawaban' => $val_exp[1],
            'is_true' => $this->cek_jawaban($val_exp[0], $val_exp[1])
        ]);
        return response()->json([
            'status' => true
        ],200);
    }

    // function save parsial essay
    public function tm_save_parsial(Request $request){
        // return $request->all();
        $val_exp = explode("_", $request->id_soal);
        $peserta = Peserta::where('user_id',Auth::id())->first();
        if($val_exp[0] == 'soal' ){
            $upd = [
                'soal' => $request->jawaban
            ];
        }
        else {
            $upd = [
                'jawaban' => $request->jawaban
            ];
        }
        // return $peserta->id.$request->id_jadwal.$val_exp[1];
        JawabanTMPeserta::updateOrCreate([
            'id' => $val_exp[1],
            'id_peserta' => $peserta->id,
            'tipe' => 'post',
        ],$upd);
        return response()->json([
            'status' => true
        ],200);
    }

    public function cek_jawaban($id_soal, $jwb_peserta){
        $data = SoalPgPostModel::find($id_soal);
        if ($data->jawaban == $jwb_peserta) {
            $jwb = 1;
        }
        else {
            $jwb = 0;
        }
        return $jwb;
    }

    // save all
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
            JawabanPesertaPgPost::updateOrCreate([
                'id_jadwal_modul' => $request->id_jadwal,
                'id_peserta' => $peserta->id,
                'id_soal_pg_post' => $val_exp[0],
            ],[
                'jawaban' => $val_exp[1],
                'is_true' => $this->cek_jawaban($val_exp[0], $val_exp[1])
            ]);
            // $dt_jw->save();
        }
        $benar = JawabanPesertaPgPost::where('id_jadwal_modul',$request->id_jadwal)
        ->where('id_peserta',$peserta->id)
        ->where('is_true',1)->count();
        $salah = JawabanPesertaPgPost::where('id_jadwal_modul',$request->id_jadwal)
        ->where('id_peserta',$peserta->id)
        ->where('is_true',0)->count();
        $null = JawabanPesertaPgPost::where('id_jadwal_modul',$request->id_jadwal)
        ->where('id_peserta',$peserta->id)
        ->whereNull('is_true')->count();
        $salah = $salah + $null;
        // update status pra quis peserta
        PesertaQuis::updateOrCreate([
            'id_jadwal_modul' => $request->id_jadwal,
            'id_peserta' => $peserta->id,
            'tipe_quis' => 'post',
            'created_by' => Auth::id(),

        ],[
            'benar' => $benar,
            'salah' => $salah,
            'status' => '1',
            'updated_by' => Auth::id(),
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Jawaban Anda Berhasil Disimpan pra quis'
        ],200);
    }
}
