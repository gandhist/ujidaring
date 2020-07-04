<?php

namespace App\Imports;

use App\SoalPgModel;
use Maatwebsite\Excel\Concerns\ToModel;

class SoalPgImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new SoalPgModel([
            'kelompok_soal' => $row[1],
            'no_soal' => $row[2], 
            'soal' => $row[3],
            'pg_a' => $row[4],
            'pg_b' => $row[5],
            'pg_c' => $row[6], 
            'pg_d' => $row[7], 
            'jawaban' => $row[8],    
        ]);
    }
}