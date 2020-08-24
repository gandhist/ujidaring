<?php

namespace App\Models\UjiDaring;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SoalEssayModel extends Model
{
    //
    use SoftDeletes;
    protected $table = "uji_soal_essay";
    protected $guarded = ["id"];
}
