<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SoalEssayModel extends Model
{
    //
    use SoftDeletes;
    protected $table = "soal_essay";
    protected $guarded = ["id"];
}
