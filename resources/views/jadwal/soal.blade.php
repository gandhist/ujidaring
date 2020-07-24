@extends('templates.header')

@section('content')
<!-- <style>
    .dataTables_scrollBody {
        height: 500px !important;
    }

</style> -->
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><a href="{{ url('jadwal/'.$data->id.'/dashboard') }}" class="btn btn-md bg-purple"><i
                class="fa fa-arrow-left"></i></a> Ujian
        {{-- <small>it all starts here</small>  --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#">Ujian</a></li>
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
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#mulai">Durasi</a></li>
                <li><a data-toggle="tab" href="#upload">Upload Soal</a></li>
                <li><a data-toggle="tab" href="#soal_pg">Soal Pilihan Ganda</a></li>
                <li><a data-toggle="tab" href="#soal_essay">Soal Essay</a></li>
            </ul>
            <div class="tab-content">
                <div id="mulai" class="tab-pane fade in active">
                    <br>
                    <div class="box-body">
                        <div class="col-sm-12" style="text-align:center">
                            <input type="hidden" id="idJadwal" name="idJadwal" value="{{$data->id}}">
                            <b class="pull-left">Durasi (Menit)</b>
                            <input maxlength="4" id="durasi" name="durasi" type="text" class="form-control"
                                placeholder="Durasi Ujian (Menit)" value="{{$data->durasi_ujian}}"><br>
                            <button id="btnmulai" type="button" class="btn btn-block btn-info btn-flat">Mulai
                                Ujian</button>
                            <h1 style="text-align:center" id="clock">00:00:00</h1>
                        </div>
                    </div>
                </div>

                <div id="upload" class="tab-pane fade in">
                    <div class="box-body">
                        <form class="form-horizontal" id="formAdd" name="formAdd" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <table class="table no-margin">
                                <thead>
                                    <tr>
                                        <th style="text-align:center"><a class="btn btn-success btn-xs"
                                                href="{{ url('template_upload/pilihan_ganda.xlsx') }}"> <i
                                                    class="fa fa-file-excel-o"></i>Template Soal PG</a> Upload Soal
                                            Pilihan Ganda (.xls/.xlsx)</th>
                                        <th></th>
                                        <th style="text-align:center"><a class="btn btn-success btn-xs"
                                                href="{{ url('template_upload/essay.xlsx') }}"> <i
                                                    class="fa fa-file-excel-o"></i>Template Soal Essay</a> Upload Soal
                                            Essay (.xls/.xlsx)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <input type="file" class="form-control" id="soalPg" name="soalPg"
                                                    value="">
                                                <span id="soalPgSpan"
                                                    class="help-block customspan">{{ $errors->first('soalPg') }}</span>
                                            </div>
                                        </td>
                                        <td></td>
                                        <td>
                                            <div class="form-group">
                                                <input type="file" class="form-control" id="soalEssay" name="soalEssay"
                                                    value="">
                                                <span id="soalEssaySpan"
                                                    class="help-block customspan">{{ $errors->first('soalEssay') }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-sm-12" style="text-align:left">
                                    <button id="btnSave" type="button" class="btn btn-block btn-md btn-info">
                                        <i class="fa fa-save"></i>
                                        Upload</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div id="soal_pg" class="tab-pane fade in">
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
                    </div>
                </div>

                <div id="soal_essay" class="tab-pane fade">
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
                    </div>
                </div>
            </div>
        </div>
        <br>
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
        cekDurasi();

        // Kunci Input durasi Hanya Angka
        $('#durasi').on('input blur paste', function () {
            $(this).val($(this).val().replace(/\D/g, ''))
        });

        // Button Save On Click
        $('#btnSave').on('click', function (e) {
            e.preventDefault();
            store();
        })

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
                // console.log(ceksoalujian(idJadwal));

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
                    console.log(data)
                    if (data["jumlahsoal"] > 0) {
                        // countdown
                        var $clock = $('#clock'),
                            eventTime = moment(data["akhirujian"], 'YYYY-MM-DD HH:mm:ss').unix(),
                            currentTime = moment().unix(),
                            diffTime = eventTime - currentTime,
                            duration = moment.duration(diffTime * 1000, 'milliseconds'),
                            interval = 1000;

                        if (diffTime > 0) {
                            $("#durasi").attr('readonly', 'readonly');
                            $("#durasi").css('background-color', '#ccc');
                            $("#durasi").val($("#durasi").val() + " Menit");
                            $("#btnmulai").text("Ujian Sedang Berlangsung");
                            $("#btnmulai").attr("class",
                                "btn btn-block btn-warning btn-flat disabled");
                            $("#durasi").unbind();
                            $("#btnmulai").unbind();

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

                                $h.text(h + ":");
                                $m.text(m + ":");
                                $s.text(s);

                                if (h == '00' && m == '00' && s == '00') {
                                    $("#durasi").val($("#durasi").val() + " Menit");
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
                        Swal.fire(
                            'Ujian dimulai!',
                            'Waktu dihitung mundur dari sekarang.',
                            'success'
                        )

                    } else {
                        Swal.fire({
                            title: "Soal Belum diupload",
                            type: 'error',
                            confirmButtonText: 'Ok',
                            confirmButtonColor: '#AAA'
                        });
                    }
                },
                error: function (xhr, status) {
                    alert('Error');
                }
            });
        }

        function ceksoalujian(idJadwal) {
            var url = "{{ url('ceksoalujian') }}";
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

                },
                error: function (xhr, status) {

                    alert('Error');
                }
            });
        }

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
                                    $("#durasi").val($("#durasi").val() + " Menit");
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
                        $("#durasi").val($("#durasi").val() + " Menit");
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

        function store() {
            var formData = new FormData($('#formAdd')[0]);
            var url = "{{ url('instruktur/dashboardinstruktur/'.$data->id.'/uploadsoal') }}";
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
                success: function (response) {
                    console.log(response);
                    if (response.status) {
                        Swal.fire({
                            title: response.message,
                            type: response.icon,
                            confirmButtonText: 'Ok',
                            confirmButtonColor: '#AAA'
                        }).then(function () {
                            location.reload();
                        });

                    }
                },
                error: function (xhr, status) {
                    // reset to remove error
                    var a = JSON.parse(xhr.responseText);
                    // reset to remove error
                    $('.form-group').removeClass('has-error');
                    $('.help-block').hide(); // hide error span message
                    $.each(a.errors, function (key, value) {
                        $('[name="' + key + '"]').parent().addClass(
                            'has-error'
                        ); //select parent twice to select div form-group class and add has-error class
                        $('span[id^="' + key + '"]')
                            .show(); // show error message span // for select2
                        if (!$('[name="' + key + '"]').is("select")) {
                            $('[name="' + key + '"]').next().text(
                                value); //select span help-block class set text error string
                        }
                    });

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
