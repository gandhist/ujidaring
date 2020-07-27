@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><a href="{{ url('jadwal/'.$data->id.'/dashboard') }}" class="btn btn-md bg-purple"><i
                class="fa fa-arrow-left"></i></a> Peserta
        {{-- <small>it all starts here</small>  --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#">Peserta</a></li>
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
                                        <td style="text-align:left;padding: 6px;vertical-align: middle;"
                                            data-toggle="tooltip" data-placement="bottom" data-html="true"
                                            title="{{$data->jenis_usaha_r->nama_jns_usaha}}">:
                                            {{$data->jenis_usaha_r->kode_jns_usaha}}</td>
                                        <th style="text-align:left;padding: 6px;vertical-align: middle;">Bidang</th>
                                        <td style="text-align:left;padding: 6px;vertical-align: middle;"
                                            data-toggle="tooltip" data-placement="bottom" data-html="true"
                                            title="{{$data->bidang_r->nama_bidang}}">:
                                            {{$data->bidang_r->kode_bidang}}
                                        </td>

                                    </tr>
                                    <tr>
                                        <th style="text-align:left;padding: 6px;">Tanggal Selesai</th>
                                        <td style="text-align:left;padding: 6px;vertical-align: middle;">:
                                            {{ \Carbon\Carbon::parse($data->tgl_akhir)->isoFormat("DD MMMM YYYY") }}
                                        </td>
                                        <th style="text-align:left;padding: 6px;vertical-align: middle;">Bidang Srtf
                                            Alat
                                        </th>
                                        <td style="text-align:left;padding: 6px;vertical-align: middle;"
                                            data-toggle="tooltip" data-placement="bottom" data-html="true"
                                            title="{{$data->sertifikat_alat_r->nama_srtf_alat}}">:
                                            {{$data->sertifikat_alat_r->kode_srtf_alat}}</td>
                                        <th style="text-align:left;padding: 6px;vertical-align: middle;">TUK</th>
                                        <td style="text-align:left;padding: 6px;vertical-align: middle;">:
                                            {{$data->tuk}}
                                        </td>

                                        <!-- <th style="text-align:left;padding: 6px;vertical-align: middle;">Jml Soal Pg
                                        </th>
                                        <td style="text-align:left;padding: 6px;vertical-align: middle;">:
                                            {{$jumlahSoalPg}} Soal</td>

                                        <th style="text-align:left;padding: 6px;vertical-align: middle;">Jml Soal Essay
                                        </th>
                                        <td style="text-align:left;padding: 6px;vertical-align: middle;">:
                                            {{$jumlahSoalEssay}} Soal</td> -->
                                    </tr>

                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                </div>
                <div class="col-md-2">

                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table no-margin">
                                <thead>
                                    <tr>
                                        <td style="text-align:left;padding-bottom:0px;padding-top:0px">
                                            <button id="btnkirim" type="button"
                                                class="btn btn-block btn-primary btn-flat">Kirim User Account</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:left;padding-bottom:0px;padding-top:2px">
                                            <button id="btndetail" type="button"
                                                class="btn btn-block btn-warning btn-flat">Lihat Detail</button>
                                        </td>
                                        <!-- <td style="text-align:left;padding-bottom:0px;padding-top:2px">
                                            @if($data->is_kelompok == "1" )
                                            <a href="{{url('jadwal/lihatkelompok/'.$data->id)}}" id="btnlihatklp"
                                                type="button" class="btn btn-block btn-warning btn-flat">Lihat
                                                Kelompok</a>
                                            @else
                                            <button id="btnbuatklp" type="button"
                                                class="btn btn-block btn-primary btn-flat">Buat Kelompok</button>
                                            @endif
                                        </td> -->
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="col-md-12">
                    <!-- <h3 style="margin-top: 0px;text-align: left;">Daftar Peserta</h3> -->
                    <table id="custom-table" class="table table-striped table-bordered dataTable customTable">
                        <thead>
                            <tr>
                                <th><i class="fa fa-check-square-o"></i></th>
                                <th>No</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Tempat Lahir</th>
                                <th>Tanggal Lahir</th>
                                <th>No Hp</th>
                                <!-- <th>Pg Benar</th>
                                <th>Pg Salah</th>
                                <th>Essay Benar</th>
                                <th>Essay Salah</th>
                                <th>Nilai Essay</th> -->
                                <!-- <th>Pg Benar</th>
                                <th>Pg Salah</th>
                                <th>Essay Benar</th>
                                <th>Essay Salah</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($Peserta as $key)
                            <tr>
                                <td style='width:1%'><input type="checkbox" data-id="{{ $key->id }}" class="selection"
                                        id="selection[]" name="selection[]"></td>
                                <td style="width:1%"></td>
                                <td style="width:30%">{{ $key->nik }}</td>
                                <td>{{ $key->nama }}</td>
                                <td style="text-align:left;width:10%">{{ $key->tmp_lahir }}</td>
                                <td style="text-align:right;width:10%">
                                    {{ \Carbon\Carbon::parse($key->tgl_lahir)->isoFormat("DD MMMM YYYY") }}</td>
                                <td style="text-align:center;width:8%">{{ $key->no_hp }}</td>
                                <!-- <td style="width:7%">{{count($key->pg_benar_r)}}</td>
                                <td style="width:7%">{{count($key->pg_salah_r)}}</td>
                                <td style="width:8%">{{count($key->essay_benar_r)}}</td>
                                <td style="width:8%">{{count($key->essay_salah_r)}}</td>
                                @if($key->jadwal_r->akhir_ujian == "" )
                                <td style="text-align:center;width:8%"><button type="button"
                                        class="btn btn-sm btn-warning disabled">Belum Ujian</button></td>
                                @elseif( \Carbon\Carbon::now()->toDateTimeString() > $key->jadwal_r->awal_ujian &&
                                \Carbon\Carbon::now()->toDateTimeString() < $key->jadwal_r->akhir_ujian )
                                    <td style="text-align:center;width:8%"><button type="button"
                                            class="btn btn-sm btn-danger disabled">Sedang Ujian</button></td>

                                    @elseif( count($key->essay_benar_r) == 0 && count($key->essay_salah_r) == 0 )

                                    <td style="text-align:center;width:8%"><button type="button"
                                            class="btn btn-sm bg-olive btn-flat" data-toggle="modal"
                                            data-target="#modal_{{$key->id}}">Nilai</button></td>
                                    @else
                                    <td style="text-align:center;width:8%"><button type="button"
                                            class="btn btn-sm btn-warning" data-toggle="modal"
                                            data-target="#modal_jawab_{{$key->id}}">Sudah
                                            dinilai</button></td>
                                    @endif -->
                                <!-- <td style="width:7%">{{count($key->pg_benar_r)}}</td>
                                <td style="width:7%">{{count($key->pg_salah_r)}}</td>
                                <td style="width:8%">{{count($key->essay_benar_r)}}</td>
                                <td style="width:8%">{{count($key->essay_salah_r)}}</td> -->
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.MultiStep Form -->
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

    <!-- Modal Kirim Account Peserta -->
    <div class="modal fade" id="modal-konfirmasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <form action="{{ url('jadwal/kirimaccount/peserta') }}" class="form-horizontal" id="formDelete"
            name="formDelete" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="" name="idHapusData" id="idHapusData">
            <div class="modal-dialog modal-md">
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
    </div>
    <!-- end of modal kirim account peserta -->

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

        var dt = $('#custom-table').DataTable({
            "lengthMenu": [
                [20, 20, 50],
                [20, 20, 50]
            ],
            'responsive': true,
            "scrollX": true,
            "scrollY": $(window).height() - 255,
            "scrollCollapse": true,

            "searching": false,
            "autoWidth": false,
            "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "targets": [0, 1]
            }],
            "aaSorting": []
        });

        dt.on('order.dt search.dt', function () {
            dt.column(1, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();

        // Kunci Input NIK Hanya Angka
        $('#jumlahkelompok').on('input blur paste', function () {
            $(this).val($(this).val().replace(/\D/g, ''))
        });

        // Show Modal Penilaian
        // $('.btnnilai').on('click', function () {
        //     $('#modaldetailAhli').modal('show');
        // });

        $('#btnkirim').on('click', function (e) {
            e.preventDefault();
            var id = [];
            $('.selection:checked').each(function () {
                id.push($(this).data('id'));
            });
            $("#idHapusData").val(id);
            if (id.length == 0) {
                Swal.fire({
                    title: "Tidak ada data yang terpilih",
                    type: 'warning',
                    confirmButtonText: 'Close',
                    confirmButtonColor: '#AAA'
                });
                // alert('Tidak ada data yang terpilih');
            } else {
                $('#modal-konfirmasi').modal('show');
            }
        });

        $('#btnbuatklp').on('click', function (e) {
            e.preventDefault();
            $('#modal_buat_kelompok').modal('show');
        });

        $('#btndetail').on('click', function (e) {
            e.preventDefault();
            var id = [];
            $('.selection:checked').each(function () {
                id.push($(this).data('id'));
            });
            $("#idHapusData").val(id);
            if (id.length == 0) {
                Swal.fire({
                    title: "Tidak ada data yang terpilih",
                    type: 'warning',
                    confirmButtonText: 'Close',
                    confirmButtonColor: '#AAA'
                });
                // alert('Tidak ada data yang terpilih');
            } else if (id.length > 1) {
                Swal.fire({
                    title: "Harap pilih satu data untuk detail",
                    type: 'warning',
                    confirmButtonText: 'Close',
                    confirmButtonColor: '#AAA'
                });
                // alert('Tidak ada data yang terpilih');
            } else {
                idpeserta = id[0];
                window.location.href = "{{ url('jadwal/peserta/'.$data->id) }}/" + idpeserta;
            }
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

        // $('#btnbuatklp').on('click', function (e) {
        //     e.preventDefault();
        //     Swal.fire({
        //         title: 'Generate Kelompok',
        //         text: "Sistem akan generate kelompok secara random?",
        //         icon: 'warning',
        //         buttons: true,
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         cancelButtonText: "Batal",
        //         confirmButtonText: 'Ya'
        //     }).then((result) => {
        //         if (result.value) {
        //             idjadwal = "{{$data->id}}";
        //             buatkelompok(idjadwal);
        //         }
        //     });
        // });

        // Fungsi membuat kelompok
        // function buatkelompok(idjadwal) {
        //     var url = "{{ url('bentukkelompok') }}";
        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //     $.ajax({
        //         url: url,
        //         method: 'POST',
        //         data: {
        //             idjadwal: idjadwal
        //         },
        //         success: function (data) {
        //             if (data['status'] == "success") {
        //                 Swal.fire({
        //                     title: data['message'],
        //                     // text: response.success,
        //                     type: data['status'],
        //                     confirmButtonText: 'Ok',
        //                     confirmButtonColor: '#AAA',
        //                     onClose: function () {
        //                         window.location.href =
        //                             "{{ url('jadwal/lihatkelompok/'.$data->id) }}";
        //                     }
        //                 });
        //             } else {
        //                 Swal.fire({
        //                     title: data['message'],
        //                     type: data['status'],
        //                     confirmButtonText: 'Ok',
        //                     confirmButtonColor: '#AAA'
        //                 });
        //             }
        //         },
        //         error: function (xhr, status) {
        //             alert('Error');
        //         }
        //     });
        // }

    });

    $('.datepicker').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true
    });

</script>
@endpush
