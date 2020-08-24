<?php

namespace App\Exports\Ujidaring;

use App\Models\Ujidaring\PesertaQuis;
use App\Models\Ujidaring\JadwalModul;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class PesertaQuisExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $idjadwal,$tglawal;

    public function __construct($idjadwal,$tglawal,$tglakhir)
    {
       $this->idjadwal = $idjadwal;
       $this->tglawal = $tglawal;
       $this->tglakhir = $tglakhir;
    }

    public function collection()
    {
        $idjadwalmodul = JadwalModul::select('id')->where('id_jadwal',$this->idjadwal)->get()->toArray();
        $datanilai = PesertaQuis::whereIn('id_jadwal_modul',$idjadwalmodul)->orderBy('created_at','desc');

        if(($this->tglawal != null || $this->tglawal != "" ) && ($this->tglakhir != null || $this->tglakhir != "")){
            $datanilai->whereBetween('created_at', [Carbon::createFromFormat('d/m/Y',$this->tglawal)->format('Y-m-d 00:00:00'), Carbon::createFromFormat('d/m/Y',$this->tglakhir)->format('Y-m-d 23:59:59')]);
        }

        $datanilai->get();
        $datanilai = $datanilai->get();

        return $datanilai;

    }

    public function map($data) : array {
        if(strtolower($data->tipe_quis)=='pre'){
            $x = count($data->jumlah_soal_pre_r);
        }else if(strtolower($data->tipe_quis)=='post'){
            $x = count($data->jumlah_soal_post_r);
        }else{
            $x = "Error";
        }
        return [
            $data->id,
            Carbon::parse($data->created_at)->isoFormat("DD MMMM YYYY"),
            $data->peserta_r->nik,
            $data->peserta_r->nama,
            $data->jadwal_modul_r->modul_r->modul,
            ucfirst($data->tipe_quis),
            $x,
            $data->benar,
            $data->salah,
        ] ;
    }

    public function headings(): array
    {
        return [
            'Id',
            'Tanggal',
            'Nik',
            'Nama',
            'Modul',
            'Tipe Quiz',
            'Jumlah Soal',
            'Benar',
            'Salah'
        ];
    }
}
