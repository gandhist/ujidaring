<?php

namespace App\Imports;

use App\Peserta;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PesertaImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    * @return int
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

    public function startRow(): int
    {
        return 2;
    }
}
