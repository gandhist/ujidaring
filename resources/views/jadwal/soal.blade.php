@extends('templates.header')

@section('content')
<style>
    .dataTables_scrollBody {
        height: 500px !important;
    }

</style>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><a href="{{ url('jadwal/'.$data->id.'/dashboard') }}" class="btn btn-md bg-purple"><i
                class="fa fa-caret-left"></i> Kembali</a> Soal
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
            <!-- <div class="row">
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
                <div class="col-md-3">
                </div>
                <div class="col-md-2">

                </div>
            </div> -->
            <hr>
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#upload">Upload Soal</a></li>
                <li><a data-toggle="tab" href="#soal_pg">Soal Pilihan Ganda</a></li>
                <li><a data-toggle="tab" href="#soal_essay">Soal Essay</a></li>
            </ul>
            <div class="tab-content">
                <div id="upload" class="tab-pane fade in active">
                    <!-- Upload Soal -->
                    <div class="box box-info">
                        <div class="box-header with-border" style="text-align:center">
                            <h3 class="box-title">Upload Soal</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">

                            <form action="{{ url('instruktur/dashboardinstruktur/'.$data->id.'/uploadsoal') }}"
                                class="form-horizontal" id="formAdd" name="formAdd" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <table class="table no-margin">
                                    <thead>
                                        <tr>
                                            <th>Upload Soal Pilihan Ganda (.xls/.xlsx) <a class="btn btn-success btn-xs" href="{{ url('template_upload/pilihan_ganda.xlsx') }}"> <i class="fa fa-file-excel-o" ></i> Template</a></th>
                                            <th></th>
                                            <th>Upload Soal Essay (.xls/.xlsx) <a class="btn btn-success btn-xs" href="{{ url('template_upload/essay.xlsx') }}"> <i class="fa fa-file-excel-o" ></i> Template</a></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <input type="file" class="form-control" id="soalPg" name="soalPg"
                                                        value="" >
                                                    <span id="soalPgSpan"
                                                        class="help-block customspan">{{ $errors->first('soalPg') }}</span>
                                                </div>
                                            </td>
                                            <td></td>
                                            <td>
                                                <div class="form-group">
                                                    <input type="file" class="form-control" id="soalEssay"
                                                        name="soalEssay" value="" >
                                                    <span id="soalEssaySpan"
                                                        class="help-block customspan">{{ $errors->first('soalEssay') }}</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-sm-12" style="text-align:left">
                                        <button id="btnUpdateNilai" type="submit" class="btn btn-md btn-danger">
                                            <i class="fa fa-save"></i>
                                            Upload</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>
                <div id="soal_pg" class="tab-pane fade in">
                    <div class="box box-info">
                        <div class="box-header with-border" style="text-align:center">
                            <h3 class="box-title">Soal Pilihan Ganda</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table no-margin dataTable customTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Soal</th>
                                            <th>PG A</th>
                                            <th>PG B</th>
                                            <th>PG C</th>
                                            <th>PG D</th>
                                            <th>Jawaban</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($SoalPg as $key)
                                        <tr>
                                            <td style="width:1%">{{ $loop->iteration }}</td>
                                            <td>{{ $key->soal }}</td>
                                            <td style="width:5%">{{ $key->pg_a }}</td>
                                            <td style="width:5%">{{ $key->pg_b }}</td>
                                            <td style="width:5%">{{ $key->pg_c }}</td>
                                            <td style="width:5%">{{ $key->pg_d }}</td>
                                            <td>{{ $key->jawaban }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- Soal Pilihan Ganda -->
                </div>

                <div id="soal_essay" class="tab-pane fade">

                    <div class="box box-info">
                        <div class="box-header with-border" style="text-align:center">
                            <h3 class="box-title">Soal Essay</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table no-margin dataTable customTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Soal</th>
                                            <th>Jawaban</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($SoalEssay as $key)
                                        <tr>
                                            <td style="width:1%">{{ $loop->iteration }}</td>
                                            <td>{{ $key->soal }}</td>
                                            <td>{{ $key->jawaban }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- Soal Essay -->
                </div>
            </div>
        </div>
        <br>
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
        // Kunci Input NIK Hanya Angka
        $('.Inputbobot').on('input blur paste', function () {
            $(this).val($(this).val().replace(/\D/g, ''))
        });

        $("#btnmulai").on('click', function () {
            $("#durasi").css("border-color", "#ccc");
            var durasi = $("#durasi").val();
            var idJadwal = $("#idJadwal").val();
            if (durasi == "") {
                Swal.fire({
                    title: "Durasi ujian belum diisi",
                    type: 'warning',
                    confirmButtonText: 'Close',
                    confirmButtonColor: '#AAA'
                });
                $("#durasi").focus();
                $("#durasi").css("border-color", "red");
            } else {
                Swal.fire({
                    title: 'Mulai Ujian?',
                    text: "Apakah anda yakin untuk memulai ujian?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Mulai'
                }).then((result) => {
                    if (result.value) {
                        Swal.fire(
                            'Ujian dimulai!',
                            'Waktu dihitung mundur dari sekarang.',
                            'success'
                        )
                    }
                    updateDurasi(durasi, idJadwal);

                });

            }
        });

        // Show Modal Penilaian
        $('.btnnilai').on('click', function () {
            $('#modaldetailAhli').modal('show');
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


        // Fungsi Update durasi ujian
        function updateDurasi(durasi, idJadwal) {
            var url = "{{ url('updateDurasiUjian') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    durasi: durasi,
                    idJadwal: idJadwal
                },
                success: function (data) {


                    // countdown
                    var $clock = $('#clock'),
                        eventTime = moment(data, 'YYYY-MM-DD HH:mm:ss').unix(),
                        currentTime = moment().unix(),
                        diffTime = eventTime - currentTime,
                        duration = moment.duration(diffTime * 1000, 'milliseconds'),
                        interval = 1000;

                    if (diffTime > 0) {

                        // Show clock
                        // $clock.show();
                        $('#clock').text("");
                        var $d = $('<span class="days" ></span>').appendTo($clock),
                            $h = $('<span class="hours" ></span>').appendTo($clock),
                            $m = $('<span class="minutes" ></span>').appendTo($clock),
                            $s = $('<span class="seconds" ></span>').appendTo($clock);

                        setInterval(function () {

                            duration = moment.duration(duration.asMilliseconds() -
                                interval, 'milliseconds');
                            var d = moment.duration(duration).days(),
                                h = moment.duration(duration).hours(),
                                m = moment.duration(duration).minutes(),
                                s = moment.duration(duration).seconds();

                            d = $.trim(d).length === 1 ? '0' + d : d;
                            h = $.trim(h).length === 1 ? '0' + h : h;
                            m = $.trim(m).length === 1 ? '0' + m : m;
                            s = $.trim(s).length === 1 ? '0' + s : s;

                            // show how many hours, minutes and seconds are left
                            // $d.text(d + ":");
                            $h.text(h + ":");
                            $m.text(m + ":");
                            $s.text(s);

                        }, interval);

                    }
                    // Countdown
                },
                error: function (xhr, status) {
                    alert('Error');
                }
            });
        }

        var dt = $('#custom-table,#custom-table2').DataTable({
            "lengthMenu": [
                [10, 20, 50],
                [10, 20, 50]
            ],
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

    });

    $('.datepicker').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true
    });

</script>
@endpush
