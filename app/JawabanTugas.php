<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JawabanTugas extends Model
{
    //
    use SoftDeletes;
    protected $table = "jawaban_tugas_peserta";
    protected $guarded = ['id'];
}
