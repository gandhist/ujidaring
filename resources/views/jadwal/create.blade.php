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
                    <form id="msform">
                        <!-- progressbar -->
                        <ul id="progressbar">
                            <li class="active">Jadwal</li>
                            <li>Social Profiles</li>
                            <li>Account Setup</li>
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
                                                        <input id="f_awal_terbit" name="f_awal_terbit"
                                                            value="{{ request()->get('f_awal_terbit') }}"
                                                            autocomplete="off" data-provide="datepicker"
                                                            data-date-format="dd/mm/yyyy" type="text"
                                                            class="form-control " placeholder="Tanggal Mulai">
                                                        <span class="input-group-addon ">s/d</span>
                                                        <input id="f_akhir_terbit" name="f_akhir_terbit"
                                                            value="{{ request()->get('f_akhir_terbit') }}"
                                                            autocomplete="off" data-provide="datepicker"
                                                            data-date-format="dd/mm/yyyy" type="text"
                                                            class="form-control " placeholder="Tanggal Selesai">
                                                    </div>
                                                </td>
                                                <td>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input name="id_prov_naker" id="id_prov_naker" type="text"
                                                        class="form-control" placeholder="Tempat Uji Kompetensi"
                                                        value="">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="input-group">
                                                        <select class="form-control select2" name="id_jenis_usaha"
                                                            id="id_jenis_usaha">
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
                                                            id="id_bidang">
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
                                                            id="id_sert_alat">
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


                            <h2 class="fs-title">Modul</h2>
                            <!-- <h3 class="fs-subtitle">Your presence on the social network</h3> -->

                            <!-- <div class="box-body"> -->
                            <table id="table-modul" class="table table-bordered table-Detail">
                                <thead>
                                    <tr>
                                        <th style="width:3%">No</th>
                                        <th>Modul</th>
                                        <th style="width:10%">Pertemuan</th>
                                        <th>Hapus</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                            <!-- </div> -->
                            <!-- <h3 class="fs-subtitle">Data Jadwal Sertifikasi</h3> -->
                            <!-- 
                            <input type="text" name="fname" placeholder="First Name" />
                            <input type="text" name="lname" placeholder="Last Name" />
                            <input type="text" name="phone" placeholder="Phone" /> -->
                            <input type="button" name="next" class="next action-button" value="Next" />
                        </fieldset>
                        <fieldset>
                            <h2 class="fs-title">Social Profiles</h2>
                            <h3 class="fs-subtitle">Your presence on the social network</h3>
                            <input type="text" name="twitter" placeholder="Twitter" />
                            <input type="text" name="facebook" placeholder="Facebook" />
                            <input type="text" name="gplus" placeholder="Google Plus" />
                            <input type="button" name="previous" class="previous action-button-previous"
                                value="Previous" />
                            <input type="button" name="next" class="next action-button" value="Next" />
                        </fieldset>
                        <fieldset>
                            <h2 class="fs-title">Create your account</h2>
                            <h3 class="fs-subtitle">Fill in your credentials</h3>
                            <input type="text" name="email" placeholder="Email" />
                            <input type="password" name="pass" placeholder="Password" />
                            <input type="password" name="cpass" placeholder="Confirm Password" />
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
                        'position': 'absolute'
                    });
                    next_fs.css({
                        'left': left,
                        'opacity': opacity
                    });
                },
                duration: 400,
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
                duration: 400,
                complete: function () {
                    current_fs.hide();
                    animating = false;
                },
                //this comes from the custom easing plugin
                easing: 'easeInOutBack'
            });
        });

        $(".submit").click(function () {
            return false;
        })

        //Kunci Input No Hp Hanya Angka
        $('#id_no_telp,#id_hp_p,#id_hp_kp,#id_norek_bank').on('input blur paste', function () {
            $(this).val($(this).val().replace(/\D/g, ''))
        })

    });

    //Initialize Select2 Elements
    $('.select2').select2()

    // Readonly Jenis Usaha 
    // $("#id_jenis_usaha").parent().find('.select2-container--default').css('pointer-events', '');

    // Bidang Change
    $('#id_bidang').on('select2:select', function () {
        var url = `{{ url('bidang/chain') }}`;
        chainedBidang(url, 'id_bidang', 'id_sert_alat', "Sertifikat Alat");
    });

    $('#id_sert_alat').on('select2:select', function () {
        id_sert_alat = $(this).val();
        getDataModul(id_sert_alat);
    });

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
                    $("#persyaratan").html(data[0]["persyaratan"]+"&#13;&#10;&#13;&#10;Jumlah Hari: "+data[0]["hari"]+" hari");
                    $("#table-modul tbody").html("");
                    var number = 1;
                    data.forEach(function (item) {
                        add_row(number, item);
                        number++;
                    });
                } else {
                    $("#persyaratan").html('Tidak Ada Data');
                    $("#table-modul tbody").html("<tr><td colspan='4'>Tidak Ada Data</td></tr>");
                }


            },
            error: function (xhr, status) {
                alert('Error');
            }
        });
    }

    // Fungsi Tambah Baris Modul
    function add_row(no, item) {
        $('#table-modul > tbody:last').append(`
            <tr>
                    <input type="hidden" name="id_sert_alat_` + no + `">
                                <td>` + no + `</td>
                                            <td><input value="` + item['modul'] + `" type="text" class="form-control" readonly></td>
                                            <td><input type="text" value="` + item['jp'] + `" class="form-control" readonly></td>
                                <td style="width:5%"><button type="button"
                                        class="btn btn-block btn-danger btn-sm btn-detail-hapus" nomor="` + no + `" ><span class="fa fa-trash"></span></button></td>
                            </tr>
            `);
    }

    $('.datepicker').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true
    })

</script>
@endpush
