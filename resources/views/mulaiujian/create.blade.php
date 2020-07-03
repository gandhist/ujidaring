@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 style="padding-left: 40%">
        Mulai Ujian
        {{-- <small>it all starts here</small>  --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#">Jadwal</a></li>
    </ol>


</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box box-content">
        <div class="box-body">
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
                        <!-- /.table-responsive -->
                    </div>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-4">
                    <form action="{{ route('jadwal.store') }}" id="" name="" method="post"
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
                            <!-- /.table-responsive -->
                        </div>
                    </form>
                </div>
                <div class="col-md-12">
                    <h3>Daftar Peserta</h3>
                    <table id="custom-table" class="table table-striped table-bordered dataTable customTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Tempat Lahir</th>
                                <th>Tanggal Lahir</th>
                                <th>No HP</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($Peserta as $key)
                            <tr>
                                <td style="width:1%"></td>
                                <td>{{ $key->nik }}</td>
                                <td>{{ $key->nama }}</td>
                                <td>{{ $key->tmp_lahir }}</td>
                                <td style="text-align:right">
                                    {{ \Carbon\Carbon::parse($key->tgl_lahir)->isoFormat("DD MMMM YYYY") }}</td>
                                <td>{{ $key->no_hp }}</td>
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
            "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "targets": [0, 1]
            }],
            "aaSorting": []
        });

        dt.on('order.dt search.dt', function () {
            dt.column(0, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();

        // Kunci Input NIK Hanya Angka
        $('#durasi').on('input blur paste', function () {
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

                    // timer soal ujian
                    // var currentTime= "{{ strtotime($peserta->mulai_ujian) }}"; // Timestamp - Sun, 21 Apr 2013 13:00:00 GMT
                    // var currentTime ="{{ \Carbon\Carbon::now()->timestamp }}"; // Timestamp - Sun, 21 Apr 2013 13:00:00 GMT
                    // var eventTime ="{{ strtotime($peserta->jadwal_r->akhir_ujian) }}"; // Timestamp - Sun, 21 Apr 2013 12:30:00 GMT
                    // var diffTime = eventTime - currentTime;
                    // var duration = moment.duration(diffTime * 1000, 'milliseconds');
                    // var interval = 1000;

                    // timer = setInterval(function () {

                    //     duration = moment.duration(duration - interval, 'milliseconds');
                    //     stopTimer(duration);
                    //     $('#clock').text(duration.hours() + ":" + duration.minutes() +
                    //         ":" + duration.seconds())
                    // }, interval);

                    // var time = durasi;
                    // var duration = moment.duration(time * 10000, 'milliseconds');
                    // var interval = 1000;

                    // setInterval(function () {
                    //     duration = moment.duration(duration.asMilliseconds() - interval,
                    //         'milliseconds');

                    //     $('#clock').text(moment(duration.asMilliseconds()).format(
                    //         'h:mm:ss'));
                    // }, interval);

                });

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
                    console.log("Ujian Dimulai");
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
