<?php

namespace App\Imports\Ujidaring;

use App\Models\Ujidaring\SoalEssayModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SoalEssayImport implements ToModel , WithStartRow
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

    public function startRow(): int
    {
        return 2;
    }
}
