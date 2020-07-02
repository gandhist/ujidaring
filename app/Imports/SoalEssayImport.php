<?php

namespace App\Imports;

use App\SoalEssayModel;
use Maatwebsite\Excel\Concerns\ToModel;

class SoalEssayImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new SoalEssayModel([
            'kelompok_soal' => $row[1],
            'no_soal' => $row[2], 
            'soal' => $row[3],
            'jawaban' => $row[4], 
            'bobot' => $row[5], 
        ]);
    }
}
