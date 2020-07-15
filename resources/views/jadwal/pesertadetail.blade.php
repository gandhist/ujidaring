@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><a href="{{ url('jadwal/peserta/'.$data->id) }}" class="btn btn-md bg-purple"><i class="fa fa-caret-left"></i>
            Kembali</a> Detail Peserta
        {{-- <small>it all starts here</small>  --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#">Tampil</a></li>
    </ol>


</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box box-content">
        <div class="box-body">
            @if(session()->get('message'))
            <div class="alert alert-success alert-dismissible fade in"> {{ session()->get('message') }}
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            </div>
            @endif
            <!-- MultiStep Form -->
            <div class="row">
                <div class="col-md-7">
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table no-margin">
                                <thead>
                                    <tr>
                                        <th style="text-align:left;padding: 6px;">Tanggal Mulai</th>
                                        <td style="text-align:left;padding: 6px;vertical-align: middle;">:
                                            {{ \Carbon\Carbon::parse($data->tgl_awal)->isoFormat("DD MMMM YYYY") }}</td>
                                        <th style="text-align:left;padding: 6px;">Jenis Usaha</th>
                                        <td style="text-align:left;padding: 6px;vertical-align: middle;">:
                                            {{$data->jenis_usaha_r->nama_jns_usaha}}</td>
                                        <th style="text-align:left;padding: 6px;vertical-align: middle;">Bidang</th>
                                        <td style="text-align:left;padding: 6px;vertical-align: middle;">:
                                            {{$data->bidang_r->nama_bidang}}
                                        </td>
                                        <th style="text-align:left;padding: 6px;vertical-align: middle;">TUK</th>
                                        <td style="text-align:left;padding: 6px;vertical-align: middle;">:
                                            {{$data->tuk}}
                                        </td>

                                    </tr>
                                    <tr>
                                        <th style="text-align:left;padding: 6px;">Tanggal Selesai</th>
                                        <td style="text-align:left;padding: 6px;vertical-align: middle;">:
                                            {{ \Carbon\Carbon::parse($data->tgl_akhir)->isoFormat("DD MMMM YYYY") }}
                                        </td>
                                        <th style="text-align:left;padding: 6px;vertical-align: middle;">NIK
                                        </th>
                                        <td style="text-align:left;padding: 6px;vertical-align: middle;">:
                                            {{$Peserta->nik}}</td>

                                        <th style="text-align:left;padding: 6px;vertical-align: middle;">Nama
                                        </th>
                                        <td style="text-align:left;padding: 6px;vertical-align: middle;">:
                                            {{$Peserta->nama}}</td>

                                        <th style="text-align:left;padding: 6px;vertical-align: middle;">Tmp, Tgl_Lahir
                                        </th>
                                        <td style="text-align:left;padding: 6px;vertical-align: middle;">:
                                            {{$Peserta->tmp_lahir}},
                                            {{ \Carbon\Carbon::parse($Peserta->tgl_lahir)->isoFormat("DD MMMM YYYY") }}
                                        </td>
                                    </tr>

                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-3">
                </div>
                <div class="col-md-2">

                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table no-margin">
                                <thead>
                                    <tr>
                                        <th style="text-align:left;padding-bottom:0px;padding-top:0px"><button
                                                id="btnkirim" type="button"
                                                class="btn btn-block btn-info btn-flat">Kirim User Account</button>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th style="text-align:left;padding-bottom:0px;padding-top:2px"><button
                                                id="btndetail" type="button"
                                                class="btn btn-block btn-warning btn-flat">Detail</button>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                </div> -->
                <div class="col-md-12">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#hasilujian">Hasil Ujian</a></li>
                        <li><a data-toggle="tab" href="#nilaiharian">Nilai Harian</a></li>
                        <li><a data-toggle="tab" href="#quisioner">Quisioner</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="hasilujian" class="tab-pane fade in active">
                            <div class="box box-info">
                                <div class="box-header with-border" style="text-align:center">
                                    <!-- <h3 class="box-title">Upload Soal</h3> -->
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                                class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                                class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <table id="custom-table"
                                        class="table table-striped table-bordered dataTable customTable">
                                        <thead>
                                            <tr>
                                                <th>Jumlah Soal PG</th>
                                                <th>Pg Benar</th>
                                                <th>Pg Salah</th>
                                                <th>Jumlah Soal Essay</th>
                                                <th>Essay Benar</th>
                                                <th>Essay Salah</th>
                                                <th>Nilai Essay</th>
                                                <!-- <th>Pg Benar</th>
                                <th>Pg Salah</th>
                                <th>Essay Benar</th>
                                <th>Essay Salah</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr>
                                                <td style="width:7%">{{$jumlahSoalPg}}</td>
                                                <td style="width:5%">{{count($Peserta->pg_benar_r)}}</td>
                                                <td style="width:5%">{{count($Peserta->pg_salah_r)}}</td>
                                                <td style="width:7%">{{$jumlahSoalEssay}}</td>
                                                <td style="width:5%">{{count($Peserta->essay_benar_r)}}</td>
                                                <td style="width:5%">{{count($Peserta->essay_salah_r)}}</td>
                                                @if($Peserta->jadwal_r->akhir_ujian == "" )
                                                <td style="text-align:center;width:8%"><button type="button"
                                                        class="btn btn-sm btn-warning disabled">Belum Ujian</button>
                                                </td>
                                                @elseif( \Carbon\Carbon::now()->toDateTimeString() >
                                                $Peserta->jadwal_r->awal_ujian &&
                                                \Carbon\Carbon::now()->toDateTimeString() < $Peserta->
                                                    jadwal_r->akhir_ujian )
                                                    <td style="text-align:center;width:8%"><button type="button"
                                                            class="btn btn-sm btn-danger disabled">Sedang Ujian</button>
                                                    </td>

                                                    @elseif( count($Peserta->essay_benar_r) == 0 &&
                                                    count($Peserta->essay_salah_r) == 0
                                                    )

                                                    <td style="text-align:center;width:8%"><button type="button"
                                                            class="btn btn-sm bg-olive btn-flat" data-toggle="modal"
                                                            data-target="#modal_{{$Peserta->id}}">Nilai</button></td>
                                                    @else
                                                    <td style="text-align:center;width:8%"><button type="button"
                                                            class="btn btn-sm btn-warning" data-toggle="modal"
                                                            data-target="#modal_jawab_{{$Peserta->id}}">Sudah
                                                            dinilai</button></td>
                                                    @endif

                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="nilaiharian" class="tab-pane fade in active">
                            <div class="box box-info">
                                <div class="box-header with-border" style="text-align:center">
                                    <!-- <h3 class="box-title">Upload Soal</h3> -->
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                                class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                                class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <table id="custom-table"
                                        class="table table-striped table-bordered dataTable customTable">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Modul</th>
                                                <th>Pre Quiz Benar</th>
                                                <th>Pre Quiz Salah</th>
                                                <th>Post Quiz Benar</th>
                                                <th>Post Quiz Salah</th>
                                                <th>Tugas Mandiri</th>
                                                <th>Total Nilai</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $a = '';
                                            @endphp
                                            @foreach($modul_rundown as $key)
                                            <tr>
                                                @if($a==$key->jadwal_rundown_r->tanggal)

                                                @else
                                                @php
                                                $rowspan =
                                                DB::table('modul_rundown')->where('id_rundown','=',$key->id_rundown)->where('deleted_by','=',null)->count();
                                                @endphp
                                                <td style="width:5%;text-align:center" rowspan="{{$rowspan}}">
                                                    {{ \Carbon\Carbon::parse($key->jadwal_rundown_r->tanggal)->isoFormat("DD MMMM YYYY") }}
                                                </td>
                                                @endif
                                                <td>{{$key->jadwal_modul_r->modul_r->modul}}</td>
                                                @php
                                                $prequizbenar =
                                                DB::table('jawaban_peserta_pg_pre')->where('id_jadwal_modul','=',$key->jadwal_modul_r->id)->where('is_true','=',1)->where('id_peserta','=',$Peserta->id)->where('deleted_by','=',null)->count();
                                                $prequizsalah =
                                                DB::table('jawaban_peserta_pg_pre')->where('id_jadwal_modul','=',$key->jadwal_modul_r->id)->where('is_true','=',0)->where('id_peserta','=',$Peserta->id)->where('deleted_by','=',null)->count();
                                                $postquizbenar =
                                                DB::table('jawaban_peserta_pg_post')->where('id_jadwal_modul','=',$key->jadwal_modul_r->id)->where('is_true','=',1)->where('id_peserta','=',$Peserta->id)->where('deleted_by','=',null)->count();
                                                $postquizsalah =
                                                DB::table('jawaban_peserta_pg_post')->where('id_jadwal_modul','=',$key->jadwal_modul_r->id)->where('is_true','=',0)->where('id_peserta','=',$Peserta->id)->where('deleted_by','=',null)->count();

                                                $nilaiakhir = ($prequizbenar+$postquizbenar)*10/2;
                                                @endphp
                                                <td style="width:10%;text-align:right">{{$prequizbenar}}</td>
                                                <td style="width:10%;text-align:right">{{$prequizsalah}}</td>
                                                <td style="width:10%;text-align:right">{{$postquizbenar}}</td>
                                                <td style="width:10%;text-align:right">{{$postquizsalah}}</td>
                                                <td style="width:10%;text-align:center">
                                                    @php
                                                    $jumlahtm =
                                                    DB::table('jawaban_tm')->where('id_jadwal_modul','=',$key->jadwal_modul_r->id)->where('id_peserta','=',$Peserta->id)->where('deleted_by','=',null)->count();
                                                    @endphp

                                                    @if($jumlahtm>0)
                                                    <button type="button" class="btn btn-sm btn-success btnLihatTm"
                                                        id_jadwal_modul="{{$key->jadwal_modul_r->id}}"
                                                        id_peserta="{{$Peserta->id}}">Lihat</button>
                                                    @else
                                                    <button type="button" class="btn btn-sm btn-danger">Tidak
                                                        Ada</button>
                                                    @endif
                                                </td>
                                                <td style="width:7%;text-align:right"><b>
                                                        @if($nilaiakhir < 60 && $jumlahtm>0)
                                                            60*
                                                            @elseif($nilaiakhir>=60)
                                                            {{$nilaiakhir}}
                                                            @else
                                                            Tidak Lulus
                                                            @endif
                                                    </b></td>
                                                @php
                                                $a = $key->jadwal_rundown_r->tanggal;
                                                @endphp
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="quisioner" class="tab-pane fade in active">
                            <div class="box box-info">
                                <div class="box-header with-border" style="text-align:center">
                                    <!-- <h3 class="box-title">Upload Soal</h3> -->
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                                class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                                class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <table id="custom-table"
                                        class="table table-striped table-bordered dataTable customTable">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>NIK</th>
                                                <th>Nama</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($jawaban_evaluasi as $key)
                                            <tr>
                                                <td style="width:1%">{{$loop->iteration}}</td>
                                                <td style="width:5%;text-align:center">
                                                    {{ \Carbon\Carbon::parse($key->tanggal)->isoFormat("DD MMMM YYYY") }}
                                                </td>
                                                <td style="width:40%">{{$key->instruktur_r->nik}}</td>
                                                <td>{{$key->instruktur_r->nama}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- /.MultiStep Form -->

            <!-- Modal Penilaian -->

            <div class="modal fade" id="modal_{{$Peserta->id}}" role="dialog">
                <div class="modal-dialog modal-lg" style="width:1500px">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header" style="text-align:left;background:#3c8dbc;color:white">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><b>{{$Peserta->nama}}</b></h4>
                        </div>
                        <div class="modal-body">
                            <div class="box">
                                <form action="{{ route('penilaian.update', $Peserta->id ) }}" class="form-horizontal"
                                    id="formAdd" name="formAdd" method="post" enctype="multipart/form-data">
                                    @method("PATCH")
                                    @csrf
                                    <div class="box-body no-padding">
                                        <br>
                                        <table class="table table-condensed" id="tableModalDetailAhli">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Soal</th>
                                                    <th>Jawaban Peserta</th>
                                                    <th>Jawaban Sebenarnya</th>
                                                    <th>Bobot</th>
                                                    <th>Ceklis jika sesuai</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <input type="hidden" name="jumlah_jawaban_{{$Peserta->id}}"
                                                    value="{{count($Peserta->jawaban_essay_r)}}">
                                                @foreach($Peserta->jawaban_essay_r as $jawaban)
                                                <tr>
                                                    <input type="hidden"
                                                        name="{{$Peserta->id}}_id_jawaban_{{ $loop->iteration }}"
                                                        value="{{ $jawaban->id }}">
                                                    <td style="width:1%">{{ $loop->iteration }}</td>
                                                    <td><textarea style="width: 100%;resize: none;" readonly name=""
                                                            id="" rows="5">{{ $jawaban->soal_r->soal }}</textarea></td>
                                                    <td><textarea style="width: 100%;resize: none;" readonly name=""
                                                            id="" rows="5">{{ $jawaban->jawaban }}</textarea></td>
                                                    <td><textarea style="width: 100%;resize: none;" readonly name=""
                                                            id="" rows="5">{{ $jawaban->soal_r->jawaban }}</textarea>
                                                    </td>
                                                    <td style="width:2%"><input
                                                            name="{{$Peserta->id}}_bobot_{{ $loop->iteration }}"
                                                            type="text" maxlength="2" class="Inputbobot" required></td>
                                                    <td style="width:10%;text-align:center"><input
                                                            name="{{$Peserta->id}}_istrue_{{ $loop->iteration }}"
                                                            type="checkbox"></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="box-footer">
                                        <div class="row">
                                            <div class="col-sm-6" style="text-align:right">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Batal</button>
                                            </div>
                                            <div class="col-sm-6" style="text-align:left">
                                                <button id="btnUpdateNilai" type="submit" class="btn btn-md btn-danger">
                                                    <i class="fa fa-save"></i>
                                                    Simpan Nilai</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- End -->
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal fade" id="modal_jawab_{{$Peserta->id}}" role="dialog">
                <div class="modal-dialog modal-lg" style="width:1500px">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header" style="text-align:left;background:#3c8dbc;color:white">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><b>{{$Peserta->nama}}</b></h4>
                        </div>
                        <div class="modal-body">
                            <div class="box">
                                <form action="{{ route('penilaian.update', $Peserta->id ) }}" class="form-horizontal"
                                    id="formAdd" name="formAdd" method="post" enctype="multipart/form-data">
                                    @method("PATCH")
                                    @csrf
                                    <div class="box-body no-padding">
                                        <br>
                                        <table class="table table-condensed" id="tableModalDetailAhli">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Soal</th>
                                                    <th>Jawaban Peserta</th>
                                                    <th>Jawaban Sebenarnya</th>
                                                    <th>Bobot</th>
                                                    <th>Sesuai/Tidak Sesuai</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <input type="hidden" name="jumlah_jawaban_{{$Peserta->id}}"
                                                    value="{{count($Peserta->jawaban_essay_r)}}">
                                                @foreach($Peserta->jawaban_essay_r as $jawaban)
                                                <tr>
                                                    <input type="hidden"
                                                        name="{{$Peserta->id}}_id_jawaban_{{ $loop->iteration }}"
                                                        value="{{ $jawaban->id }}">
                                                    <td style="width:1%">{{ $loop->iteration }}</td>
                                                    <td><textarea style="width: 100%;resize: none;" readonly name=""
                                                            id="" rows="5">{{ $jawaban->soal_r->soal }}</textarea></td>
                                                    <td><textarea style="width: 100%;resize: none;" readonly name=""
                                                            id="" rows="5">{{ $jawaban->jawaban }}</textarea></td>
                                                    <td><textarea style="width: 100%;resize: none;" readonly name=""
                                                            id="" rows="5">{{ $jawaban->soal_r->jawaban }}</textarea>
                                                    </td>
                                                    <td style="width:2%"><input
                                                            name="{{$Peserta->id}}_bobot_{{ $loop->iteration }}"
                                                            type="text" maxlength="2" class="Inputbobot"
                                                            value="{{ $jawaban->nilai }}" readonly></td>
                                                    <td style="width:10%;text-align:center"><span><i
                                                                class="fa {{ $jawaban->is_true==1 ? 'fa-check' : 'fa-times' }} "
                                                                aria-hidden="true"></i></span></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>


                                </form>
                            </div>
                            <!-- End -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>
            <!-- End -->

            <!-- Modal TM -->
            <div class="modal fade" id="modal_tm" role="dialog">
                <div class="modal-dialog modal-lg" style="width:1500px">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header" style="text-align:left;background:#3c8dbc;color:white">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><b id="title-modal"></b></h4>
                        </div>
                        <div class="modal-body">
                            <div class="box">
                                <div class="box-body no-padding">
                                    <br>
                                    <table class="table table-condensed tableModalDetail" id="tableModalTm">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Soal</th>
                                                <th>Jawaban</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End -->

        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
    <!-- modal konfirmasi -->
    <!-- <div class="modal fade" id="modal-konfirmasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <form action="{{ url('jadwal/kirimaccount/peserta') }}" class="form-horizontal" id="formDelete"
            name="formDelete" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="" name="idHapusData" id="idHapusData">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Konfirmasi</h4>
                    </div>
                    <div class="modal-body" id="konfirmasi-body">
                        Apakah anda ingin mengirim account peserta?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
                        <button type="submit" class="btn btn-danger" data-id=""
                            data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Kirim..."
                            id="confirm-delete">Ya</button>
                    </div>
                </div>
            </div>
        </form>
    </div> -->
    <!-- end of modal konfirmais -->

</section>
<!-- /.content -->

@endsection

@push('script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
<script type="text/javascript">
    $(function () {

        var dt = $('#custom-table').DataTable({
            "lengthMenu": [
                [10, 20, 50],
                [10, 20, 50]
            ],
            "scrollX": true,
            "scrollY": $(window).height() - 255,
            "scrollCollapse": true,
            "bPaginate": false,
            "searching": false,
            "autoWidth": false,
            "ordering": false,
            "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "targets": [0, 1]
            }],
            "aaSorting": []
        });

        dt.on('order.dt search.dt', function () {

        }).draw();

        // Kunci Input NIK Hanya Angka
        $('.Inputbobot').on('input blur paste', function () {
            $(this).val($(this).val().replace(/\D/g, ''))
        });

        // Show Modal Penilaian
        $('.btnnilai').on('click', function () {
            $('#modaldetailAhli').modal('show');
        });

        // Show Modal TM
        $('.btnLihatTm').on('click', function () {
            id_jadwal_modul = $(this).attr("id_jadwal_modul");
            id_peserta = $(this).attr("id_peserta");
            lihatTm(id_jadwal_modul, id_peserta);
            // $('#modaldetailAhli').modal('show');
        });

        // Fungsi Lihat TM
        function lihatTm(id_jadwal_modul, id_peserta) {
            var url = "{{ url('jadwal/peserta/tm') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    id_jadwal_modul: id_jadwal_modul,
                    id_peserta: id_peserta
                },
                success: function (data) {
                    console.log(data);
                    $('#tableModalTm > tbody').html('');
                    if (data.length > 0) {
                        $("#title-modal").text(data[0]['jadwal_modul_r']['modul_r'][
                            'modul'
                        ]);
                        for (index = 0; index < data.length; index++) {
                            $('#tableModalTm > tbody:last').append(`
                            <tr>
                                <td style='width:1%;text-align:center'>
                                    ` + (index + 1) + `
                                </td>
                                <td style='width:40%;text-align:left'>
                                    ` + data[index]['soal'] + `
                                </td>
                                <td style='text-align:left;width:59%'>
                                    ` + data[index]['jawaban'] + `
                                </td>
                            </tr>`);
                        }
                        $('#modal_tm').modal('show');
                    } else {
                        alert('Peserta Belum Mengerjakan Tugas Mandiri');
                    }
                },
                error: function (xhr, status) {
                    alert('Error');
                }
            });
        }


    });

    $('.datepicker').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true
    });

</script>
@endpush
