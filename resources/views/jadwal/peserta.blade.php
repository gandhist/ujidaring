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
                                        <th style="text-align:left;padding-bottom:0px;padding-top:0px"><button id="btnkirim" type="button"
                                                class="btn btn-block btn-info btn-flat">Kirim User Account</button>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th style="text-align:left;padding-bottom:0px;padding-top:2px"><button id="btndetail" type="button"
                                                class="btn btn-block btn-warning btn-flat">Detail</button>
                                        </th>
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

            <!-- Modal Penilaian -->
            @foreach($Peserta as $key)
            <div class="modal fade" id="modal_{{$key->id}}" role="dialog">
                <div class="modal-dialog modal-lg" style="width:1500px">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header" style="text-align:left;background:#3c8dbc;color:white">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><b>{{$key->nama}}</b></h4>
                        </div>
                        <div class="modal-body">
                            <div class="box">
                                <form action="{{ route('penilaian.update', $key->id ) }}" class="form-horizontal"
                                    id="formAdd" name="formAdd" method="post" enctype="multipart/form-data">
                                    @method("PATCH")
                                    @csrf
                                    <div class="box-body no-padding">
                                        <br>
                                        <table class="table table-condensed" id="tableModalDetailAhli">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Soal</th>
                                                    <th>Jawaban Peserta</th>
                                                    <th>Jawaban Sebenarnya</th>
                                                    <th>Bobot</th>
                                                    <th>Ceklis jika sesuai</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <input type="hidden" name="jumlah_jawaban_{{$key->id}}"
                                                    value="{{count($key->jawaban_essay_r)}}">
                                                @foreach($key->jawaban_essay_r as $jawaban)
                                                <tr>
                                                    <input type="hidden"
                                                        name="{{$key->id}}_id_jawaban_{{ $loop->iteration }}"
                                                        value="{{ $jawaban->id }}">
                                                    <td style="width:1%">{{ $loop->iteration }}</td>
                                                    <td><textarea style="width: 100%;resize: none;" readonly name=""
                                                            id="" rows="5">{{ $jawaban->soal_r->soal }}</textarea></td>
                                                    <td><textarea style="width: 100%;resize: none;" readonly name=""
                                                            id="" rows="5">{{ $jawaban->jawaban }}</textarea></td>
                                                    <td><textarea style="width: 100%;resize: none;" readonly name=""
                                                            id="" rows="5">{{ $jawaban->soal_r->jawaban }}</textarea>
                                                    </td>
                                                    <td style="width:2%"><input
                                                            name="{{$key->id}}_bobot_{{ $loop->iteration }}" type="text"
                                                            maxlength="2" class="Inputbobot" required></td>
                                                    <td style="width:10%;text-align:center"><input
                                                            name="{{$key->id}}_istrue_{{ $loop->iteration }}"
                                                            type="checkbox"></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="box-footer">
                                        <div class="row">
                                            <div class="col-sm-6" style="text-align:right">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Batal</button>
                                            </div>
                                            <div class="col-sm-6" style="text-align:left">
                                                <button id="btnUpdateNilai" type="submit" class="btn btn-md btn-danger">
                                                    <i class="fa fa-save"></i>
                                                    Simpan Nilai</button>
                                            </div>
                                        </div>


                                    </div>
                                </form>
                            </div>
                            <!-- End -->
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal fade" id="modal_jawab_{{$key->id}}" role="dialog">
                <div class="modal-dialog modal-lg" style="width:1500px">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header" style="text-align:left;background:#3c8dbc;color:white">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><b>{{$key->nama}}</b></h4>
                        </div>
                        <div class="modal-body">
                            <div class="box">
                                <form action="{{ route('penilaian.update', $key->id ) }}" class="form-horizontal"
                                    id="formAdd" name="formAdd" method="post" enctype="multipart/form-data">
                                    @method("PATCH")
                                    @csrf
                                    <div class="box-body no-padding">
                                        <br>
                                        <table class="table table-condensed" id="tableModalDetailAhli">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Soal</th>
                                                    <th>Jawaban Peserta</th>
                                                    <th>Jawaban Sebenarnya</th>
                                                    <th>Bobot</th>
                                                    <th>Sesuai/Tidak Sesuai</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <input type="hidden" name="jumlah_jawaban_{{$key->id}}"
                                                    value="{{count($key->jawaban_essay_r)}}">
                                                @foreach($key->jawaban_essay_r as $jawaban)
                                                <tr>
                                                    <input type="hidden"
                                                        name="{{$key->id}}_id_jawaban_{{ $loop->iteration }}"
                                                        value="{{ $jawaban->id }}">
                                                    <td style="width:1%">{{ $loop->iteration }}</td>
                                                    <td><textarea style="width: 100%;resize: none;" readonly name=""
                                                            id="" rows="5">{{ $jawaban->soal_r->soal }}</textarea></td>
                                                    <td><textarea style="width: 100%;resize: none;" readonly name=""
                                                            id="" rows="5">{{ $jawaban->jawaban }}</textarea></td>
                                                    <td><textarea style="width: 100%;resize: none;" readonly name=""
                                                            id="" rows="5">{{ $jawaban->soal_r->jawaban }}</textarea>
                                                    </td>
                                                    <td style="width:2%"><input
                                                            name="{{$key->id}}_bobot_{{ $loop->iteration }}" type="text"
                                                            maxlength="2" class="Inputbobot"
                                                            value="{{ $jawaban->nilai }}" readonly></td>
                                                    <td style="width:10%;text-align:center"><span><i
                                                                class="fa {{ $jawaban->is_true==1 ? 'fa-check' : 'fa-times' }} "
                                                                aria-hidden="true"></i></span></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>


                                </form>
                            </div>
                            <!-- End -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>
            @endforeach
            <!-- End -->

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
        $('.Inputbobot').on('input blur paste', function () {
            $(this).val($(this).val().replace(/\D/g, ''))
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
            }else if (id.length > 1) {
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
