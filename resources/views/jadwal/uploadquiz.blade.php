@extends('templates.header')
@push('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
@endpush
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

    .tablecustom > th{
        border-top: 1px solid rgb(117, 117, 117) !important;
        border-left: 1px solid rgb(117, 117, 117) !important;
        border-right: 1px solid rgb(117, 117, 117) !important;
        border-bottom: 1px solid rgb(117, 117, 117) !important;
        text-align:center;
    }

    .tablecustom > td{
        border-top: 1px solid rgb(117, 117, 117) !important;
        border-left: 1px solid rgb(117, 117, 117) !important;
        border-right: 1px solid rgb(117, 117, 117) !important;
        border-bottom: 1px solid rgb(117, 117, 117) !important;
    }

    .tableModalDetail > thead > tr > th {
        border-bottom: 2px solid rgb(117, 117, 117) !important;
    }

</style>
<section class="content-header">
    <h1><a href="{{ url('jadwal/aturjadwal/'.$id_jadwal) }}" class="btn btn-md bg-purple"><i
                class="fa fa-arrow-left"></i></a> Quiz
        {{-- <small>it all starts here</small>  --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#">Quiz</a></li>
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
                    <h3>Upload Soal Quiz ({{ \Carbon\Carbon::parse($tanggal)->isoFormat("DD MMMM YYYY") }})</h3>
                    <form action="{{ url('aturjadwal/uploadquizstore') }}" class="form-horizontal" id="formAdd"
                        name="formAdd" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id_jadwal" value="{{ $id_jadwal }}">
                        <input type="hidden" name="jumlah" value="{{ count($modulrundown) }}">
                        <table id="custom-table" class="table table-striped table-bordered">
                            <thead style="background:skyblue">
                                <tr class="tablecustom">
                                    <th>No</th>
                                    <th>Modul</th>
                                    <th>Pre Quiz</th>
                                    <th>Mulai Pre</th>
                                    <th style="white-space: nowrap;width:5%">Durasi Pre</th>
                                    <th>Post Quiz</th>
                                    <th>Mulai Post</th>
                                    <th style="white-space: nowrap;width:5%">Durasi Post</th>
                                    <th style="white-space: nowrap" width="8%">Tugas Mandiri</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($modulrundown as $key)
                                <tr class="tablecustom">
                                    <input type="hidden" name="id_modul_rundown_{{ $loop->iteration }}"
                                        value="{{$key->id}}">
                                    <input type="hidden" name="id_jadwalmodul_{{ $loop->iteration }}"
                                        value="{{$key->jadwal_modul_r->id}}">
                                    <td style="width:1%">{{ $loop->iteration }}</td>
                                    <td>{{$key->jadwal_modul_r->modul_r->modul}}</td>
                                    <td style="width:10%">
                                        <div class="input-group input-group-sm">
                                            <input id="pre_quiz_{{ $loop->iteration }}" name="pre_quiz_{{ $loop->iteration }}" type="file">
                                            @if(isset($key->jadwal_modul_r->f_pre_quiz))
                                            <span class="input-group-btn">
                                                <button type="button" value="{{$key->jadwal_modul_r->id}}"
                                                    class="btn btn-info btn-flat btnLihatPre">Lihat</button>
                                            </span>
                                            @else
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <input id="awal_pre_{{ $loop->iteration }}"
                                            name="awal_pre_{{ $loop->iteration }}" type="text"
                                            class="form-control waktu" placeholder="Mulai Pre"
                                            value="{{$key->jadwal_modul_r->awal_pre_quiz}}">
                                    </td>
                                    <td><input style="width: 100%;" maxlength="3" class="form-control durasi" type="text" id="durasi_pre_{{ $loop->iteration }}" name="durasi_pre_{{ $loop->iteration }}"
                                            placeholder="Durasi Pre" value="{{$key->jadwal_modul_r->durasi_pre}}"></td>
                                    <td style="width:10%">
                                        <div class="input-group input-group-sm">
                                            <input name="post_quiz_{{ $loop->iteration }}" id="post_quiz_{{ $loop->iteration }}" type="file">
                                            @if(isset($key->jadwal_modul_r->f_post_quiz))
                                            <span class="input-group-btn">
                                                <button type="button" value="{{$key->jadwal_modul_r->id}}"
                                                    class="btn btn-info btn-flat btnLihatPost">Lihat</button>
                                            </span>
                                            @else
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <input id="awal_post_{{ $loop->iteration }}"
                                            name="awal_post_{{ $loop->iteration }}" type="text"
                                            class="form-control waktu" placeholder="Mulai Post"
                                            value="{{$key->jadwal_modul_r->awal_post_quiz}}">
                                    </td>
                                    <td><input style="width: 100%;" maxlength="3" class="form-control durasi" type="text" id="durasi_post_{{ $loop->iteration }}" name="durasi_post_{{ $loop->iteration }}"
                                            placeholder="Durasi Post" value="{{$key->jadwal_modul_r->durasi_post}}">
                                    </td>
                                    <td><input value="{{$key->jadwal_modul_r->jumlah_tm}}" style="width:100%"
                                            class="form-control InputTugasMandiri" name="tm_{{ $loop->iteration }}"
                                            type="text" maxlength="1"></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="box-footer" style="text-align:left">
                            <button id="simpan" type="submit" class="btn btn-md btn-info"> <i class="fa fa-save"></i>
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

    <!-- Modal Soal Pre -->
    <div class="modal fade" id="modalSoalPre" role="dialog">
        <div class="modal-dialog modal-lg" style="width:1500px">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="text-align:left;background:#3c8dbc;color:white">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 id="title-modalSoalPre" class="modal-title" style="text-align:center"></h4>
                </div>
                <div class="modal-body">
                    <div class="box">
                        <div class="box-body no-padding">
                            <br>
                            <table class="table table-condensed tableModalDetail" id="tablemodalSoalPre">
                                <thead>
                                    <tr>
                                        <th>
                                            No
                                        </th>
                                        <th>
                                            Soal
                                        </th>
                                        <th>
                                            A
                                        </th>
                                        <th>
                                            B
                                        </th>
                                        <th>
                                            C
                                        </th>
                                        <th>
                                            D
                                        </th>
                                        <th>
                                            Jawab
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- End -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End -->

    <!-- Modal Soal Post -->
    <div class="modal fade" id="modalSoalPost" role="dialog">
        <div class="modal-dialog modal-lg" style="width:1500px">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="text-align:left;background:#3c8dbc;color:white">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 id="title-modalSoalPost" class="modal-title" style="text-align:center"></h4>
                </div>
                <div class="modal-body">
                    <div class="box">
                        <div class="box-body no-padding">
                            <br>
                            <table class="table table-condensed tableModalDetail" id="tablemodalSoalPost">
                                <thead>
                                    <tr>
                                        <th>
                                            No
                                        </th>
                                        <th>
                                            Soal
                                        </th>
                                        <th>
                                            A
                                        </th>
                                        <th>
                                            B
                                        </th>
                                        <th>
                                            C
                                        </th>
                                        <th>
                                            D
                                        </th>
                                        <th>
                                            Jawab
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- End -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End -->

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

        $("#simpan").on('click', function () {
            z = "berhasil";
            jumlahData = "{{count($modulrundown)}}";
            for (let index = 1; index <= jumlahData; index++) {
                f_pre = $("#pre_quiz_"+index).val();
                if(f_pre!=""){
                    mulai_pre = $("#awal_pre_"+index).val();
                    durasi_pre = $("#durasi_pre_"+index).val();
                    if(mulai_pre==""){
                        alert('Mulai Pre Quiz '+index+' Harus diisi!');
                        z = "gagal";
                    }else if(durasi_pre==""){
                        alert('Durasi Pre Quiz '+index+' Harus diisi!');
                        z = "gagal";
                    }
                }

                f_post = $("#post_quiz_"+index).val();
                if(f_post!=""){
                    mulai_post = $("#awal_post_"+index).val();
                    durasi_post = $("#durasi_post_"+index).val();
                    if(mulai_post==""){
                        alert('Mulai Post Quiz '+index+' Harus diisi!');
                        z = "gagal";
                    }else if(durasi_post==""){
                        alert('Durasi Post Quiz '+index+' Harus diisi!');
                        z = "gagal";
                    }
                }
            }
            if(z=="gagal"){
                return false;
            }else{
                return true;
            }
        });

        $('.js-example-basic-multiple').select2();

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
        $('.InputTugasMandiri,.durasi').on('input blur paste', function () {
            $(this).val($(this).val().replace(/\D/g, ''))
        });

        // Show Modal Penilaian
        $('.btnLihatPre').on('click', function () {
            value_id = $(this).attr("value");
            lihatSoalPre(value_id);
        });

        // Show Modal Penilaian
        $('.btnLihatPost').on('click', function () {
            value_id = $(this).attr("value");
            lihatSoalPost(value_id);
        });

        // Fungsi Lihat Soal Pre
        function lihatSoalPre(value_id) {
            var url = "{{ url('jadwal/lihatsoalpre') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    value_id: value_id
                },
                success: function (data) {
                    // console.log(data)
                    console.log(data)
                    $('#tablemodalSoalPre > tbody').html("");
                    if (data.length > 0) {
                        $("#title-modalSoalPre").text("Soal Quiz Pre " + data[0]['jadwal_modul_r'][
                            'modul_r'
                        ]['modul']);
                        for (index = 0; index < data.length; index++) {
                            $('#tablemodalSoalPre > tbody:last').append(`
                            <tr>
                                <td style='width:1%;text-align:center'>
                                    ` + (index + 1) + `
                                </td>
                                <td style='text-align:left;width:40%'>
                                    ` + data[index]['soal'] + `
                                   
                                </td>
                                <td style='width:5%;text-align:left'>
                                    ` + data[index]['pg_a'] + `
                                </td>
                                <td style='width:5%;text-align:left'>
                                    ` + data[index]['pg_b'] + `
                                   
                                </td>
                                <td style='width:5%;text-align:left'>
                                    ` + data[index]['pg_c'] + `
                                   
                                </td>
                                <td style='width:5%;text-align:left'>
                                    ` + data[index]['pg_d'] + `
                                   
                                </td>
                                <td style='width:20%;text-align:left'>
                                    ` + data[index]['jawaban'] + `
                                   
                                </td>
                            </tr>`);
                        }
                        $('#modalSoalPre').modal('show');
                    }
                },
                error: function (xhr, status) {
                    alert('Error');
                }
            });
        }

        // Fungsi Lihat Soal Post
        function lihatSoalPost(value_id) {
            var url = "{{ url('jadwal/lihatsoalpost') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    value_id: value_id
                },
                success: function (data) {
                    // console.log(data)
                    console.log(data)
                    $('#tablemodalSoalPost > tbody').html("");
                    if (data.length > 0) {
                        $("#title-modalSoalPost").text("Soal Quiz Post " + data[0]['jadwal_modul_r']
                            [
                                'modul_r'
                            ]['modul']);
                        for (index = 0; index < data.length; index++) {
                            $('#tablemodalSoalPost > tbody:last').append(`
                            <tr>
                                <td style='width:1%;text-align:center'>
                                    ` + (index + 1) + `
                                </td>
                                <td style='text-align:left;width:40%'>
                                    ` + data[index]['soal'] + `
                                   
                                </td>
                                <td style='width:5%;text-align:left'>
                                    ` + data[index]['pg_a'] + `
                                </td>
                                <td style='width:5%;text-align:left'>
                                    ` + data[index]['pg_b'] + `
                                   
                                </td>
                                <td style='width:5%;text-align:left'>
                                    ` + data[index]['pg_c'] + `
                                   
                                </td>
                                <td style='width:5%;text-align:left'>
                                    ` + data[index]['pg_d'] + `
                                   
                                </td>
                                <td style='width:20%;text-align:left'>
                                    ` + data[index]['jawaban'] + `
                                   
                                </td>
                            </tr>`);
                        }
                        $('#modalSoalPost').modal('show');
                    }
                },
                error: function (xhr, status) {
                    alert('Error');
                }
            });
        }

    });

    $('.waktu').datetimepicker({
        locale: 'id',
        format: 'YYYY-MM-DD HH:mm:ss'
    });

</script>
@endpush
