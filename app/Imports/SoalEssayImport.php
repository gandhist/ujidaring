<?php

namespace App\Imports;

use App\SoalEssayModel;
use Maatwebsite\Excel\Concerns\ToModel;

class SoalEssayImport implements ToModel
{
    protected $id;

    function __construct($id) {
        $this->id = $id;
    }
    
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new SoalEssayModel([
            'kelompok_soal' => $this->id,
            'no_soal' => $row[1], 
            'soal' => $row[2],
            'jawaban' => $row[3], 
            'bobot' => $row[4], 
        ]);
    }
}
