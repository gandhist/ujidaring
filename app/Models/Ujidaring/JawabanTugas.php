<?php

namespace App\Models\UjiDaring;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JawabanTugas extends Model
{
    //
    use SoftDeletes;
    protected $table = "uji_jawaban_tugas_peserta";
    protected $guarded = ['id'];
}
