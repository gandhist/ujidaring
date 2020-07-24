@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
<style>
    .card-header {
        padding: .75rem 1.25rem;
        margin-bottom: 0;
        background: skyblue;
        border: 1px solid rgba(0, 0, 0, .125);
    }

    .card-body {
        padding: 1.25rem;
        border: 1px solid rgba(0, 0, 0, .125);
    }

</style>
<section class="content-header">
    <h1><a href="{{ url('jadwal/peserta/'.$data->id) }}" class="btn btn-md bg-purple"><i
                class="fa fa-arrow-left"></i></a> Kelompok
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

            <!-- <div class="container"> -->
            <h2>Daftar Kelompok Peserta</h2>
            <p><strong>Note : </strong>Kelompok di generate oleh sistem secara otomatis</p>
            <div id="accordion">
                <div class="row">
                    @foreach ($datakelompok as $key)

                    <div class="card col-lg-4">
                        <a style="color:#333" class="card-link" data-toggle="collapse"
                            href="#collapse_{{$loop->iteration}}" aria-expanded="true">
                            <div class="card-header">
                                <h4>
                                    Kelompok {{$key->no_kelompok}} 
                                    <!-- <span style="float:right"><i class="fa fa-plus"
                                            aria-hidden="true"></i></span> -->
                                </h4>
                            </div>
                        </a>
                        <div id="collapse_{{$loop->iteration}}" class="collapse in" data-parent="#accordion">
                            <div class="card-body" style="font-size:16px">
                                    @php
                                    $no = 1;
                                    @endphp

                                    @foreach ($datapeserta as $data)
                                    @if ($data->no_kelompok==$key->no_kelompok)
                                    @if ($data->id_peserta==$key->id_ketua)
                                    {{$no}}. {{$data->peserta_r->nama}} <b>(Ketua)</b><br>
                                    @php
                                    $no++;
                                    @endphp
                                    @else
                                    {{$no}}. {{$data->peserta_r->nama}}<br>
                                    @php
                                    $no++;
                                    @endphp
                                    @endif
                                    @endif
                                    @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <!-- </div> -->

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script type="text/javascript">
    $(function () {

        // $(".card-link").on('click', function () {
        //     x = $(this).attr("href");
        //     y = $(x).attr("class");
        //     if (y == `collapse`) {
        //         $(this).children().children().children().html(
        //             `<i class="fa fa-minus" aria-hidden="true"></i>`);
        //     } else {
        //         $(this).children().children().children().html(
        //             `<i class="fa fa-plus" aria-hidden="true"></i>`);
        //     }
        // });

        var dt = $('#custom-table').DataTable({
            "lengthMenu": [
                [10, 20, 50],
                [10, 20, 50]
            ],
            'responsive': true,
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

        $('#btnbuatklp').on('click', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Buat Kelompok',
                text: "Apakah anda akan generate kelompok by sistem ?",
                icon: 'warning',
                buttons: true,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: "Batal",
                confirmButtonText: 'Ya'
            }).then((result) => {
                if (result.value) {
                    idjadwal = "{{$data->id}}";
                    buatkelompok(idjadwal);
                }
            });
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
            } else if (id.length > 1) {
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

        // Fungsi membuat kelompok
        function buatkelompok(idjadwal) {
            // alert(idjadwal);
            var url = "{{ url('bentukkelompok') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    idjadwal: idjadwal
                },
                success: function (data) {
                    Swal.fire({
                        title: data['message'],
                        type: data['status'],
                        confirmButtonText: 'Ok',
                        confirmButtonColor: '#AAA'
                    });
                },
                error: function (xhr, status) {
                    alert('Error');
                }
            });
        }
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
