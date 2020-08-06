@extends('templates/header')

@section('content')
<style>
    .custominp {
        border-radius: 5px;
        border-color: darkgrey;
        height: 30px;
    }

</style>
<section class="content-header">
    <h1><a href="{{ url('mastermodul') }}" class="btn btn-md bg-purple"><i class="fa fa-arrow-left"></i></a>
        Edit Modul Pelatihan
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Master Modul</a></li>
    </ol>
</section>

<section class="content">
    <div class="box box-content">
        <div class="box-body">
            <form class="form-horizontal" id="formAdd" name="formAdd" method="post"
                enctype="multipart/form-data">
                @method("PATCH")
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <br>
                        <table class=" table-striped">
                            <tbody>
                                <tr>
                                    <td style="padding-bottom: 2px">
                                        <div class="input-group">
                                            <label for="" style="">*Bidang</label>
                                            <select class="form-control select2" name="id_bidang" id="id_bidang">
                                                <option selected value="">Bidang</option>
                                                @foreach($bidang as $key)
                                                <option value="{{ $key->id }}"
                                                    {{ $key->id == $ms_modul->bidang_srtf_alat_r->bidang_r->id ? 'selected' : '' }}>
                                                    {{ $key->nama_bidang }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <span id="id_bidang" class="help-block customspan">{{ $errors->first('id_bidang') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="input-group">
                                            <label for="" style="">*Sertifikat Alat</label>
                                            <select class="form-control select2" name="id_sert_alat" id="id_sert_alat">
                                                <option selected value="">Sertifikat Alat</option>
                                                @foreach($srtf_bid_alat as $key)
                                                <option value="{{ $key->id }}"
                                                    {{ $key->id == $ms_modul->id_bid_srtf_alat ? 'selected' : '' }}>
                                                    {{ $key->nama_srtf_alat }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <span id="id_sert_alat" class="help-block customspan">{{ $errors->first('id_sert_alat') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="x">
                                        <!-- <div class="input-group"> -->
                                        <label for="" style="">*Jumlah Hari</label><br>
                                        <input name="id_jumlah_hari" id="id_jumlah_hari"
                                            class="form-control input-md custominp" type="text"
                                            placeholder="Jumlah Hari" maxlength="3" value="{{$ms_modul->hari}}">
                                        <!-- </div> -->
                                        <span id="id_jumlah_hari" class="help-block customspan">{{ $errors->first('id_jumlah_hari') }}
                                    </td>
                                </tr>
                                </thead>
                        </table>
                    </div>

                    <div class="col-md-8">
                        <br>
                        <table class=" table-striped">
                            <tbody>
                                <tr>
                                    <td style="width:100%">
                                        <!-- <div class="input-group"> -->
                                        <label for="" style="">*Syarat</label><br>
                                        <textarea class="textarea" style="width: 100%;border-radius: 5px;height:158px" name="id_syarat"
                                            id="id_syarat" cols="175">{{$ms_modul->persyaratan}}</textarea>
                                        <!-- </div> -->
                                        <span id="id_syarat" class="help-block customspan">{{ $errors->first('id_syarat') }}
                                    </td>
                                </tr>
                                </thead>
                        </table>
                    </div>

                    <!-- <div class="col-sm-12">
                        <div class="btn-group btn-lg">
                            <button id="addrow" type="button" class="btn btn-success"><span class="fa fa-plus"></span>
                                Tambah
                                Modul</button>
                        </div>
                    </div> -->
                    <!-- <div class="col-lg-12"><h1>MODUL PELATIHAN</h1></div> -->
                    <!-- Left col -->
                    <div class="col-md-12">
                        <div class="box-body" style="display: block;">
                            <div class="table-responsive">
                                <table id="tablemodul" class="table table-striped table-bordered dataTable customTable">
                                    <thead>
                                        <tr>
                                            <th style="width:1%">No</th>
                                            <th style="width:50%">Modul</th>
                                            <th>Jam Pertemuan</th>
                                            <th>Materi</th>
                                            <th>Upload Materi (pdf,word,excel,ppt,mp4)</th>
                                            <th>Input Link</th>
                                            <!-- <th style="width:3%">Hapus</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($detailModul as $key)
                                        <tr>
                                            <input type="hidden" value="{{ $key->id }}" id="id_ms_modul_{{ $loop->iteration }}" name="id_ms_modul_{{ $loop->iteration }}">
                                            <td style="width:1%">{{ $loop->iteration }}</td>
                                            <td class="x">
                                            <input required value="{{$key->modul}}" class="form-control input-md"
                                                    type="text" placeholder="Modul" name="modul_{{ $loop->iteration }}"
                                                    id="modul_{{ $loop->iteration }}">
                                            <span id="modul_{{ $loop->iteration }}" class="help-block"></span>
                                            </td>
                                            <td style="text-align:center;width:10%" class="x">
                                            <input value="{{$key->jp}}" required
                                                    name="jp_{{ $loop->iteration }}" id="jp_{{ $loop->iteration }}"
                                                    class="form-control input-md jp" type="text"
                                                    placeholder="Jam Pertemuan" maxlength="2">
                                                    <span id="jp_{{ $loop->iteration }}" class="help-block"></span>
                                                    </td>
                                            <td style="text-align:center">
                                                @if($key->materi)
                                                <a target="_blank" href="{{ url('/'.$key->materi) }}"
                                                    class="btn btn-success"><i class="fa fa-download" aria-hidden="true"></i></a>
                                                @endif
                                            </td>
                                            <td style="text-align:center" class="x">
                                                <input name="file_modul_{{ $loop->iteration }}"
                                                    id="file_modul_{{ $loop->iteration }}" type="file"
                                                    class="form-control file_modul">
                                                <span id="file_modul_{{ $loop->iteration }}" class="help-block"></span>
                                            </td>
                                            <td style="text-align:center">
                                                <input value="{{$key->link}}" name="link_modul_{{ $loop->iteration }}"
                                                    id="link_modul_{{ $loop->iteration }}" type="text"
                                                    class="form-control">
                                                <span id="link_modul_{{ $loop->iteration }}" class="help-block"></span>
                                            </td>
                                            <!-- <td style="padding-top:7px;width:3%">
                                                <button type="button"
                                                    class="btn btn-block btn-danger btn-sm btn-detail-hapus"
                                                    nomor="{{ $loop->iteration }}">
                                                    <span class="fa fa-trash"></span></button>
                                            </td> -->
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> <!-- /.table-responsive -->
                        </div>

                        <!-- </div> -->
                        <!-- /.box -->
                    </div>
                    <!-- /.col -->
                    <input id="jumlah_detail" name="jumlah_detail" type="hidden">
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
            update();
        });

        jumlahdetail = "{{count($detailModul)}}";
        arrayDetail = [];
        for (let index = 1; index <= jumlahdetail; index++) {
            arrayDetail.push(index);
        }
        $("#jumlah_detail").val(arrayDetail);
        
        $(document).on('change', '.file_modul', function (e) {
            var id = $(this).val();
            var ext = id.substr(id.lastIndexOf('.') + 1);
            ext = ext.toLowerCase();
            // switch (ext) {
            //     case 'doc':
            //     case 'docx':
            //     case 'pdf':
            //     case 'xls':
            //     case 'xlsx':
            //     case 'ppt':
            //     case 'pptx':
            //     case 'mp4':
            //         break;
            //     default:
            //         this.value = '';
            //         alert('Extension file tidak sesuai!');
            // }
        });

        $('#id_bidang').on('select2:select', function () {
            var url = `{{ url('bidang/chain') }}`;
            chainedBidang(url, 'id_bidang', 'id_sert_alat', "Sertifikat Alat");
        });

        $('#id_jumlah_hari , .jp').on('input blur paste', function () {
            $(this).val($(this).val().replace(/\D/g, ''));
        });

        // var no = 1;
        // var id_detail = [];
        // $('#addrow').on('click', function () {
        //     add_row_modul(no);
        //     id_detail.push(no);
        //     $('#jumlah_detail').val(id_detail);
        //     no++;
        // });

        // $(document).on('click', '.btn-detail-hapus', function (e) {
        //     nomor = $(this).attr('nomor');
        //     removeItem = nomor;
        //     id_detail = jQuery.grep(id_detail, function (value) {
        //         return value != removeItem;
        //     });
        //     $('#jumlah_detail').val(id_detail);
        //     $(this).closest('tr').remove();
        // });

        $('.select2').select2();
        $("#id_bidang").parent().find('.select2-container--default').css('pointer-events', 'none');
        $("#id_bidang").parent().find('.select2-selection--single').css('background', 'silver');
        $("#id_sert_alat").parent().find('.select2-container--default').css('pointer-events', 'none');
        $("#id_sert_alat").parent().find('.select2-selection--single').css('background', 'silver');

        // Fungsi Tambah Baris Instruktur
        // function add_row_modul(no) {
        //     $('#tablemodul > tbody:last').append(`
        //     <tr>
        //                                 <td style="width:1%">` + no +
        //         `</td>
        //                                 <td><input required class="form-control input-md" type="text" placeholder="Modul" name="modul_` +
        //         no + `" id="modul_` + no + `">
        //                                 </td>
        //                                 <td style="text-align:center;width:10%"><input required name="jp_` + no +
        //         `" id="jp_` +
        //         no + `" class="form-control input-md"
        //                                         type="text" placeholder="Jam Pertemuan" maxlength="2"></td>
        //                                 <td style="text-align:center">
        //                                     <input name="file_modul_` + no + `" id="file_modul_` + no + `" type="file" class="form-control file_modul">
        //                                     <span id="file_modul_` + no + `" class="help-block"></span>
        //                                 </td>
        //                                 <td style="text-align:center">
        //                                     <input name="link_modul_` + no + `" id="link_modul_` + no + `" type="text" class="form-control">
        //                                     <span id="link_modul_` + no + `" class="help-block"></span>
        //                                 </td>
        //                                 <td style="padding-top:7px;width:3%">
        //                 <button type="button" class="btn btn-block btn-danger btn-sm btn-detail-hapus" nomor="` + no + `" >
        //                 <span class="fa fa-trash"></span></button>
        //             </td>
        //                             </tr>
        //     `);
        //     $('#jp_' + no).on('input blur paste', function () {
        //         $(this).val($(this).val().replace(/\D/g, ''))
        //     });

        // };
    });


    function update() {

        var formData = new FormData($('#formAdd')[0]);
        var url = "{{ url('mastermodul/update') }}";
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
                    fontawesomeColor:"black",
                    fade : [5, 5],
                    background : "rgba(60, 60, 60, 0.4)"
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
                            if(response.icon=="warning"){

                            }else{
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
                        console.log("select2");
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