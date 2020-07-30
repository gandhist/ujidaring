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
                <div class="col-md-1">
                </div>
                <div class="col-md-4">

                    <div class="table-responsive">
                        <table class="table no-margin">
                            <thead>
                                <tr>
                                    <td style="text-align:right;padding:8px 0px 2px 0px;">
                                        <!-- <div class="row">
                                            <div class="col-xs-12"> -->
                                                <div class="btn-group">
                                                    <button class="btn btn-success btn-flat" id="btnEdit"
                                                        name="btnEdit"> <i class="fa fa-edit"></i>Ubah
                                                    </button>
                                                    <button class="btn btn-danger btn-flat" id="btnReset"
                                                        name="btnReset">
                                                        <i class="fa fa-refresh"></i>
                                                        Reset Login</button>
                                                </div>
                                            <!-- </div>
                                        </div> -->
                                    </td>
                                    <!-- <td style="text-align:left;padding-bottom:0px;padding-top:0px">
                                            <button id="btnkirim" type="button"
                                                class="btn btn-block btn-primary btn-flat">Kirim User Account</button>
                                        </td> -->
                                </tr>
                                <tr>
                                    <td style="text-align:right;padding:0px 0px 0px 0px;">
                                        <div class="btn-group">
                                            <button id="btnkirim" type="button" class="btn btn-primary btn-flat">Kirim
                                                User
                                                Account</button>
                                            <button id="btndetail" type="button" class="btn btn-warning btn-flat">Lihat
                                                Detail</button>
                                        </div>
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

    <!-- Modal Edit Data Peserta -->
    <div class="modal fade" id="modal-edit-peserta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <form action="{{ url('update/peserta') }}" class="form-horizontal" id="formeditpeserta" name="formeditpeserta"
            method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Edit Data Peserta</h4>
                    </div>
                    <div class="modal-body" id="konfirmasi-body">
                        <form class="form-horizontal">
                            <div class="box-body">
                                <input type="hidden" value="" name="iddatapeserta" id="iddatapeserta">
                                <div class="form-group">
                                    <label for="nama" class="col-sm-2 control-label">Nama</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            placeholder="Nama">
                                        <span id="nama" class="help-block customspan"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="no_hp" class="col-sm-2 control-label">No Hp</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="no_hp" name="no_hp"
                                            placeholder="No Hp">
                                        <span id="no_hp" class="help-block customspan"></span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="btnsimpan"
                            data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Mengirim..."
                            id="confirm-delete">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- end of modal kirim account peserta -->


    <!-- Modal Kirim Account Peserta -->
    <div class="modal fade" id="modal-konfirmasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <form action="{{ url('jadwal/kirimaccount/peserta') }}" class="form-horizontal" id="formkirimaccount"
            name="formkirimaccount" method="post" enctype="multipart/form-data">
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
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" data-id=""
                            data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Kirim..."
                            id="confirm-delete">Kirim</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- end of modal kirim account peserta -->

    <!-- Modal Reset Account Peserta -->
    <div class="modal fade" id="modal-reset" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <form action="{{ url('jadwal/reset/peserta') }}" class="form-horizontal" id="formresetaccount"
            name="formresetaccount" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="" name="idResetData" id="idResetData">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Konfirmasi</h4>
                    </div>
                    <div class="modal-body" id="konfirmasi-body">
                        Apakah anda ingin reset account login peserta?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
                        <button type="submit" class="btn btn-primary" data-id=""
                            data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Kirim..."
                            id="confirm-delete">Ya</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- end of modal reset account peserta -->

    <!-- Modal Buat Kelompok -->
    <!-- <div class="modal fade" id="modal_buat_kelompok" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
    </div> -->
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

        // Kunci Input No Hp Hanya Angka
        $('#no_hp').on('input blur paste', function () {
            $(this).val($(this).val().replace(/\D/g, ''))
        });

        $('#btnsimpan').on('click', function (e) {
            e.preventDefault();
            updatepeserta();
        });

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

        $('#btnReset').on('click', function (e) {
            e.preventDefault();
            var id = [];
            $('.selection:checked').each(function () {
                id.push($(this).data('id'));
            });
            $("#idResetData").val(id);
            if (id.length == 0) {
                Swal.fire({
                    title: "Tidak ada data yang terpilih",
                    type: 'warning',
                    confirmButtonText: 'Close',
                    confirmButtonColor: '#AAA'
                });
                // alert('Tidak ada data yang terpilih');
            } else {
                $('#modal-reset').modal('show');
            }
        });

        // $('#btnbuatklp').on('click', function (e) {
        //     e.preventDefault();
        //     $('#modal_buat_kelompok').modal('show');
        // });

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

        $('#btnEdit').on('click', function (e) {
            e.preventDefault();
            // 
            $('.form-group').removeClass('has-error');
            $('.help-block').text("");

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
                    title: "Harap pilih satu data untuk diubah",
                    type: 'warning',
                    confirmButtonText: 'Close',
                    confirmButtonColor: '#AAA'
                });
                // alert('Tidak ada data yang terpilih');
            } else {
                idpeserta = id[0];
                getDataPeserta(idpeserta);
            }
        });

        function updatepeserta() {
            var formData = new FormData($('#formeditpeserta')[0]);

            var url = "{{ url('jadwal/peserta/update') }}";
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
                                location.reload();
                            }
                        });
                    }
                },
                error: function (xhr, status) {
                    var a = JSON.parse(xhr.responseText);
                    $('.form-group').removeClass('has-error');
                    $('.help-block').text("");
                    $.each(a.errors, function (key, value) {
                        $("#" + key).parent().parent().addClass('has-error');
                        $('span[id^="' + key + '"]').text(value);
                    });
                },
                complete: function () {
                    $.LoadingOverlay("hide");
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

        // Fungsi get data peserta
        function getDataPeserta(idpeserta) {
            var url = "{{ url('getdatapeserta') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    idpeserta: idpeserta
                },
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
                success: function (data) {
                    $("#iddatapeserta").val(data['id']);
                    $("#nama").val(data['nama']);
                    $("#no_hp").val(data['no_hp']);
                    $('#modal-edit-peserta').modal('show');
                },
                error: function (xhr, status) {
                    alert('Error');
                },
                complete: function () {
                    $.LoadingOverlay("hide");
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
