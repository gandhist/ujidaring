@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><a href="{{ url('jadwal') }}" class="btn btn-md bg-purple"><i class="fa fa-arrow-left"></i></a>
        Dashboard Jadwal
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
            <br>
            <div class="row">
                {{-- instruktur --}}
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-blue">
                        <div class="inner">
                            <h3>{{$instruktur}}</h3>
                            <p>Instruktur</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person"></i>
                        </div>
                        <a href="{{ url('jadwal/instruktur', $data->id) }}" class="small-box-footer">Lihat <i
                                class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                {{-- end of instruktur --}}
                {{-- peserta --}}
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>{{$jumlahPeserta}}</h3>
                            <p>Peserta</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users" aria-hidden="true"></i>
                        </div>
                        <a href="{{ url('jadwal/peserta', $data->id) }}" class="small-box-footer">Lihat
                            <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>{{$jumlahSoalPg+$jumlahSoalEssay}}</h3>
                            <p>Ujian</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-file-text-o" aria-hidden="true"></i>
                        </div>
                        <a href="{{ url('jadwal/soal', $data->id) }}" class="small-box-footer">Lihat
                            <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- end of soal -->
                <!-- modul -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>{{$modul}}</h3>
                            <p>Modul</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-list-alt" aria-hidden="true"></i>
                        </div>
                        <a href="{{ url('instruktur/modul',$data->id) }}" class="small-box-footer">Lihat <i
                                class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- end of modul -->
                <!-- atur jadwal -->
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>{{$jumlahJadwal}}</h3>
                            <p>Jadwal & Quiz</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                        </div>
                        <a href="{{ url('jadwal/aturjadwal', $data->id) }}" class="small-box-footer">Lihat <i
                                class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- end of atur jadwal -->
                <!-- absen -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>{{$jumlahabsen}}</h3>
                            <p>Presensi</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-address-card" aria-hidden="true"></i>
                        </div>
                        <a href="{{ url('jadwal/absen', $data->id) }}" class="small-box-footer">Lihat
                            <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- end of absen -->
                <!-- makalah/pkl -->
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>
                                @if($data->f_pkl == "" )
                                0
                                @else
                                1
                                @endif
                            </h3>
                            <p>Makalah/PKL</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-film" aria-hidden="true"></i>
                        </div>
                        <a href="{{ route('pkl', $data->id) }}" class="small-box-footer">Lihat <i
                                class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- end of makalah/pkl -->
                {{-- tugas --}}
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-blue">
                        <div class="inner">
                            <h3>
                                @if($data->pdf_tugas == "" )
                                0
                                @else
                                1
                                @endif
                            </h3>
                            <p>Tugas</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                        </div>
                        <a target="_blank" href="{{ url('jadwal/tugas',$data->id) }}" class="small-box-footer">Lihat
                            <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- end of tugas -->
                <!-- evaluasi -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-blue">
                        <div class="inner">
                            <h3>{{$instruktur}}</h3>
                            <p>Evaluasi</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-star"></i>
                        </div>
                        <a href="{{ url('jadwal/evaluasi', $data->id) }}" class="small-box-footer">Lihat <i
                                class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- end of evaluasi -->
                @if($data->is_kelompok == "1" )
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>{{$jumlahkelompok}}</h3>
                            <p>Kelompok</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users" aria-hidden="true"></i>
                        </div>
                        <a href="{{url('jadwal/lihatkelompok/'.$data->id)}}" class="small-box-footer">Lihat
                            <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                @else
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>-</h3>
                            <p>Buat Kelompok</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users" aria-hidden="true"></i>
                        </div>
                        <a id="btnbuatklp" href="#" class="small-box-footer">Buat Kelompok
                            <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                @endif

                <div class="col-lg-12 col-xs-12" style="text-align:center">
                    <button onclick='tampilFoto("{{ asset("/$data->pdf_jadwal") }}","Jadwal")' type="button"
                        class="btn btn-block btn-danger btn-flat" style="font-size:16px">Klik Untuk Melihat
                        Jadwal</button>
                </div>
                <!-- ./col -->
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="box-body" style="background:#f7dddd">
                        <div class="table-responsive">
                            <table class="table no-margin">
                                <thead>
                                    <tr>
                                        <th style="text-align:left;padding: 6px;">Tanggal Mulai</th>
                                        <th style="text-align:left;padding: 6px;vertical-align: middle;">:
                                            {{ \Carbon\Carbon::parse($data->tgl_awal)->isoFormat("DD MMMM YYYY") }}</th>
                                        <th style="text-align:left;padding: 6px;">Jenis Usaha</th>
                                        <th style="text-align:left;padding: 6px;vertical-align: middle;"
                                            data-toggle="tooltip" data-placement="bottom" data-html="true"
                                            title="{{$data->jenis_usaha_r->nama_jns_usaha}}">:
                                            {{$data->jenis_usaha_r->kode_jns_usaha}}</th>
                                        <th style="text-align:left;padding: 6px;vertical-align: middle;">Bidang</th>
                                        <th style="text-align:left;padding: 6px;vertical-align: middle;"
                                            data-toggle="tooltip" data-placement="bottom" data-html="true"
                                            title="{{$data->bidang_r->nama_bidang}}">:
                                            {{$data->bidang_r->kode_bidang}}
                                        </th>

                                    </tr>
                                    <tr>
                                        <th style="text-align:left;padding: 6px;">Tanggal Selesai</th>
                                        <th style="text-align:left;padding: 6px;vertical-align: middle;">:
                                            {{ \Carbon\Carbon::parse($data->tgl_akhir)->isoFormat("DD MMMM YYYY") }}
                                        </th>
                                        <th style="text-align:left;padding: 6px;vertical-align: middle;">Bidang Srtf
                                            Alat</th>
                                        <th style="text-align:left;padding: 6px;vertical-align: middle;"
                                            data-toggle="tooltip" data-placement="bottom" data-html="true"
                                            title="{{$data->sertifikat_alat_r->nama_srtf_alat}}">:
                                            {{$data->sertifikat_alat_r->kode_srtf_alat}}
                                        </th>
                                        <th style="text-align:left;padding: 6px;vertical-align: middle;">TUK</th>
                                        <th style="text-align:left;padding: 6px;vertical-align: middle;">:
                                            {{$data->tuk}}
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-1">
                </div>
                <div class="col-md-4"> -->
                <!-- <form action="{{ route('jadwal.store') }}" id="" name="" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                        <tr>
                                            <input type="hidden" id="idJadwal" name="idJadwal" value="{{$data->id}}">
                                            <th style="width:5%"><span style="text-align:right;font-size: 22px;"
                                                    id="clock">00:00:00</span></th>
                                            <th style="text-align:right;padding: 6px;width:32%"><input maxlength="4"
                                                    id="durasi" name="durasi" type="text" class="form-control"
                                                    placeholder="Durasi Ujian(Menit)"></th>
                                            <th style="text-align:left;padding: 6px;"><button id="btnmulai"
                                                    type="button" class="btn btn-block btn-info btn-flat">Mulai
                                                    Ujian</button>
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </form> -->
                <!-- </div> -->
            </div>

        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

    <!-- modal konfirmasi -->
    <!-- <div class="modal fade" id="modal-konfirmasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <form action="{{ url('jadwal/kirimaccount') }}" class="form-horizontal" id="formDelete" name="formDelete"
            method="post" enctype="multipart/form-data">
            @method("DELETE")
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

    <!-- Modal Foto -->
    <div class="modal fade" id="modalFoto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" style="width: 95%;" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title" id="lampiranTitle"></h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12" style="text-align:center">
                            <img id="imgFoto" src="" alt="" width="100%">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>

            </div>
        </div>
    </div>
    <!-- end of modal lampiran -->

    <!-- Modal Buat Kelompok -->
    <div class="modal fade" id="modal_buat_kelompok" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <form class="form-horizontal" id="formkelompok" name="formkelompok" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="" name="idHapusData" id="idHapusData">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Buat Kelompok Otomatis</h4>
                        <b>Kelompok akan digenerate oleh sistem secara otomatis</b>
                    </div>
                    <div class="modal-body" id="konfirmasi-body">
                        <div class="box-body">
                            <div class="form-group">
                                <!-- <label for="exampleInputEmail1">*Masukkan Jumlah Kelompok</label> -->
                                <input type="hidden" name="idjadwal" id="idjadwal" value="{{$data->id}}">
                                <input maxlength="1" type="text" class="form-control" id="jumlahkelompok"
                                    name="jumlahkelompok" placeholder="Masukkan Jumlah Kelompok">
                                <span id="jumlahkelompok" class="help-block"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-danger" data-id=""
                            data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Kirim..."
                            id="btn-generate">Generate</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- end of modal kirim account peserta -->

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

        $('#btnbuatklp').on('click', function (e) {
            e.preventDefault();
            $('#modal_buat_kelompok').modal('show');
        });

        $('#btn-generate').on('click', function (e) {
            store();
        });

        function store() {
            var formData = new FormData($('#formkelompok')[0]);

            var url = "{{ url('bentukkelompok') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                type: 'POST',
                dataType: "JSON",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $.LoadingOverlay("show", {
                        image: "",
                        fontawesome: "fa fa-refresh fa-spin",
                        fontawesomeColor: "black",
                        fade: [5, 5],
                        background: "rgba(60, 60, 60, 0.4)"
                    });
                    // $("#btnSave").button('loading');
                },
                success: function (response) {
                    console.log(response);
                    if (response.status) {
                        Swal.fire({
                            title: response.message,
                            type: response.icon,
                            confirmButtonText: 'Ok',
                            confirmButtonColor: '#AAA'
                        }).then(function () {
                            if (response.icon == "success") {
                                window.location.href ="{{ url('jadwal/lihatkelompok/'.$data->id) }}";
                            }
                        });
                    }
                },
                error: function (xhr, status) {
                    var a = JSON.parse(xhr.responseText);
                    // console.log(a);
                    $(".textarea").css('border-color', 'rgb(118, 118, 118)');
                    $(".select2-selection").css('border-color', '#aaa');
                    $('.form-group').removeClass('has-error');
                    $('.help-block').text("");
                    $.each(a.errors, function (key, value) {
                        tipeinput = $('#' + key).attr("class");
                        tipeselect = "select2";
                        tipetextarea = "textarea";
                        if (tipeinput.indexOf(tipeselect) > -1) {
                            console.log("select2");
                            $("#" + key).parent().find(".select2-container").children()
                                .children().css(
                                    'border-color', '#a94442');
                            $('span[id^="' + key + '"]').text(value);
                        } else if (tipeinput.indexOf(tipetextarea) > -1) {
                            $("#" + key).css('border-color', '#a94442');
                            $('span[id^="' + key + '"]').text(value);
                        } else {
                            $('[name="' + key + '"]').parent().addClass(
                                'has-error'
                            );
                            if (!$('[name="' + key + '"]').is("select")) {
                                $('[name="' + key + '"]').next().text(
                                    value);
                            }
                        }
                        $('span[id^="' + key + '"]').show();
                    });
                },
                complete: function () {
                    $.LoadingOverlay("hide");
                    // $("#btnSave").button('reset');
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
