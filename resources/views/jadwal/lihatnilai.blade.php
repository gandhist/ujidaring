@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><a href="{{ url('jadwal/'.$data->id.'/dashboard') }}" class="btn btn-md bg-purple"><i
                class="fa fa-arrow-left"></i></a> Daftar Nilai Peserta
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
                <form action="{{ url('jadwal/lihatnilai/filter') }}" enctype="multipart/form-data" name="filterData"
                    id="filterData" method="post">
                    @csrf
                    <input type="hidden" id="id_jadwal" name="id_jadwal" value="{{$data->id}}">
                    <div class="col-md-8">
                        <div class="table-responsive" style="margin-left: -18px;">
                            <table class="table no-margin">
                                <thead>
                                    <tr>
                                        <th style="width:5%">
                                            <div class="input-group">
                                                <span class="input-group-addon customInput">Tanggal</span>
                                                <input id="f_tgl_awal" name="f_tgl_awal"
                                                    value="{{ request()->get('f_tgl_awal') }}" autocomplete="off"
                                                    data-provide="datepicker" data-date-format="dd/mm/yyyy" type="text"
                                                    class="form-control customInput" placeholder="Tgl Awal">
                                                <span class="input-group-addon customInput">s/d</span>
                                                <input id="f_tgl_akhir" name="f_tgl_akhir"
                                                    value="{{ request()->get('f_tgl_akhir') }}" autocomplete="off"
                                                    data-provide="datepicker" data-date-format="dd/mm/yyyy" type="text"
                                                    class="form-control customInput" placeholder="Tgl Akhir">
                                            </div>
                                        </th>
                                        <!-- <th style="width:16%">
                                                <div class="input-group">
                                                    <select class="form-control select2" name="jenis_absen"
                                                        id="jenis_absen" required>
                                                        <option value="all">All</option>
                                                        <option value="absen" {{ request()->get("jenis_absen")=="absen" ? "selected" : "" }} >Sudah Absen</option>
                                                        <option value="belumabsen" {{ request()->get("jenis_absen")=="belumabsen" ? "selected" : "" }} >Belum Absen</option>
                                                    </select>
                                                </div>
                                            </th> -->
                                        <th style="text-align:left;width:5%">
                                            <button id="btnfilter" type="submit" class="btn btn-sm btn-info"> <i
                                                    class="fa fa-filter"></i>
                                                Filter</button>
                                        </th>
                                        <th style="text-align:left">
                                            <a href="{{ url('jadwal/lihatnilai', $id_jadwal) }}"
                                                class="btn btn-sm btn-default"> <i class="fa fa-refresh"></i>
                                                Reset</a>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="table-responsive">
                            <table class="table no-margin">
                                <thead>
                                    <tr>
                                        <th style="text-align:right"><button type="submit" id="btnexport"
                                                class="btn btn-sm btn-success"><i class="fa fa-file-excel-o"
                                                    aria-hidden="true"></i> Export Excel</button></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <input type="hidden" id="jenis" name="jenis" value="" >
                </form>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <!-- <h3>Daftar Absensi Peserta</h3> -->
                    <table id="custom-table" class="table table-striped table-bordered dataTable customTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Tanggal</th>
                                <th style="white-space: nowrap">Tipe Quiz</th>
                                <th style="white-space: nowrap">Jumlah Soal</th>
                                <th>Benar</th>
                                <th>Salah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($datanilai as $key)
                            <tr>
                                <td style="width:1%"></td>
                                <td>{{ $key->peserta_r->nik }}</td>
                                <td style="text-align:left;width:40%">{{ $key->peserta_r->nama }}</td>
                                <td style="text-align:center;width:8%">
                                    {{ \Carbon\Carbon::parse($key->created_at)->isoFormat("DD MMMM YYYY") }}</td>
                                <td>{{ ucwords($key->tipe_quis) }}</td>
                                <td style="width:1%">
                                    @if(strtolower($key->tipe_quis)=="pre")
                                    {{count($key->jumlah_soal_pre_r)}}
                                    @elseif (strtolower($key->tipe_quis)=="post")
                                    {{count($key->jumlah_soal_post_r)}}
                                    @else
                                    Error
                                    @endif
                                </td>
                                <td>{{ $key->benar }}</td>
                                <td>{{ $key->salah }}</td>
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
    <!-- <div class="modal fade" id="modal-konfirmasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
    </div> -->
    <!-- end of modal konfirmais -->

    <!-- modal foto -->
    <!-- <div class="modal fade" id="modalFoto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
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
    </div> -->
    <!-- end of modal foto -->

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

        $("#btnexport").on("click",function(){
            $("#jenis").val('export');
            return true;
        });

        $("#btnfilter").on("click",function(){
            $("#jenis").val('filter');
            return true;
        });

        var dt = $('#custom-table').DataTable({
            "lengthMenu": [
                [30, 50, 100],
                [30, 50, 100]
            ],
            "scrollX": true,
            "scrollY": $(window).height() - 255,
            "scrollCollapse": true,
            "autoWidth": false,
            "columnDefs": [{
                "searchable": false,
                "orderable": [
                    [3, "desc"]
                ],
                "targets": [0, 1]
            }],
            "aaSorting": [
                [3, "desc"],
                [2, "asc"]
            ]
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
        // $('.Inputbobot').on('input blur paste', function () {
        //     $(this).val($(this).val().replace(/\D/g, ''))
        // });

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

        // Export Excel
        // $('#exportexcel').on('click', function () {
        //     exportpeserta();
        // });

        // $('#btnkirim').on('click', function (e) {
        //     e.preventDefault();
        //     var id = [];
        //     $('.selection:checked').each(function () {
        //         id.push($(this).data('id'));
        //     });
        //     $("#idHapusData").val(id);
        //     if (id.length == 0) {
        //         Swal.fire({
        //             title: "Tidak ada data yang terpilih",
        //             type: 'warning',
        //             confirmButtonText: 'Close',
        //             confirmButtonColor: '#AAA'
        //         });
        //         // alert('Tidak ada data yang terpilih');
        //     } else {
        //         $('#modal-konfirmasi').modal('show');
        //     }
        // });

        // $('.select2').select2();

        // Fungsi Update durasi ujian
        function exportpeserta() {
            var tglawal = $("#f_tgl_awal").val();
            var tglakhir = $("#f_tgl_akhir").val();
            var idjadwal = $("#id_jadwal").val();
            // var url = "{{ url('jadwal/lihatnilai/exportexcel/"+tglawal+"/"+tglakhir+"/"+idjadwal+"') }}";

            var url = "{{ url('jadwal/lihatnilai/exportexcel', [':tglawal', ':tglakhir',':idjadwal']) }}";
            url = url.replace(':tglawal', tglawal).replace(':tglakhir', tglakhir).replace(':idjadwal',
                idjadwal);

            console.log(url);
            window.location(url);
            // $.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     }
            // });
            // $.ajax({
            //     url: url,
            //     method: 'GET'
            //     success: function (data) {
            //         window.open(url);
            //         console.log(data);
            //     },
            //     error: function (xhr, status) {
            //         alert('Error');
            //     }
            // });
        }
    });

    $('.datepicker').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true
    });

</script>
@endpush
