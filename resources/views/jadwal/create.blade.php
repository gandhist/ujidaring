@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Tambah Jadwal
        {{-- <small>it all starts here</small>  --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#">Jadwal</a></li>
    </ol>


</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box box-content">
        <div class="box-body">



            <!-- MultiStep Form -->
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('jadwal.store') }}" id="msform" name="msform" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <!-- progressbar -->
                        <ul id="progressbar">
                            <li class="active">Jadwal</li>
                            <li>Instruktur</li>
                            <li>Peserta</li>
                            <li>Soal</li>
                        </ul>
                        <!-- fieldsets -->
                        <fieldset>
                            <div class="row">
                                <div class="col-sm-6">
                                    <h2 class="fs-title">Jadwal</h2>
                                    <table class="table table-condensed table-input">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="input-group">
                                                        <input id="tgl_awal" name="tgl_awal" autocomplete="off"
                                                            data-provide="datepicker" data-date-format="dd/mm/yyyy"
                                                            type="text" class="form-control "
                                                            placeholder="Tanggal Mulai" required>
                                                        <span class="input-group-addon ">s/d</span>
                                                        <input id="tgl_akhir" name="tgl_akhir" autocomplete="off"
                                                            data-provide="datepicker" data-date-format="dd/mm/yyyy"
                                                            type="text" class="form-control "
                                                            placeholder="Tanggal Selesai" required>
                                                    </div>
                                                </td>
                                                <td>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input name="tuk" id="tuk" type="text" class="form-control"
                                                        placeholder="Tempat Uji Kompetensi" value="{{old('tuk')}}" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="input-group">
                                                        <select class="form-control select2" name="id_jenis_usaha"
                                                            id="id_jenis_usaha" required>
                                                            <option selected value="">Jenis Usaha</option>
                                                            @foreach($jenisusaha as $key)
                                                            <option value="{{ $key->id }}"
                                                                {{ $key->id == '1'  ? 'selected' : '' }}>
                                                                {{ $key->nama_jns_usaha }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="input-group">
                                                        <select class="form-control select2" name="id_bidang"
                                                            id="id_bidang" required>
                                                            <option selected value="">Bidang</option>
                                                            @foreach($bidang as $key)
                                                            <option value="{{ $key->id }}">{{ $key->nama_bidang }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="input-group">
                                                        <select class="form-control select2" name="id_sert_alat"
                                                            id="id_sert_alat" required>
                                                            <option selected value="">Sertifikat Alat</option>
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-sm-6">
                                    <h2 class="fs-title">Persyaratan</h2>
                                    <textarea id="persyaratan" style="text-align:left;height:195px;resize: none;"
                                        readonly>

                                    </textarea>
                                </div>
                            </div>

                            <input id="id_jumlah_detail" name="id_jumlah_detail" type="hidden" value="">

                            <h2 class="fs-title">Modul</h2>
                            <table id="table-modul" class="table table-bordered table-Detail">
                                <thead>
                                    <tr>
                                        <th style="width:3%">No</th>
                                        <th>Modul</th>
                                        <th style="width:7%">Pertemuan</th>
                                        <th>Hapus</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                            <input id="next1" type="button" name="next" class="next action-button" value="Berikutnya" />
                        </fieldset>
                        <fieldset>
                            <input type="hidden" id="id_detail_instruktur" name="id_detail_instruktur" value="">
                            <h2 class="fs-title">Instruktur</h2>
                            <div class="btn-group btn-lg pull-left" style='padding-left:10px'>
                                <button id="add_instruktur" type="button" class="btn btn-danger"
                                    style="border-radius: 25px;"><span class="fa fa-plus"></span> Tambah
                                    Instruktur</button>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <table id="instruktur-Detail" class="table table-bordered table-Detail">
                                    <thead>
                                        <tr>
                                            <th style="width: 3%">No</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th style="width:15%">Foto (.jpg/.jpeg/.png)</th>
                                            <th style="width:15%">KTP (.jpg/.jpeg/.png)</th>
                                            <th style="width:5%">Instruktur</th>
                                            <th style="width:5%">Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>

                            <input type="button" name="previous" class="previous action-button-previous"
                                value="Previous" />
                            <input type="button" name="next" class="next action-button" value="Berikutnya" />
                        </fieldset>
                        <fieldset>
                            <h2 class="fs-title">Peserta</h2>
                            <span class="pull-left"><b>Import Excel Data Peserta (.xls/.xlsx)</b></span>
                            <input type="file" name="excel_peserta" />
                            <input type="button" name="previous" class="previous action-button-previous"
                                value="Previous" />
                            <input type="button" name="next" class="next action-button" value="Berikutnya" />
                        </fieldset>
                        <fieldset>
                            <h2 class="fs-title">Soal</h2>
                            <span class="pull-left"><b>Import Excel Soal Pilihan Ganda (.xls/.xlsx)</b></span>
                            <input type="file" name="excel_soal_pg" />
                            <br>
                            <span class="pull-left"><b>Import Excel Soal Essay (.xls/.xlsx)</b></span>
                            <input type="file" name="excel_soal_essay" />

                            <input type="button" name="previous" class="previous action-button-previous"
                                value="Previous" />
                            <input type="submit" name="submit" class="submit action-button" value="Submit" />
                        </fieldset>
                    </form>
                </div>
            </div>
            <!-- /.MultiStep Form -->
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
    // $('.select2').val(null).trigger('change');
    var home = "{{ route('jadwal.index') }}";

    $(function () {

        //jQuery time
        var current_fs, next_fs, previous_fs; //fieldsets
        var left, opacity, scale; //fieldset properties which we will animate
        var animating; //flag to prevent quick multi-click glitches

        $(".next").click(function () {
            $("#tgl_akhir").css("border-color", "#ccc");
            $("#tgl_awal").css("border-color", "#ccc");
            $("#tuk").css("border-color", "#ccc");
            if ($("#tgl_awal").val() == '') {
                alert("Tanggal Mulai belum di input");
                $("#tgl_awal").css("border-color", "red");
                return false;
            }
            if ($("#tgl_akhir").val() == '') {
                alert("Tanggal Selesai belum di input");
                $("#tgl_akhir").css("border-color", "red");
                return false;
            }
            if ($("#tuk").val() == '') {
                alert("Tempat Uji Kompetensi belum di input");
                $("#tuk").css("border-color", "red");
                return false;
            }
            if ($("#id_bidang").val() == '') {
                alert("Bidang belum di input");
                return false;
            }
            if ($("#id_sert_alat").val() == '') {
                alert("Sertifikat Alat belum di input");
                return false;
            }

            if (animating) return false;
            animating = true;

            current_fs = $(this).parent();
            next_fs = $(this).parent().next();

            //activate next step on progressbar using the index of next_fs
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

            //show the next fieldset
            next_fs.show();
            //hide the current fieldset with style
            current_fs.animate({
                opacity: 0
            }, {
                step: function (now, mx) {
                    //as the opacity of current_fs reduces to 0 - stored in "now"
                    //1. scale current_fs down to 80%
                    scale = 1 - (1 - now) * 0.2;
                    //2. bring next_fs from the right(50%)
                    left = (now * 50) + "%";
                    //3. increase opacity of next_fs to 1 as it moves in
                    opacity = 1 - now;
                    current_fs.css({
                        'transform': 'scale(' + scale + ')',
                        'position': 'relative'
                    });
                    next_fs.css({
                        'left': left,
                        'opacity': opacity
                    });
                },
                duration: 100,
                complete: function () {
                    current_fs.hide();
                    animating = false;
                },
                //this comes from the custom easing plugin
                easing: 'easeInOutBack'
            });
        });

        $(".previous").click(function () {
            if (animating) return false;
            animating = true;

            current_fs = $(this).parent();
            previous_fs = $(this).parent().prev();

            //de-activate current step on progressbar
            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

            //show the previous fieldset
            previous_fs.show();
            //hide the current fieldset with style
            current_fs.animate({
                opacity: 0
            }, {
                step: function (now, mx) {
                    //as the opacity of current_fs reduces to 0 - stored in "now"
                    //1. scale previous_fs from 80% to 100%
                    scale = 0.8 + (1 - now) * 0.2;
                    //2. take current_fs to the right(50%) - from 0%
                    left = ((1 - now) * 50) + "%";
                    //3. increase opacity of previous_fs to 1 as it moves in
                    opacity = 1 - now;
                    current_fs.css({
                        'left': left
                    });
                    previous_fs.css({
                        'transform': 'scale(' + scale + ')',
                        'opacity': opacity
                    });
                },
                duration: 50,
                complete: function () {
                    current_fs.hide();
                    animating = false;
                },
                //this comes from the custom easing plugin
                easing: 'easeInOutBack'
            });
        });

        // $(".submit").click(function () {
        //     return false;
        // });

        //Kunci Input No Hp Hanya Angka
        // $('#id_no_telp,#id_hp_p,#id_hp_kp,#id_norek_bank').on('input blur paste', function () {
        //     $(this).val($(this).val().replace(/\D/g, ''))
        // })

    });

    //Initialize Select2 Elements
    $('.select2').select2();

    // Readonly Jenis Usaha 
    $("#id_jenis_usaha").parent().find('.select2-container--default').css('pointer-events', 'none');
    $("#id_jenis_usaha").parent().find('.select2-selection--single').css('background', 'silver');

    // Bidang Change
    $('#id_bidang').on('select2:select', function () {
        var url = `{{ url('bidang/chain') }}`;
        chainedBidang(url, 'id_bidang', 'id_sert_alat', "Sertifikat Alat");
        $("#persyaratan").html("");
        $("#table-modul tbody").html("");
        id_detail = [];
        $('#id_jumlah_detail').val(id_detail);
    });

    // Get Data Modul
    $('#id_sert_alat').on('select2:select', function () {
        id_sert_alat = $(this).val();
        getDataModul(id_sert_alat);
    });

    // Add baris instruktur
    $('#add_instruktur').on('click', function () {
        add_row_instruktur(no_instruktur);
        id_detail_instruktur.push(no_instruktur);
        $('#id_detail_instruktur').val(id_detail_instruktur);
        no_instruktur++;
    });

    //Button Hapus Baris Detail Modul
    $(document).on('click', '.btn-detail-hapus', function (e) {
        nomor = $(this).attr('nomor');
        id_detail = jQuery.grep(id_detail, function (value) {
            return value != nomor;
        });
        $('#id_jumlah_detail').val(id_detail);
        $(this).closest('tr').remove();
    });

    // Button hapus instuktur
    $(document).on('click', '.btn-hapus-intruktur', function (e) {
        nomor_instruktur = $(this).attr('nomor_instruktur');
        id_detail_instruktur = jQuery.grep(id_detail_instruktur, function (value) {
            return value != nomor_instruktur;
        });
        $('#id_detail_instruktur').val(id_detail_instruktur);
        $(this).closest('tr').remove();
    });

    // Jumlah detail modul
    var id_detail = [];

    // Jumlah detail instruktur
    var no_instruktur = 1;
    var id_detail_instruktur = [];

    function getDataModul(id_sert_alat) {
        var url = "{{ url('getDataModul/chain') }}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            method: 'POST',
            data: {
                id_sert_alat: id_sert_alat
            },
            success: function (data) {

                if (data.length > 0) {
                    $("#persyaratan").html(data[0]["persyaratan"] +
                        "&#13;&#10;&#13;&#10;Jumlah Hari: " + data[0]["hari"] + " hari");
                    $("#table-modul tbody").html("");
                    var number = 1;
                    data.forEach(function (item) {
                        add_row(number, item);
                        id_detail.push(number);
                        number++;
                    });
                } else {
                    id_detail = [];
                    $("#persyaratan").html('Tidak Ada Data');
                    $("#table-modul tbody").html("<tr><td colspan='4'>Tidak Ada Data</td></tr>");
                }
                $('#id_jumlah_detail').val(id_detail);

            },
            error: function (xhr, status) {
                alert('Error');
            }
        });
    };

    // Fungsi Tambah Baris Modul
    function add_row(no, item) {
        $('#table-modul > tbody:last').append(`
            <tr>
                    <input type="hidden" value="` + item['id'] + `" name="id_modul_` + no + `">
                                <td>` + no + `</td>
                                            <td><input value="` + item['modul'] + `" type="text" class="form-control" readonly></td>
                                            <td><input type="text" value="` + item['jp'] + `" class="form-control" readonly></td>
                                <td style="width:5%"><button type="button"
                                        class="btn btn-block btn-danger btn-sm btn-detail-hapus" nomor="` + no + `" ><span class="fa fa-trash"></span></button></td>
                            </tr>
            `);
    };

    // Fungsi Tambah Baris Instruktur
    function add_row_instruktur(no) {
        $('#instruktur-Detail > tbody:last').append(`
            <tr>
                   
                                <td>` + no + `</td>
                                            <td><input maxlength="16" id="nik_instruktur_` + no +
            `" name="nik_instruktur_` + no + `" type="text" class="form-control" placeholder="NIK" required></td>
                                            <td><input name="nama_instruktur_` + no + `" type="text" class="form-control" placeholder="Nama" required></td>
                                            <td><input name="foto_instruktur_` + no + `" type="file" class="form-control" style="padding:5px"></td>
                                            <td><input name="pdf_instruktur_` + no +
            `"type="file" class="form-control" style="padding:5px"></td>
                                             <td><input style="margin-top: 10px;" name="tipe_instruktur_` + no +
            `"type="checkbox"></td>
                                <td style="width:5%"><button type="button"
                                        class="btn btn-block btn-danger btn-sm btn-hapus-intruktur" nomor_instruktur="` +
            no + `" ><span class="fa fa-trash"></span></button></td>
                            </tr>
            `);

        // Kunci Input NIK Hanya Angka
        $('#nik_instruktur_' + no).on('input blur paste', function () {
            $(this).val($(this).val().replace(/\D/g, ''))
        })
    };


    $('.datepicker').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true
    });

</script>
@endpush
