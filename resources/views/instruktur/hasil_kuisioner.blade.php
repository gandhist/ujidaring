<?php error_reporting(E_ALL ^ E_DEPRECATED); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Kuisioner</title>
    
    <style>
        @page {
            margin: 0;
        }

        .header{
            padding-top: 5px;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        
        .paper {
            width: 700px;
            height: 700px;
            margin: 20px auto;
            background-color: white;
            box-shadow: 0px 0px 5px 0px #888;
            padding: 5px;    
        }
    
        table {
            table-layout: fixed;
        }
    
        td {
            vertical-align: top;
            overflow: hidden;
        }
    
        body {
            padding: 20px;
            padding-left: 40px;
            padding-right: 50px;
            padding-top: 40px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 14px;
           
    
        p {
            line-height: 150%;
        }
    
        td {
            height: 15px;
        }

        .flex-container {
            display: flex;
            flex-wrap: nowrap;
            background-color: DodgerBlue;
        }

        .flex-container > div {
            background-color: #f1f1f1;
            width: 100px;
            margin: 10px;
            text-align: center;
            line-height: 75px;
            font-size: 30px;
        }

        .tableNilai td {
            border: 1px solid black;
            text-align: center;
        }
        .tableNilai th {
            border: 1px solid black;
        }

        .tableNilai {
            border-collapse: collapse;
            width: 30%;
        }

        .detailPelatihan {
            border-collapse: collapse;
            width: 50%;
        }

        .tableKuisioner td {
            border: 1px solid black;
            text-align: center;
        }
        .tableKuisioner th {
            border: 1px solid black;
        }

        .tableKuisioner {
            border-collapse: collapse;
            width: 100%;
        }
        


       
    </style>
</head>
<body >
    <table style="table-layout: fixed;" width=540 border="0">
        <tr>
            <td style="width: 30%">                
                <img height="100px" src="skim.png">
            </td>
            <th style="text-align:left;">
                <p style="font-size: 18px; font-weight: bold;">
                    LEMBAR EVALUASI INSTRUKTUR
                </p>
            </th>
            <td style="width: 20%; padding:10px">
                <p style="border: 3px solid; padding: 10px; font-size: 26px; font-weight: bold; text-align:center" > 
                            1
                        </p>
            </td>
        </tr>
    </table>
    <p>Keterangan :</p>
    <p style="text-align:justify">
        Dalam rangka meningkatkan mutu penyelenggaraan pelatihan di masa mendatang, serta pengukuran kepuasan pelanggan, maka kami mohon kesediaan Anda untuk mengisi kuisioner ini dengan memberikan warna pada kotak yang sesuai. penilaian adan di jamin kerahasiaannya.
    </p>
    <table class="tableNilai" style="table-layout: fixed; border: 1px solid black;" width=540 border="0">
        <thead style="background-color: #7397d1;">
            <tr>
                <th>NILAI</th>
                <th>KETERANGAN</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Buruk</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Kurang</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Cukup</td>
            </tr>
            <tr>
                <td>4</td>
                <td>Bagus</td>
            </tr>
            <tr>
                <td>5</td>
                <td>Memuaskan</td>
            </tr>
        </tbody>
    </table>
    <br>
    {{-- nama pelatihan --}}
    <table class="detailPelatihan" style="table-layout: fixed;" width=540 border="0">
            <tr>
                <td>Nama Pelatihan</td>
                <td align="right" width='2%'>:</td>
                <td style="padding-left:5px" width='65%'>{{ $jadwal->sertifikat_alat_r->nama_srtf_alat }}</td>
            </tr>
            <tr>
                <td>Tanggal Pelatihan</td>
                <td align="right">:</td>
                <td style="padding-left:5px">{{ \Carbon\Carbon::parse($tanggal)->isoFormat('DD MMMM YYYY') }}</td>
            </tr>
            <tr>
                <td>Nama Peserta</td>
                <td align="right">:</td>
                <td style="padding-left:5px">{{ $peserta->nama }}</td>
            </tr>
            <tr>
                <td>Nama Instruktur</td>
                <td align="right">:</td>
                <td style="padding-left:5px">{{ $instruktur->nama }}</td>
            </tr>
            <tr>
                <td>Materi</td>
                <td align="right">:</td>
                <td style="padding-left:5px">
                    @foreach($modul as $key)
                    - {{ $key->jadwal_modul_r->modul_r->modul }} <br>
                    @endforeach
                </td>
            </tr>
    </table>
    <br>
    {{-- table penilaian --}}
    <table class="tableKuisioner" style="table-layout: fixed; border: 1px solid black;" width=540 border="0">
        <thead style="background-color: #7397d1;">
            <tr>
                <th colspan="2">MATERI PELATIHAN</th>
                <th colspan="5">NILAI</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inst as $key)
            <tr>
                <td  width="3%" >{{ $loop->iteration }}</td>
                <td  width="80%" style="text-align: left" >{{ $key->soal_r->materi }}</td>
                @if($key->nilai == 1)
                    <td style="background-color:#7397d1">1</td>
                @else
                    <td>1</td>
                @endif
                @if($key->nilai == 2)
                    <td style="background-color:#7397d1">2</td>
                @else
                    <td>2</td>
                @endif
                @if($key->nilai == 3)
                    <td style="background-color:#7397d1">3</td>
                @else
                    <td>3</td>
                @endif
                @if($key->nilai == 4)
                    <td style="background-color:#7397d1">4</td>
                @else
                    <td>4</td>
                @endif
                @if($key->nilai == 5)
                    <td style="background-color:#7397d1">5</td>
                @else
                    <td>5</td>
                @endif
            </tr>
            @endforeach
            
        </tbody>
    </table>
</body>
</html>