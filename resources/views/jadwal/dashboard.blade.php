@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><a href="{{ url('jadwal') }}" class="btn btn-md bg-purple"><i class="fa fa-caret-left"></i> Kembali</a>
        Dashboard
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
                                        <th style="text-align:left;padding: 6px;vertical-align: middle;">Bidang</th>
                                        <td style="text-align:left;padding: 6px;vertical-align: middle;">:
                                            {{$data->bidang_r->nama_bidang}}
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
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
            </div>
            <!-- /.MultiStep Form -->

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
                        <a target="_blank" href="{{ url('jadwal/instruktur', $data->id) }}"
                            class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
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
                        <a target="_blank" href="{{ url('jadwal/peserta', $data->id) }}" class="small-box-footer">Detail
                            <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- end of peserta -->
                <!-- soal -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>{{$jumlahSoalPg+$jumlahSoalEssay}}</h3>
                            <p>Soal</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-newspaper-o" aria-hidden="true"></i>
                        </div>
                        <a target="_blank" href="{{ url('jadwal/soal', $data->id) }}" class="small-box-footer">Detail
                            <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- end of soal -->
                <!-- modul -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>{{$modul}}</h3>
                            <p>Modul</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-folder-open-o" aria-hidden="true"></i>
                        </div>
                        <a target="_blank" href="{{ url('instruktur/modul',$data->id) }}"
                            class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- end of modul -->
                <!-- atur jadwal -->
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-blue">
                        <div class="inner">
                            <h3>{{$jumlahJadwal}}</h3>
                            <p>Atur Jadwal</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                        </div>
                        <a target="_blank" href="{{ url('jadwal/aturjadwal', $data->id) }}"
                            class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- end of atur jadwal -->
                <!-- absen -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>{{$jumlahabsen}}</h3>
                            <p>Absen</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users" aria-hidden="true"></i>
                        </div>
                        <a target="_blank" href="{{ url('jadwal/absen', $data->id) }}" class="small-box-footer">Detail
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
                        <a target="_blank" href="{{ route('pkl', $data->id) }}" class="small-box-footer">Detail <i
                                class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- end of makalah/pkl -->
                {{-- tugas --}}
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
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
                            <i class="fa fa-book" aria-hidden="true"></i>
                        </div>
                        <a target="_blank" href="{{ url('jadwal/tugas',$data->id) }}" class="small-box-footer">Detail
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
                            <i class="ion ion-person"></i>
                        </div>
                        <a target="_blank" href="{{ url('jadwal/evaluasi', $data->id) }}"
                            class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- end of evaluasi -->

                <div class="col-lg-12 col-xs-12" style="text-align:center">
                    <button onclick='tampilFoto("{{ asset("/$data->pdf_jadwal") }}","Jadwal")' type="button"
                        class="btn btn-block btn-info btn-flat">Jadwal</button>
                </div>
                <!-- ./col -->
            </div>


        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

    <!-- modal konfirmasi -->
    <div class="modal fade" id="modal-konfirmasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
    </div>
    <!-- end of modal konfirmais -->

    <!-- modal lampiran -->
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
            dt.column(1, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();

        // Kunci Input durasi Hanya Angka
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
                    buttons: true,
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
                    updateDurasi(durasi, idJadwal);
                    }

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

                    // countdown
                    var $clock = $('#clock'),
                        eventTime = moment(data, 'YYYY-MM-DD HH:mm:ss').unix(),
                        currentTime = moment().unix(),
                        diffTime = eventTime - currentTime,
                        duration = moment.duration(diffTime * 1000, 'milliseconds'),
                        interval = 1000;

                    if (diffTime > 0) {
                        $("#durasi").attr('readonly', 'readonly');
                        $("#durasi").css('background-color', '#ccc');
                        $("#durasi").val($("#durasi").val() + " Menit");
                        $("#btnmulai").text("Ujian Sedang Berlangsung");
                        $("#btnmulai").attr("class", "btn btn-block btn-warning btn-flat disabled");
                        $("#durasi").unbind();
                        $("#btnmulai").unbind();

                        // Show clock
                        // $clock.show();
                        $('#clock').text("");
                        var $d = $('<span class="days" ></span>').appendTo($clock),
                            $h = $('<span class="hours" ></span>').appendTo($clock),
                            $m = $('<span class="minutes" ></span>').appendTo($clock),
                            $s = $('<span class="seconds" ></span>').appendTo($clock);

                        timer = setInterval(function () {

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

                            if (h == '00' && m == '00' && s == '00') {
                                $("#btnmulai").text('Ujian Telah Selesai');
                                $("#btnmulai").attr("class",
                                    "btn btn-block btn-danger btn-flat disabled");
                                Swal.fire({
                                    title: "Ujian telah selesai",
                                    type: 'success',
                                    confirmButtonText: 'Ok',
                                    confirmButtonColor: '#AAA'
                                });
                                clearInterval(timer);
                            }
                        }, interval);

                    }
                    // Countdown
                },
                error: function (xhr, status) {
                    alert('Error');
                }
            });
        }

        cekDurasi();

        // Fungsi Update durasi ujian
        function cekDurasi() {
            var idJadwal = $("#idJadwal").val();
            var url = "{{ url('cekDurasiUjian') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    idJadwal: idJadwal
                },
                success: function (data) {

                    if (data['akhir_ujian'] == null) {

                    } else if (data['waktusekarang'] > data['mulai_ujian'] && data[
                            'waktusekarang'] < data[
                            'akhir_ujian']) {
                        // countdown
                        var $clock = $('#clock'),
                            eventTime = moment(data['akhir_ujian'], 'YYYY-MM-DD HH:mm:ss').unix(),
                            currentTime = moment().unix(),
                            diffTime = eventTime - currentTime,
                            duration = moment.duration(diffTime * 1000, 'milliseconds'),
                            interval = 1000;

                        if (diffTime > 0) {

                            $("#durasi").attr('readonly', 'readonly');
                            $("#durasi").css('background-color', '#ccc');
                            $("#durasi").val($("#durasi").val() + " Menit");
                            $("#btnmulai").text('Ujian Sedang Berlangsung');
                            $("#btnmulai").attr("class",
                                "btn btn-block btn-warning btn-flat disabled");
                            $("#durasi").unbind();
                            $("#btnmulai").unbind();

                            // Show clock
                            // $clock.show();
                            $('#clock').text("");
                            var $d = $('<span class="days" ></span>').appendTo($clock),
                                $h = $('<span class="hours" ></span>').appendTo($clock),
                                $m = $('<span class="minutes" ></span>').appendTo($clock),
                                $s = $('<span class="seconds" ></span>').appendTo($clock);

                            timer = setInterval(function () {

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


                                if (h == '00' && m == '00' && s == '00') {
                                    clearInterval(timer);
                                    Swal.fire({
                                        title: "Ujian telah selesai",
                                        type: 'success',
                                        confirmButtonText: 'Ok',
                                        confirmButtonColor: '#AAA'
                                    });
                                    $("#btnmulai").text('Ujian Telah Selesai');
                                    $("#btnmulai").attr("class",
                                        "btn btn-block btn-danger btn-flat disabled");

                                }
                            }, interval);

                        }
                        // Countdown
                    } else if (data['waktusekarang'] > data['akhir_ujian']) {
                        $("#durasi").attr('readonly', 'readonly');
                        $("#durasi").css('background-color', '#ccc');
                        $("#btnmulai").text('Ujian Telah Selesai');
                        $("#btnmulai").attr("class", "btn btn-block btn-danger btn-flat disabled");
                        $("#durasi").unbind();
                        $("#btnmulai").unbind();
                    } else {
                        console.log('Ujian Belum Selesai');
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
