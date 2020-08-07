<?php

namespace App\Exports;

use App\PesertaQuis;
use Maatwebsite\Excel\Concerns\FromCollection;

class PesertaQuisExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return PesertaQuis::all();
    }
}
