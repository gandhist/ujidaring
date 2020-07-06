<?php

namespace App\Imports;

use App\Peserta;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;

class PesertaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Peserta([
            'nama' => $row[1],
            'nik' => $row[2],
            'tmp_lahir' => $row[3],
            'tgl_lahir' => Carbon::createFromFormat('d-m-Y', $row[4])->toDateString(),
            'no_hp' => $row[5],    
        ]);
    }
}
