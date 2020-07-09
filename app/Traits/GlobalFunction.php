<?php 


namespace App\Traits;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Peserta;
use App\AbsenModel;

trait GlobalFunction {
    // fungsi kirim sms
    public function kirimPesanSMS($no_hp, $pesan){
        $userkey = env('USER_ZZ');
        $passkey = env('PASS_ZZ');
        $telepon = $no_hp;
        $message = $pesan;
        $url = env('URL_SMS_ZZ');
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
        return 'sms berhasil dikirim';
    }
    // fungsi kirim wa
    public function kirimPesanWA($no_hp, $pesan){
        $userkey = env('USER_ZZ');
        $passkey = env('PASS_ZZ');
        $telepon = $no_hp;
        $message = $pesan;
        $url = env('URL_WA_ZZ');
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

    // fungsi generate kelompok by jadwal
    public function generate_kelompok($id_jadwal){
        $dt_peserta = Peserta::where('id_kelompok',$id_jadwal);
        $dt_p =[];
        // menyimpan id peserta ke dalam array
        foreach($dt_peserta as $key){
            $dt_p[] = $key->id;
        }
        // menghitung jumlah peserta
        $peserta = Peserta::where('id_kelompok',$id_jadwal)->count();
        $mod = 4; // default peserta dalam 1 kelompok
        $div = array();
        $batas = [];
        // jika jumlah peserta diatas 4
        if ($peserta > 6) {
            for ($i=1; $i <= $peserta ; $i++) { 
                $div[] = $mod * $i;
            }
            foreach($div as $key => $val){
                if($peserta >= $val){
                    $batas[] = $val; // untuk looping kelompok
                    $jml_klp = $val / $mod; // // untuk looping kelompok
                    $sisa = $peserta - $val; // sisa peserta
                    
                } // end if
            } // end foreach
        } // end if
        else if($peserta <= 6){
            return 'minimal peserta 7 Orang';
        }
        // print_r($batas);
        $i = 1;
        $kelompok = []; // untuk menampung peserta per kelompok
        $kelompok_all = []; // menampung keseluruhan peserta
        // looping batats
        $o = 0;
        // looping sebanyak jumlah kelompok batas
        for($i=1; $i<= count($batas); $i++){
            // looping untuk mengisi anggota perkelompok
            for($x=0; $x<$batas[$o];$x++){
                // jika loop pertama maka langsung isi anggota
                if($i == 1){
                    $kelompok[$i][] = $dt_p[$x];
                    $kelompok_all [] = $dt_p[$x];
                }
                // jika loop selanjutnya menggunakan kondisi ini
                else{
                    if($x>=$batas[$o-1] && $x<=$batas[$o]){
                        $kelompok[$i][] = $dt_p[$x];
                        $kelompok_all [] = $dt_p[$x];
                    }
                } 
                

            }
            $o++;
        }

        $id_tdk_ada_klp = array_diff($dt_p, $kelompok_all); // array 2D peserta tidak ada kelompok
        $pst_not_klp = []; // menampung array $id_tdk_ada_klp agar menjadi 1D
        foreach($id_tdk_ada_klp as $key => $val){
            $pst_not_klp [] = $val;
        }
        // return $sisa;
        // handle sisa peserta yang tidak dapat kelompok
        if($sisa != 0){
            if($sisa <= 2){
                // sisa peserta di bawah 3 maka push ke kelompok lain
                $no = 0;
                $klp_baru = [];
                for($i=1; $i <= $sisa; $i++){
                    // $klp_baru[] = $pst_not_klp[$no];
                    array_push($kelompok[$i], $pst_not_klp[$no]); // push ke kelompok 1
                    $no++;
                }
                // array_push($kelompok[2], $pst_not_klp[1]); // push ke kelompok 2
            }
            else {
                // buat kelompok baru
                $no = 0;
                $klp_baru = [];
                for($i=1; $i <= $sisa; $i++){
                    $klp_baru[] = $pst_not_klp[$no];
                    $no++;
                }
                array_push($kelompok, $klp_baru);
            }
        // print_r($klp_baru);

        }

        // print_r($kelompok);

        return $kelompok;
        // return "jumlah kelompok : $jml_klp sisa peserta : $sisa";
    }

    // function check is allow absen masuk
    public function _is_allow_masuk(){
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
    public function _is_allow_pulang(){
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