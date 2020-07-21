<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PesertaQuis extends Model
{
    //
    use SoftDeletes;
    protected $table ="peserta_quis";
    protected $guarded = ['id'];
}
