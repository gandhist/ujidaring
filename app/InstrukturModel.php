<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstrukturModel extends Model
{
        //
        use SoftDeletes;
        protected $table = "instruktur";
        protected $guarded = ["id"];
}
