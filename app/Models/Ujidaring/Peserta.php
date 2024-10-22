<?php

namespace App\Models\UjiDaring;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Peserta extends Model
{
    //
    use SoftDeletes;
    protected $table = "uji_peserta";
    protected $guarded = ["id"];

    // relasi ke table user
    public function user_r(){
        return $this->belongsTo('App\Models\Ujidaring\User','user_id');
    }

    // relasi ke table jadwal
    public function jadwal_r(){
        return $this->belongsTo('App\Models\Ujidaring\JadwalModel','id_kelompok','id_klp_peserta');
    }

    // relasi ke jawaban pg
    public function jawaban_r(){
        return $this->hasMany('App\Models\Ujidaring\JawabanPeserta','id_peserta');
    }

    // relasi ke jawaban pg
    public function jawaban_essay_r(){
        return $this->hasMany('App\Models\Ujidaring\JawabanEssayPeserta','id_peserta');
    }

    // relasi ke jawaban evaluasi
    public function jawaban_eva_r(){
        return $this->hasMany('App\Models\Ujidaring\JawabanEvaluasi','id_peserta')->where('tanggal',\Carbon\Carbon::now()->isoFormat('YYYY-MM-DD'));
    }

    // relasi ke jawaban pg benar
    public function pg_benar_r(){
        return $this->hasMany('App\Models\Ujidaring\JawabanPeserta','id_peserta')->where("is_true","=","1");
    }

    // relasi ke jawaban pg benar
    public function pg_salah_r(){
        return $this->hasMany('App\Models\Ujidaring\JawabanPeserta','id_peserta')->where("is_true","=","0");
    }

    // relasi ke jawaban essay benar
    public function essay_benar_r(){
        return $this->hasMany('App\Models\Ujidaring\JawabanEssayPeserta','id_peserta')->where("is_true","=","1");
    }

    // relasi ke jawaban essay salah
    public function essay_salah_r(){
        return $this->hasMany('App\Models\Ujidaring\JawabanEssayPeserta','id_peserta')->where("is_true","=","0");
    }

    // relasi jawaban tugas
    public function jawaban_tugas(){
        return $this->belongsTo('App\Models\Ujidaring\JawabanTugas','id','id_peserta');
    }

    // relasi jawaban tugas
    public function jawaban_pkl_r(){
        return $this->belongsTo('App\Models\Ujidaring\JawabanPkl','id','id_peserta');
    }

    // relasi jawaban tugas
    public function jawaban_ppt_r(){
        return $this->belongsTo('App\Models\Ujidaring\JawabanPpt','id','id_peserta');
    }

    // relasi ke peserta quis
    public function peserta_quis_r(){
        return $this->hasMany('App\Models\Ujidaring\PesertaQuis','id_peserta');
    }

    // relasi ke table peserta kelompok
    public function kelompok(){
        return $this->belongsTo('App\Models\Ujidaring\KelompokPeserta','id','id_peserta');
    }


}
