@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><a href="{{ url('jadwal/evaluasi/'.$id_jadwal) }}" class="btn btn-md bg-purple"><i
                class="fa fa-caret-left"></i> Kembali</a> Detail Evaluasi
        {{-- <small>it all starts here</small>  --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#">Detail Evaluasi</a></li>
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
            <form action="{{ url('jadwal/evaluasi/'.$id_jadwal.'/'.$instruktur->id.'/filter') }}" enctype="multipart/form-data" name="filterData"
                id="filterData">
                @csrf
                <input type="hidden" name="id_jadwal" value="{{$data->id}}">
                <div class="row">
                    <div class="col-md-7">
                        <div class="box-body">
                            <div class="table-responsive" style="margin-left: -18px;">
                                <table class="table no-margin">
                                    <thead>
                                        <tr>
                                            <th style="width:5%">
                                                <div class="input-group">
                                                    <span class="input-group-addon customInput">Tanggal</span>
                                                    <input id="f_tgl_awal" name="f_tgl_awal"
                                                        value="{{ request()->get('f_tgl_awal') }}" autocomplete="off"
                                                        data-provide="datepicker" data-date-format="dd/mm/yyyy"
                                                        type="text" class="form-control customInput"
                                                        placeholder="Tgl Awal">
                                                    <span class="input-group-addon customInput">s/d</span>
                                                    <input id="f_tgl_akhir" name="f_tgl_akhir"
                                                        value="{{ request()->get('f_tgl_akhir') }}" autocomplete="off"
                                                        data-provide="datepicker" data-date-format="dd/mm/yyyy"
                                                        type="text" class="form-control customInput"
                                                        placeholder="Tgl Akhir">
                                                </div>
                                            </th>
                                            <th style="text-align:left;width:5%">
                                                <button type="submit" class="btn btn-sm btn-info"> <i
                                                        class="fa fa-filter"></i>
                                                    Filter</button>
                                            </th>
                                            <th style="text-align:left">
                                                <a href="{{ url('jadwal/evaluasi/'.$id_jadwal.'/'.$instruktur->id.'/show') }}"
                                                    class="btn btn-sm btn-default"> <i class="fa fa-refresh"></i>
                                                    Reset</a>
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-md-12">
                    <h3 style="text-align:left">{{$instruktur->nama}}</h3>
                    <table id="custom-table" class="table table-striped table-bordered dataTable customTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Detail Peserta</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jawEvaluasi as $key)
                            <tr>
                                <td style="width:1%"></td>
                                <td>{{ \Carbon\Carbon::parse( $key->tanggal )->isoFormat("DD MMMM YYYY") }}</td>
                                <td style="text-align:center;width:10%"><a href="{{ url('jadwal/evaluasi/'.$id_jadwal.'/'.$key->id.'/peserta') }}" style="width:100%" type="button" class="btn btn-sm bg-olive btn-flat">Lihat</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
    </div>
    <!-- end of modal konfirmais -->

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

        var dt = $('#custom-table').DataTable({
            "lengthMenu": [
                [10, 20, 50],
                [10, 20, 50]
            ],
            "scrollX": true,
            "scrollY": $(window).height() - 255,
            "scrollCollapse": true,
            "searching": false,
            "bPaginate": false,
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
