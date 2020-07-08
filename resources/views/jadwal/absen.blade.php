@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Absen
        {{-- <small>it all starts here</small>  --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#">Absen</a></li>
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
                <!-- <div class="col-md-7">
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

                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table no-margin">
                                <thead>
                                    <tr>
                                        <th style="text-align:left;padding: 6px;"><button id="btnkirim" type="button"
                                                class="btn btn-block btn-info btn-flat">Kirim User Account</button>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                </div> -->
                <div class="col-md-12">
                    <h3>Daftar Absensi Peserta</h3>
                    <table id="custom-table" class="table table-striped table-bordered dataTable customTable">
                        <thead>
                            <tr>
                                <th><i class="fa fa-check-square-o"></i></th>
                                <th>No</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Tanggal</th>
                                <th>Jam Masuk</th>
                                <th>Foto Masuk</th>
                                <th>Jam Keluar</th>
                                <th>Foto Keluar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($absen as $key)
                            <tr>
                                <td style='width:1%'><input type="checkbox" data-id="{{ $key->id }}" class="selection"
                                        id="selection[]" name="selection[]"></td>
                                <td style="width:1%"></td>
                                <td>{{ $key->peserta_r->nik }}</td>
                                <td style="text-align:left;width:40%">{{ $key->peserta_r->nama }}</td>
                                <td style="text-align:center;width:8%">{{ \Carbon\Carbon::parse($key->tanggal)->isoFormat("DD MMMM YYYY") }}</td>
                                <td style="text-align:center;width:8%">
                                @if (isset($key->jam_cek_in))
                                {{ \Carbon\Carbon::parse($key->jam_cek_in)->toTimeString() }}
                                @else

                                @endif
                                </td>
                                <td style="text-align:center;width:8%">
                                    @if (isset($key->foto_cek_in))
                                    <button class="btn btn-success btn-xs"
                                        onclick='tampilFoto("{{ asset("uploads/peserta/$key->foto_cek_in") }}","Jam Masuk {{ \Carbon\Carbon::parse($key->jam_cek_in)->toTimeString() }}")'><i
                                            class="fa fa-picture-o"></i> Lihat </button>
                                    @else
                                    <button class="btn btn-danger btn-xs"> Belum Absen </button>
                                    @endif
                                </td>
                                <td style="text-align:center;width:8%">
                                @if (isset($key->jam_cek_in))
                                {{ \Carbon\Carbon::parse($key->jam_cekout)->toTimeString() }}
                                @else

                                @endif
                                </td>
                                <td style="text-align:center;width:8%">
                                    @if (isset($key->foto_cekout))
                                    <button class="btn btn-success btn-xs"
                                        onclick='tampilFoto("{{ asset("uploads/peserta/$key->foto_cekout") }}","Jam Keluar {{ \Carbon\Carbon::parse($key->jam_cekout)->toTimeString() }}")'><i
                                            class="fa fa-picture-o"></i> Lihat </button>
                                    @else
                                    <button class="btn btn-danger btn-xs"> Belum Absen </button>
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
        <br>
        <a href="{{ url('jadwal/'.$data->id.'/dashboard') }}" class="btn btn-md btn-info"><i
                class="fa fa-times-circle"></i> Kembali</a>
        <br><br>
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
                           <img id="imgFoto" src="" alt=""  width="100%">
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
                "orderable": [[ 3, "desc" ]],
                "targets": [0, 1]
            }],
            "aaSorting": [[ 4, "desc" ],[ 3, "asc" ]]
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
