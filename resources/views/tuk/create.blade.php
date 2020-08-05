@extends('templates/header')

@section('content')
<style>
    .custominp {
        border-radius: 5px !important;
        border-color: #aaa !important;
        height: 80% !important;
    }

</style>
<section class="content-header">
    <h1><a href="{{ url('mastermodul') }}" class="btn btn-md bg-purple"><i class="fa fa-arrow-left"></i></a>
        Tambah TUK Observasi PJK3 Mandiri
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Master TUK</a></li>
    </ol>
</section>
<section class="content">
    <div class="box box-content">
        <div class="box-body">
            <form class="form-horizontal" id="formAdd" name="formAdd" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <br>
                        <table class=" table-striped">
                            <tbody>
                                <tr>
                                    <td colspan="3" style="padding-bottom: 2px">
                                        <div class="input-group">
                                            <label>PJK3</label>
                                            <select class="form-control select2" name="id_badan_usaha"
                                                id="id_badan_usaha">
                                                <option selected disabled value="">PJK3</option>
                                                @foreach($badanusaha as $key)
                                                <option value="{{ $key->id }}">{{ $key->nama_bu }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <span id="id_badan_usaha" class="help-block customspan"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <div class="input-group" style="width:100%">
                                            <label>Nama TUK Observasi</label>
                                            <input type="text" class="form-control custominp" id="id_nama_tuk"
                                                name="id_nama_tuk" placeholder="Nama TUK Observasi">
                                        </div>
                                        <span id="id_nama_tuk" class="help-block customspan"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="width:100%">
                                        <!-- <div class="input-group"> -->
                                        <label>Alamat Jalan dan Nomor, Kelurahan, Kecamatan (Tanpa Kota)</label>
                                        <input type="text" class="form-control custominp" id="id_alamat_tuk"
                                            name="id_alamat_tuk"
                                            placeholder="Alamat Jalan dan Nomor, Kelurahan, Kecamatan (Tanpa Kota)">
                                        <!-- </div> -->
                                        <span id="id_alamat_tuk"
                                            class="help-block customspan">{{ $errors->first('id_alamat_tuk') }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:49%">
                                        <div class="input-group">
                                            <label>Provinsi</label>
                                            <select class="form-control select2" name="id_provinsi" id="id_provinsi">
                                                <option selected disabled value="">Provinsi</option>
                                                @foreach($provinsi as $key)
                                                <option value="{{ $key->id }}">{{ $key->nama }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <span id="id_provinsi" class="help-block customspan"></span>
                                    </td>

                                    <td style="width:2%">
                                        <div class="input-group">

                                        </div>
                                    </td>

                                    <td style="width:49%">
                                        <div class="input-group">
                                            <label>Kota</label>
                                            <select class="form-control select2" name="id_kota" id="id_kota">
                                                <option selected disabled value="">Kota</option>
                                                <!-- @foreach($kota as $key)
                                                <option value="{{ $key->id }}">{{ $key->nama }}
                                                </option>
                                                @endforeach -->
                                            </select>
                                        </div>
                                        <span id="id_kota" class="help-block customspan"></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="width:49%">
                                        <div class="input-group" style="width:100%">
                                            <label>No Tlp</label>
                                            <input type="text" class="form-control custominp" id="id_no_tlp"
                                                name="id_no_tlp" placeholder="No Tlp">
                                        </div>
                                        <span id="id_no_tlp" class="help-block customspan"></span>
                                    </td>

                                    <td style="width:2%">
                                        <div class="input-group">

                                        </div>
                                    </td>

                                    <td style="width:49%">
                                        <div class="input-group" style="width:100%">
                                            <label>Email</label>
                                            <input type="text" class="form-control custominp" id="id_email"
                                                name="id_email" placeholder="Email">
                                        </div>
                                        <span id="id_email" class="help-block customspan"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <div class="input-group" style="width:100%">
                                            <label>Instansi Pengelola</label>
                                            <input type="text" class="form-control custominp" id="id_pengelola"
                                                name="id_pengelola" placeholder="Instansi Pengelola">
                                        </div>
                                        <span id="id_pengelola" class="help-block customspan"></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="width:49%">
                                        <div class="input-group" style="width:100%">
                                            <label>Nama Kontak Person</label>
                                            <input type="text" class="form-control custominp" id="id_nama_kp"
                                                name="id_nama_kp" placeholder="Nama Kontak Person">
                                        </div>
                                        <span id="id_nama_kp" class="help-block customspan"></span>
                                    </td>

                                    <td style="width:2%">
                                        <div class="input-group">

                                        </div>
                                    </td>

                                    <td style="width:49%">
                                        <div class="input-group" style="width:100%">
                                            <label>Jabatan Kontak Person</label>
                                            <input type="text" class="form-control custominp" id="id_jab_kp"
                                                name="id_jab_kp" placeholder="Jabatan Kontak Person">
                                        </div>
                                        <span id="id_jab_kp" class="help-block customspan"></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="width:49%">
                                        <div class="input-group" style="width:100%">
                                            <label>No HP Kontak Person</label>
                                            <input type="text" class="form-control custominp" id="id_hp_kp"
                                                name="id_hp_kp" placeholder="No HP Kontak Person">
                                        </div>
                                        <span id="id_hp_kp" class="help-block customspan"></span>
                                    </td>

                                    <td style="width:2%">
                                        <div class="input-group">

                                        </div>
                                    </td>

                                    <td style="width:49%">
                                        <div class="input-group" style="width:100%">
                                            <label>Email Kontak Person</label>
                                            <input type="text" class="form-control custominp" id="id_email_kp"
                                                name="id_email_kp" placeholder="Email Kontak Person">
                                        </div>
                                        <span id="id_email_kp" class="help-block customspan"></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="3" style="width:100%">
                                        <!-- <div class="input-group"> -->
                                        <label>Keterangan</label>
                                        <input type="text" class="form-control custominp" id="id_keterangan"
                                            name="id_keterangan" placeholder="Keterangan">
                                        <!-- </div> -->
                                        <span id="id_keterangan"
                                            class="help-block customspan">{{ $errors->first('id_keterangan') }}</span>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="width:49%">
                                        <div class="input-group" style="width:100%">
                                            <label>No Rekening Bank</label>
                                            <input type="text" class="form-control custominp" id="id_no_rek"
                                                name="id_no_rek" placeholder="No Rekening Bank">
                                        </div>
                                        <span id="id_no_rek" class="help-block customspan"></span>
                                    </td>

                                    <td style="width:2%">
                                        <div class="input-group">

                                        </div>
                                    </td>

                                    <td style="width:49%">
                                        <div class="input-group" style="width:100%">
                                            <label>Nama Rekening Bank</label>
                                            <input type="text" class="form-control custominp" id="id_nama_rek"
                                                name="id_nama_rek" placeholder="Nama Rekening Bank">
                                        </div>
                                        <span id="id_nama_rek" class="help-block customspan"></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="3" style="padding-bottom: 2px">
                                        <div class="input-group">
                                            <label>Nama Bank</label>
                                            <select class="form-control select2" name="id_bank"
                                                id="id_bank">
                                                <option selected disabled value="">Nama Bank</option>
                                                @foreach($bank as $key)
                                                <option value="{{ $key->id }}">{{ $key->nama_bank }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <span id="id_bank" class="help-block customspan"></span>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                    <!-- <div class="col-md-8">
                        <br>
                        <table class=" table-striped">
                            <tbody>
                                <tr>
                                    <td style="width:100%">
                                     
                                        <label for="" style="">*Syarat</label><br>
                                        <textarea class="textarea" style="width: 100%;border-radius: 5px;height:158px"
                                            name="id_syarat" id="id_syarat" cols="175"></textarea>
                                      
                                        <span id="id_syarat"
                                            class="help-block customspan">{{ $errors->first('id_syarat') }}</span>
                                    </td>
                                </tr>
                                </thead>
                        </table>
                    </div> -->

                    <!-- <div class="col-sm-12">
                        <div class="btn-group btn-lg">
                            <button id="addrow" type="button" class="btn btn-success"><span class="fa fa-plus"></span>
                                Tambah
                                Modul</button>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="box-body" style="display: block;">
                            <div class="table-responsive">
                                <table id="tablemodul" class="table table-striped table-bordered dataTable customTable">
                                    <thead>
                                        <tr>
                                            <th style="width:1%">No</th>
                                            <th style="width:50%">Modul</th>
                                            <th>Jam Pertemuan</th>
                                            <th>Upload Materi (pdf,word,excel,ppt,mp4)</th>
                                            <th>Input Link</th>
                                            <th style="width:3%">Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> -->
                    <!-- /.col -->
                    <!-- <input id="jumlah_detail" name="jumlah_detail" type="hidden"> -->

                    <div class="col-lg-12">
                        <button type="button"
                            data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Sedang Proses..."
                            class="btn btn-info" name="btnSave" id="btnSave">Simpan</button>
                    </div>
                </div>
            </form>
            <br>
        </div>
    </div>
</section>
@endsection
@push('script')

<script>
    $(document).ready(function () {

        $('#btnSave').on('click', function (e) {
            e.preventDefault();
            store();
        });


        // Filter Kota Berdasarkan Provinsi
        $('#id_provinsi').on('select2:select', function () {
            var url = `{{ url('provinsi/chain') }}`;
            chainedProvinsi(url, 'id_provinsi', 'id_kota', "Kota");
        });

        $('#id_no_tlp , #id_no_rek').on('input blur paste', function () {
            $(this).val($(this).val().replace(/\D/g, ''));
        });

        $('.select2').select2();

    });


    function store() {
        var formData = new FormData($('#formAdd')[0]);

        var url = "{{ url('modul/save') }}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            type: 'POST',
            dataType: "JSON",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $.LoadingOverlay("show", {
                    image: "",
                    fontawesome: "fa fa-refresh fa-spin",
                    fontawesomeColor: "black",
                    fade: [5, 5],
                    background: "rgba(60, 60, 60, 0.4)"
                });
                // $("#btnSave").button('loading');
            },
            success: function (response) {
                // console.log(response);
                if (response.status) {
                    Swal.fire({
                        title: response.message,
                        type: response.icon,
                        confirmButtonText: 'Ok',
                        confirmButtonColor: '#AAA'
                    }).then(function () {
                        if (response.icon == "warning") {

                        } else {
                            window.history.back();
                        }
                    });
                }
            },
            error: function (xhr, status) {
                var a = JSON.parse(xhr.responseText);
                // console.log(a);
                $(".textarea").css('border-color', 'rgb(118, 118, 118)');
                $(".select2-selection").css('border-color', '#aaa');
                $('.x').removeClass('has-error');
                $('.help-block').text("");
                $.each(a.errors, function (key, value) {
                    tipeinput = $('#' + key).attr("class");
                    tipeselect = "select2";
                    tipetextarea = "textarea";
                    if (tipeinput.indexOf(tipeselect) > -1) {
                        $("#" + key).parent().find(".select2-container").children().children().css(
                            'border-color', '#a94442');
                        $('span[id^="' + key + '"]').text(value);
                    } else if (tipeinput.indexOf(tipetextarea) > -1) {
                        $("#" + key).css('border-color', '#a94442');
                        $('span[id^="' + key + '"]').text(value);
                    } else {
                        $('[name="' + key + '"]').parent().addClass(
                            'has-error'
                        );
                        if (!$('[name="' + key + '"]').is("select")) {
                            $('[name="' + key + '"]').next().text(
                                value);
                        }
                    }
                    $('span[id^="' + key + '"]').show();
                });
            },
            complete: function () {
                $.LoadingOverlay("hide");
                // $("#btnSave").button('reset');
            }
        });
    }

</script>
@endpush
