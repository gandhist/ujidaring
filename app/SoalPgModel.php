<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SoalPgModel extends Model
{
    //
    use SoftDeletes;
    protected $table = 'soal_pg';
    protected $guarded = ["id"];
}
