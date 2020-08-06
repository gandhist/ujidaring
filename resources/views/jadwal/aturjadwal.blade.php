@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
<style>
    .customselect2 {
        width: 45%;
    }

    .customselect2>.select2-container {
        width: 100% !important;
    }

    .select2-selection__choice {
        color: black !important;
    }

</style>
<section class="content-header">
    <h1><a href="{{ url('jadwal/'.$id_jadwal.'/dashboard') }}" class="btn btn-md bg-purple"><i
                class="fa fa-arrow-left"></i></a> Atur Jadwal
        {{-- <small>it all starts here</small>  --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#">Atur Jadwal</a></li>
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
                <div class="col-md-12">
                    <h3>Jadwal Perhari</h3>
                    <form action="{{ url('jadwal/aturjadwalstore') }}" class="form-horizontal" id="formAdd"
                        name="formAdd" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="jumlah" value="{{count($rundown)}}">
                        <table id="custom-table" class="table table-striped table-bordered dataTable customTable">

                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Instruktur</th>
                                    <th>Modul</th>
                                    <th>Quiz</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rundown as $key)
                                <tr>
                                    <input type="hidden" name="id_rowdown_{{ $loop->iteration }}" value="{{$key->id}}">
                                    <td style="width:1%">{{ $loop->iteration }}</td>
                                    <td>
                                        @switch(\Carbon\Carbon::parse($key->tanggal)->format('l'))
                                        @case("Sunday")
                                        Minggu,
                                        @break

                                        @case("Monday")
                                        Senin,
                                        @break

                                        @case("Tuesday")
                                        Selasa,
                                        @break

                                        @case("Wednesday")
                                        Rabu,
                                        @break

                                        @case("Thursday")
                                        Kamis,
                                        @break

                                        @case("Friday")
                                        Jumat,
                                        @break

                                        @case("Saturday")
                                        Sabtu,
                                        @break

                                        @default

                                        @endswitch
                                        {{ \Carbon\Carbon::parse($key->tanggal)->isoFormat("DD MMMM YYYY") }}</td>
                                    <td
                                        class="customselect2 {{( \Carbon\Carbon::now()->toDateTimeString() > $key->tanggal) ? 'select2-disabled' : '' }}">
                                        <select class="js-example-basic-multiple"
                                            name="instruktur_{{ $loop->iteration }}[]" multiple="multiple" required>
                                            @foreach($instrukturjadwal as $datainstrukturjadwal)
                                            <option value="{{$datainstrukturjadwal->id}}" @php
                                                $selected=DB::table('instruktur_rundown')->
                                                select('id')->where('id_jadwal_instruktur','=',$datainstrukturjadwal->id)->where('id_rundown','=',$key->id)->where('deleted_by','=',null)->first();
                                                if($selected!=null){
                                                echo "selected";
                                                }
                                                @endphp
                                                >
                                                {{$datainstrukturjadwal->instruktur_r->nama}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td
                                        class="customselect2 {{ ( \Carbon\Carbon::now()->toDateTimeString() > $key->tanggal ) ? 'select2-disabled' : '' }}">
                                        <select class="js-example-basic-multiple" name="modul_{{ $loop->iteration }}[]"
                                            multiple="multiple" required>
                                            @foreach($JadwalModul as $dataJadwalModul)
                                            <option value="{{$dataJadwalModul->id}}" @php
                                                $selected=DB::table('modul_rundown')->
                                                select('id')->where('id_jadwal_modul','=',$dataJadwalModul->id)->where('id_rundown','=',$key->id)->where('deleted_by','=',null)->first();
                                                if($selected!=null){
                                                echo "selected";
                                                }
                                                @endphp
                                                >
                                                {{$dataJadwalModul->modul_r->modul}}</option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <td style="text-align:center;width:5%">
                                        <a class="btn btn-success btn-xs"
                                            href="{{ url('aturjadwal/'.$id_jadwal.'/'.$key->id.'/uploadquiz') }}"><i
                                                class="fa fa-upload"></i> Upload </a>                                   
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="box-footer" style="text-align:left">
                            <button type="submit" class="btn btn-md btn-info"> <i class="fa fa-save"></i>
                                Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.MultiStep Form -->
    </div>
    <!-- /.box-body -->
    </div>
    <!-- /.box -->

    <!-- modal lampiran -->
    <div class="modal fade" id="modalFoto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
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
        $('.js-example-basic-multiple').select2();

        $(".select2-disabled").find('.select2-container--default').css('pointer-events', 'none');
        $(".select2-disabled > .select2-container--default > .selection > .select2-selection").css(
            'background-color', 'silver');

        var dt = $('#custom-table').DataTable({
            "lengthMenu": [
                [30, 50, 100],
                [30, 50, 100]
            ],
            "scrollX": true,
            "scrollY": $(window).height() - 255,
            "scrollCollapse": true,
            "searching": false,
            "autoWidth": false,
            "columnDefs": [{
                "searchable": false,
                "orderable": [
                    [3, "desc"]
                ],
                "targets": [0, 1]
            }]
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

    });

    $('.datepicker').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true
    });

</script>
@endpush
