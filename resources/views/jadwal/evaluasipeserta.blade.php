@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
<style>
    .checked {
        color: orange;
    }

</style>

<section class="content-header">
    <h1><a href="{{ url('jadwal/evaluasi/'.$id_jadwal.'/'.$id_instruktur.'/show') }}" class="btn btn-md bg-purple"><i
                class="fa fa-arrow-left"></i></a> Detail Peserta
        {{-- <small>it all starts here</small>  --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#">Detail Peserta</a></li>
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
                    <!-- <h3>Daftar Peserta</h3> -->
                    <table id="custom-table" class="table table-striped table-bordered dataTable customTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Tempat Lahir</th>
                                <th>Tanggal Lahir</th>
                                <th>Evaluasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($Peserta as $key)
                            <tr>
                                <td style="width:1%"></td>
                                <td>{{ $key->nik }}</td>
                                <td style="width:40%">{{ $key->nama }}</td>
                                <td style="width:10%">{{ $key->tmp_lahir }}</td>
                                <td style="text-align:center;width:8%">
                                    {{ \Carbon\Carbon::parse($key->tgl_lahir)->isoFormat("DD MMMM YYYY") }}</td>
                                <td style="text-align:center;width:8%"><button value="{{$id_jaw_evaluasi}}"
                                        idpeserta="{{$key->id}}" type="button"
                                        class="btn btn-sm btn-success btnLihat">Lihat</button></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.MultiStep Form -->

            <!-- Modal Penilaian -->

            <div class="modal fade" id="modalLihatEval" role="dialog">
                <div class="modal-dialog modal-lg" style="width:1500px">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header" style="text-align:left;background:#3c8dbc;color:white">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title" style="text-align:left"><b id="title-modal"></b></h4>
                        </div>
                        <div class="modal-body">
                            <!-- <div class="box">
                                <div class="box-body no-padding"> -->
                            <table class="table table-condensed tableModalDetail" id="tableModalEvaluasi">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Soal</th>
                                        <th>Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                            <!-- End -->
                            <div>
                                <table class="table table-condensed">
                                    <tbody>
                                        <tr>
                                            <td style="padding: 0px 25px 0px 0px;text-align:right">Buruk = <span
                                                    class='fa fa-star checked'></span><span
                                                    class='fa fa-star'></span><span class='fa fa-star'></span><span
                                                    class='fa fa-star'></span><span class='fa fa-star'></span></td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 0px 25px 0px 0px;text-align:right">Kurang = <span
                                                    class='fa fa-star checked'></span><span
                                                    class='fa fa-star checked'></span><span
                                                    class='fa fa-star'></span><span class='fa fa-star'></span><span
                                                    class='fa fa-star'></span></td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 0px 25px 0px 0px;text-align:right">Cukup = <span
                                                    class='fa fa-star checked'></span><span
                                                    class='fa fa-star checked'></span><span
                                                    class='fa fa-star checked'></span><span
                                                    class='fa fa-star'></span><span class='fa fa-star'></span></td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 0px 25px 0px 0px;text-align:right">Bagus = <span
                                                    class='fa fa-star checked'></span><span
                                                    class='fa fa-star checked'></span><span
                                                    class='fa fa-star checked'></span><span
                                                    class='fa fa-star checked'></span><span class='fa fa-star'></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 0px 25px 0px 0px;text-align:right">Memuaskan = <span
                                                    class='fa fa-star checked'></span><span
                                                    class='fa fa-star checked'></span><span
                                                    class='fa fa-star checked'></span><span
                                                    class='fa fa-star checked'></span><span
                                                    class='fa fa-star checked'></span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End -->
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

        // Show Modal Penilaian
        $('.btnLihat').on('click', function () {
            id_jaw_ev = $(this).attr("value");
            id_peserta = $(this).attr("idpeserta");
            lihatEvaluasi(id_jaw_ev, id_peserta);
        });

        // Fungsi Lihat Evaluasi
        function lihatEvaluasi(id_jaw_ev, id_peserta) {
            var url = "{{ url('instruktur/lihatevaluasi') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    id_jaw_ev: id_jaw_ev,
                    id_peserta: id_peserta
                },
                success: function (data) {
                    console.log(data)
                    console.log(data.length)
                    $('#tableModalEvaluasi > tbody').html('');
                    if (data.length > 0) {
                        $("#title-modal").text("Penilaian");
                        for (index = 0; index < data.length; index++) {
                            jumlahbintang = data[index]['nilai'];
                            bintang = "";
                            for (index2 = 1; index2 <= 5; index2++) {
                                if (index2 <= jumlahbintang) {
                                    bintang += "<span class='fa fa-star checked'></span>";
                                } else {
                                    bintang += "<span class='fa fa-star'></span>";
                                }
                            }
                            $('#tableModalEvaluasi > tbody:last').append(`
                            <tr>
                                <td style='width:1%;text-align:center'>
                                    ` + (index + 1) + `
                                </td>
                                <td style='width:40%;text-align:left'>
                                    ` + data[index]['soal_r']['materi'] + `
                                </td>
                                <td style='text-align:center;width:3%'>
                                 ` + bintang + `
                                </td>
                            </tr>`);
                        }
                        $('#modalLihatEval').modal('show');
                    } else {
                        Swal.fire({
                            title: "Peserta Belum Memberikan Penilaian",
                            type: 'error',
                            confirmButtonText: 'Close',
                            confirmButtonColor: '#AAA'
                        });
                        // alert('Peserta Belum Memberikan Penilaian');
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
