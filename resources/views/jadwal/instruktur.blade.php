@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><a href="{{ url('jadwal/'.$data->id.'/dashboard') }}" class="btn btn-md bg-purple"><i
                class="fa fa-arrow-left"></i></a> Instruktur
        {{-- <small>it all starts here</small>  --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#">Instruktur</a></li>
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
                <div class="col-md-8">
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
                                        <th style="text-align:left;padding: 6px;vertical-align: middle;">Jml Peserta
                                        </th>
                                        <td style="text-align:left;padding: 6px;vertical-align: middle;">:
                                            {{$jumlahPeserta}} Orang</td>

                                        <th style="text-align:left;padding: 6px;vertical-align: middle;">Jml Soal Pg
                                        </th>
                                        <td style="text-align:left;padding: 6px;vertical-align: middle;">:
                                            {{$jumlahSoalPg}} Soal</td>

                                        <th style="text-align:left;padding: 6px;vertical-align: middle;">Jml Soal Essay
                                        </th>
                                        <td style="text-align:left;padding: 6px;vertical-align: middle;">:
                                            {{$jumlahSoalEssay}} Soal</td>
                                    </tr>

                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-1">
                </div> -->
                <div class="col-md-4">
                    <!-- <div class="box-body"> -->
                    <div class="table-responsive">
                        <table class="table no-margin">
                            <tbody>
                                <tr>
                                    <td style="text-align:right;padding:8px 0px 2px 0px;">
                                        <!-- <div class="row">
                                                <div class="col-xs-12"> -->
                                        <div class="btn-group">
                                            <button class="btn btn-success btn-flat" id="btnEdit" name="btnEdit"> <i
                                                    class="fa fa-edit"></i>Ubah
                                            </button>
                                            <button class="btn btn-danger btn-flat" id="btnReset" name="btnReset">
                                                <i class="fa fa-refresh"></i>
                                                Reset Login</button>
                                        </div>
                                        <!-- </div>
                                            </div> -->
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align:right;padding:0px 0px 0px 0px;"><button id="btnkirim"
                                            type="button" class="btn btn-primary btn-flat">Kirim
                                            User Account</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- </div> -->
                </div>
                <div class="col-md-12">
                    <table id="custom-table" class="table table-striped table-bordered dataTable customTable">
                        <thead>
                            <tr>
                                <th><i class="fa fa-check-square-o"></i></th>
                                <th>No</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>No Hp</th>
                                <th style="white-space: nowrap">Status Login</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($Instruktur as $key)
                            <tr>
                                <td style='width:1%'><input type="checkbox" data-id="{{ $key->instruktur_r->id }}"
                                        class="selection" id="selection[]" name="selection[]"></td>
                                <td style="width:1%"></td>
                                <td>{{ $key->instruktur_r->nik }}</td>
                                <td>{{ $key->instruktur_r->nama }}</td>
                                <td style="width:5%">{{ $key->instruktur_r->no_hp }}</td>
                                <td style="text-align:center;width:1%">
                                @if($key->instruktur_r->user_r->is_login==1)
                                <button type="button" class="btn btn-sm btn-info">Login</button>
                                @endif
                                </td>
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

    <!-- modal konfirmasi -->
    <div class="modal fade" id="modal-konfirmasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <form action="{{ url('jadwal/kirimaccount/instruktur') }}" class="form-horizontal" id="formDelete"
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
                        Apakah anda ingin mengirim account instruktur?
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
    <!-- end of modal konfirmais -->

    <!-- Modal edit data instruktur -->
    <div class="modal fade" id="modal-edit-ins" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <form action="{{ url('update/instruktur') }}" class="form-horizontal" id="formeditins" name="formeditins"
            method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Edit Data Instruktur</h4>
                    </div>
                    <div class="modal-body" id="konfirmasi-body">
                        <form class="form-horizontal">
                            <div class="box-body">
                                <input type="hidden" value="" name="idins" id="idins">
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
    <!-- End of modal edit data instruktur -->

    <!-- Modal Reset Account Instruktur -->
    <div class="modal fade" id="modal-reset" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <form action="{{ url('jadwal/reset/instruktur') }}" class="form-horizontal" id="formresetaccount"
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
                        Apakah anda ingin reset account login instruktur?
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

        $('#btnsimpan').on('click', function (e) {
            e.preventDefault();
            updateinstruktur();
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
                idinstruktur = id[0];
                getDataInstruktur(idinstruktur);
            }
        });

        // $("#btnmulai").on('click', function () {
        //     $("#durasi").css("border-color", "#ccc");
        //     var durasi = $("#durasi").val();
        //     var idJadwal = $("#idJadwal").val();
        //     if (durasi == "") {
        //         Swal.fire({
        //             title: "Durasi ujian belum diisi",
        //             type: 'warning',
        //             confirmButtonText: 'Close',
        //             confirmButtonColor: '#AAA'
        //         });
        //         $("#durasi").focus();
        //         $("#durasi").css("border-color", "red");
        //     } else {
        //         Swal.fire({
        //             title: 'Mulai Ujian?',
        //             text: "Apakah anda yakin untuk memulai ujian?",
        //             icon: 'warning',
        //             showCancelButton: true,
        //             confirmButtonColor: '#3085d6',
        //             cancelButtonColor: '#d33',
        //             confirmButtonText: 'Mulai'
        //         }).then((result) => {
        //             if (result.value) {
        //                 Swal.fire(
        //                     'Ujian dimulai!',
        //                     'Waktu dihitung mundur dari sekarang.',
        //                     'success'
        //                 )
        //             }
        //             updateDurasi(durasi, idJadwal);

        //         });

        //     }
        // });

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

        // Fungsi get data instruktur
        function getDataInstruktur(idinstruktur) {
            var url = "{{ url('getdatainstruktur') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    idinstruktur: idinstruktur
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
                    $("#idins").val(data['id']);
                    $("#nama").val(data['nama']);
                    $("#no_hp").val(data['no_hp']);
                    $('#modal-edit-ins').modal('show');
                },
                error: function (xhr, status) {
                    alert('Error');
                },
                complete: function () {
                    $.LoadingOverlay("hide");
                }
            });
        }

        function updateinstruktur() {
            var formData = new FormData($('#formeditins')[0]);

            var url = "{{ url('jadwal/instruktur/update') }}";
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


        // Fungsi Update durasi ujian
        // function updateDurasi(durasi, idJadwal) {
        //     var url = "{{ url('updateDurasiUjian') }}";
        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //     $.ajax({
        //         url: url,
        //         method: 'POST',
        //         data: {
        //             durasi: durasi,
        //             idJadwal: idJadwal
        //         },
        //         success: function (data) {
        //             var $clock = $('#clock'),
        //                 eventTime = moment(data, 'YYYY-MM-DD HH:mm:ss').unix(),
        //                 currentTime = moment().unix(),
        //                 diffTime = eventTime - currentTime,
        //                 duration = moment.duration(diffTime * 1000, 'milliseconds'),
        //                 interval = 1000;

        //             if (diffTime > 0) {

        //                 $('#clock').text("");
        //                 var $d = $('<span class="days" ></span>').appendTo($clock),
        //                     $h = $('<span class="hours" ></span>').appendTo($clock),
        //                     $m = $('<span class="minutes" ></span>').appendTo($clock),
        //                     $s = $('<span class="seconds" ></span>').appendTo($clock);

        //                 setInterval(function () {

        //                     duration = moment.duration(duration.asMilliseconds() -
        //                         interval, 'milliseconds');
        //                     var d = moment.duration(duration).days(),
        //                         h = moment.duration(duration).hours(),
        //                         m = moment.duration(duration).minutes(),
        //                         s = moment.duration(duration).seconds();

        //                     d = $.trim(d).length === 1 ? '0' + d : d;
        //                     h = $.trim(h).length === 1 ? '0' + h : h;
        //                     m = $.trim(m).length === 1 ? '0' + m : m;
        //                     s = $.trim(s).length === 1 ? '0' + s : s;

        //                     $h.text(h + ":");
        //                     $m.text(m + ":");
        //                     $s.text(s);

        //                 }, interval);
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
