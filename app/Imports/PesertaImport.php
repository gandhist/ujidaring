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
            'id_kelompok' => $row[2], 
            'nik' => $row[3],
            'tmp_lahir' => $row[4],
            'tgl_lahir' => Carbon::createFromFormat('d-m-Y', $row[5])->toDateString(),
            'no_hp' => $row[6],    
        ]);
    }
}
