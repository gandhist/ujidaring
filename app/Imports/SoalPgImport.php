<?php

namespace App\Imports;

use App\SoalPgModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SoalPgImport implements ToModel , WithStartRow
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
        return new SoalPgModel([
            'kelompok_soal' => $this->id,
            'no_soal' => $row[1], 
            'soal' => $row[2],
            'pg_a' => $row[3],
            'pg_b' => $row[4],
            'pg_c' => $row[5], 
            'pg_d' => $row[6], 
            'jawaban' => $row[7],    
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
    
}
