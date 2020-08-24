<?php

namespace App\Models\UjiDaring;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterDaftarBank extends Model
{
    //
    use SoftDeletes;
    protected $table = "ms_daf_bank";
    protected $guarded = ["id"];
}
