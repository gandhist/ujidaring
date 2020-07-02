@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Ubah Data Badan Usaha PJK3 Mandiri
        {{-- <small>it all starts here</small>  --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#">Badan Usaha P3SM</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box box-content">
        <div class="box-body">

            @if(session()->get('success'))
            <div class="alert alert-success alert-dismissible fade in"> {{ session()->get('success') }}
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            </div>
            @endif

            <form action="{{ route('badanusaha.update', $data->id) }}" class="form-horizontal" id="formAdd"
                name="formAdd" method="post" enctype="multipart/form-data">
                @method("PATCH")
                @csrf
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-6  {{ $errors->first('id_bentuk_bu') ? 'has-error has-error-select' : '' }}">
                            <select class="form-control select2" name="id_bentuk_bu" id="id_bentuk_bu"
                                style="width: 100%;">
                                <option value="" disabled>*Bentuk BU</option>
                                @foreach($bentukusaha as $key)
                                <option value="{{ $key->id }}"
                                    {{ $key->id == $data->id_bentuk_usaha ? 'selected' : '' }}>
                                    {{ $key->nama }} </option>
                                @endforeach
                            </select>
                            <span id="id_bentuk_bu" class="help-block customspan">{{ $errors->first('id_bentuk_bu') }}
                            </span>
                        </div>

                        <div class="col-sm-6 {{ $errors->first('id_jenis_usaha') ? 'has-error has-error-select' : '' }}">
                            <select class="form-control select2" name="id_jenis_usaha" id="id_jenis_usaha"
                                style="width: 100%;">
                                <option value="" disabled>*Jenis Usaha</option>
                                @foreach($jenisusaha as $key)
                                <option value="{{ $key->id }}" {{ $key->id == $data->jns_usaha ? 'selected' : '' }}>
                                    {{ $key->kode_jns_usaha }} </option>
                                @endforeach
                            </select>
                            <span id="id_jenis_usaha"
                                class="help-block customspan">{{ $errors->first('id_jenis_usaha') }} </span>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-sm-6 {{ $errors->first('id_prov_naker') ? 'has-error has-error-select' : '' }}">
                            <select class="form-control select2" name="id_prov_naker" id="id_prov_naker"
                                style="width: 100%;">
                                <option value="" disabled selected>*Provinsi Naker</option>
                                @foreach($prov as $key)
                                <option value="{{ $key->id }}" {{ $key->id == $data->prop_naker ? 'selected' : '' }}>
                                    {{ $key->nama }} </option>
                                @endforeach
                            </select>
                            <span id="id_prov_naker" class="help-block customspan">{{ $errors->first('id_prov_naker') }}
                            </span>
                        </div>

                        <div class="col-sm-6 {{ $errors->first('id_badan_usaha') ? 'has-error' : '' }}">
                            <input name="id_badan_usaha" id="id_badan_usaha" type="text" class="form-control"
                                placeholder="*Nama Badan Usaha (Tanpa Bentuk Badan Usaha)"
                                value="{{old('id_badan_usaha') ? old('id_badan_usaha') : $data->nama_bu}}">
                            <span id="id_badan_usaha"
                                class="help-block customspan">{{ $errors->first('id_badan_usaha') }}
                            </span>
                            @if(session()->get('id_badan_usaha'))
                            <span id="id_badan_usaha"
                                class="help-block customspan">{{ session()->get('id_badan_usaha') }} </span>
                            @endif
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-sm-6 {{ $errors->first('id_singkat_bu') ? 'has-error' : '' }}">
                            <input name="id_singkat_bu" id="id_singkat_bu" type="text" class="form-control"
                                placeholder="*Nama Singkat Badan Usaha" value="{{$data->singkat_bu}}">
                            <span id="id_singkat_bu" class="help-block customspan">{{ $errors->first('id_singkat_bu') }}
                            </span>
                        </div>

                        <div class="col-sm-6 {{ $errors->first('id_alamat_bu') ? 'has-error' : '' }}">
                            <textarea name="id_alamat_bu" id="id_alamat_bu" class="form-control" rows="1"
                                placeholder="*Alamat Jalan, Kelurahan, Kecamatan">{{$data->alamat}}</textarea>
                            <span id="id_alamat_bu" class="help-block customspan">{{ $errors->first('id_alamat_bu') }}
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 {{ $errors->first('id_prov_bu') ? 'has-error has-error-select' : '' }}">
                            <select class="form-control select2" name="id_prov_bu" id="id_prov_bu" style="width: 100%;">
                                <option value="" disabled>*Provinsi BU</option>
                                @foreach($prov as $key)
                                <option value="{{ $key->id }}" {{ $key->id == $data->id_prop ? 'selected' : '' }}>
                                    {{ $key->nama }} </option>
                                @endforeach
                            </select>
                            <span id="id_prov_bu" class="help-block customspan">{{ $errors->first('id_prov_bu') }}
                            </span>
                        </div>

                        <div class="col-sm-6 {{ $errors->first('id_kota_bu') ? 'has-error has-error-select' : '' }}">
                            <select class="form-control select2" name="id_kota_bu" id="id_kota_bu" style="width: 100%;">
                                <option value="" disabled>*Kota BU</option>
                                @foreach($kotapil as $key)
                                <option value="{{ $key->id }}" {{ $key->id == $data->id_kota ? 'selected' : '' }}>
                                    {{ $key->nama }} </option>
                                @endforeach
                            </select>
                            <span id="id_kota_bu" class="help-block customspan">{{ $errors->first('id_kota_bu') }}
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 {{ $errors->first('id_no_telp') ? 'has-error' : '' }}">
                            <input name="id_no_telp" id="id_no_telp" type="text" class="form-control"
                                placeholder="*No Tlp" value="{{$data->telp}}">
                            <span id="id_no_telp" class="help-block customspan">{{ $errors->first('id_no_telp') }}
                            </span>
                        </div>

                        <div class="col-sm-6">
                            <input name="id_email" id="id_email" type="email" class="form-control" placeholder="Email"
                                value="{{$data->email}}">
                            <span id="id_email" class="help-block customspan">{{ $errors->first('id_email') }} </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <input name="id_instansi" id="id_instansi" type="text" class="form-control"
                                placeholder="Instansi Reff" value="{{$data->instansi_reff}}">
                            <span id="id_instansi" class="help-block customspan">{{ $errors->first('id_instansi') }}
                            </span>
                        </div>

                        <div class="col-sm-6">
                            <input name="id_web" id="id_web" type="text" class="form-control" placeholder="Web"
                                value="{{$data->web}}">
                            <span id="id_web" class="help-block customspan">{{ $errors->first('id_web') }} </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <input name="id_nama_p" id="id_nama_p" type="text" class="form-control"
                                placeholder="Nama Pimpinan" value="{{$data->nama_pimp}}">
                            <span id="id_nama_p" class="help-block customspan">{{ $errors->first('id_nama_p') }} </span>
                        </div>

                        <div class="col-sm-6">
                            <input name="id_jab_p" id="id_jab_p" type="text" class="form-control"
                                placeholder="Jabatan Pimpinan" value="{{$data->jab_pimp}}">
                            <span id="id_jab_p" class="help-block customspan">{{ $errors->first('id_jab_p') }} </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <input name="id_hp_p" id="id_hp_p" type="text" class="form-control"
                                placeholder="No Hp Pimpinan" value="{{$data->hp_pimp}}">
                            <span id="id_hp_p" class="help-block customspan">{{ $errors->first('id_hp_p') }} </span>
                        </div>

                        <div class="col-sm-6">
                            <input name="id_email_p" id="id_email_p" type="email" class="form-control"
                                placeholder="Email Pimpinan" value="{{$data->email_pimp}}">
                            <span id="id_email_p" class="help-block customspan">{{ $errors->first('id_email_p') }}
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 {{ $errors->first('id_nama_kp') ? 'has-error' : '' }}">
                            <input name="id_nama_kp" id="id_nama_kp" type="text" class="form-control"
                                placeholder="*Nama Kontak Person" value="{{$data->kontak_p}}">
                            <span id="id_nama_kp" class="help-block customspan">{{ $errors->first('id_nama_kp') }}
                            </span>
                        </div>

                        <div class="col-sm-6">
                            <input name="id_jab_kp" id="id_jab_kp" type="text" class="form-control"
                                placeholder="Jabatan Kontak Person" value="{{$data->jab_kontak_p}}">
                            <span id="id_jab_kp" class="help-block customspan">{{ $errors->first('id_jab_kp') }} </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 {{ $errors->first('id_hp_kp') ? 'has-error' : '' }}">
                            <input name="id_hp_kp" id="id_hp_kp" type="text" class="form-control"
                                placeholder="*No HP Kontak Person" value="{{$data->no_kontak_p}}">
                            <span id="id_hp_kp" class="help-block customspan">{{ $errors->first('id_hp_kp') }} </span>
                        </div>

                        <div class="col-sm-6">
                            <input name="id_email_kp" id="id_email_kp" type="email" class="form-control"
                                placeholder="Email Kontak Person" value="{{$data->email_kontak_p}}">
                            <span id="id_email_kp" class="help-block customspan">{{ $errors->first('id_email_kp') }}
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 {{ $errors->first('id_npwp') ? 'has-error' : '' }}">
                            <input type="text" data-inputmask="'mask': ['99.999.999.9-999.999']" data-mask=""
                                id="id_npwp" name="id_npwp" class="form-control" placeholder="*NO NPWP"
                                value="{{old('id_npwp') ? old('id_npwp') : $data->npwp}}">
                            <!-- <input name="id_npwp" id="id_npwp" type="text" class="form-control" placeholder="NPWP"> -->
                            <span id="id_npwp" class="help-block customspan">{{ $errors->first('id_npwp') }} </span>
                            @if(session()->get('id_npwp'))
                            <span id="id_npwp" class="help-block customspan">{{ session()->get('id_npwp') }} </span>
                            @endif
                        </div>
                        <div class="col-sm-2 {{ $errors->first('id_file_npwp') ? 'has-error' : '' }}">
                            <input name="id_file_npwp" id="id_file_npwp" type="file" class="form-control"
                                placeholder="NPWP">
                            <span id="id_file_npwp" class="help-block customspan">{{ $errors->first('id_file_npwp') }}
                            </span>
                        </div>
                        <div class="form-group row">
                            <label for="id_file_npwp" class="control-label">*File NPWP (.PDF)</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <input name="id_norek_bank" id="id_norek_bank" type="text" class="form-control"
                                placeholder="No Rekening Bank" value="{{$data->no_rek}}">
                            <span id="id_norek_bank" class="help-block customspan">{{ $errors->first('id_norek_bank') }}
                            </span>
                        </div>

                        <div class="col-sm-6">
                            <input name="id_namarek_bank" id="id_namarek_bank" type="text" class="form-control"
                                placeholder="Nama Rekening Bank" value="{{$data->nama_rek}}">
                            <span id="id_namarek_bank"
                                class="help-block customspan">{{ $errors->first('id_namarek_bank') }}
                            </span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <select class="form-control select2" name="id_nama_bank" id="id_nama_bank"
                                style="width: 100%;">
                                <option value="" disabled>Nama Bank</option>
                                @foreach($bank as $key)
                                <option value="{{ $key->id_bank }}"
                                    {{ $key->id_bank == $data->id_bank ? 'selected' : '' }}> {{ $key->Nama_Bank }}
                                </option>
                                @endforeach
                            </select>
                            <span id="id_nama_bank" class="help-block customspan">{{ $errors->first('id_nama_bank') }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Detail -->

                <div class="btn-group btn-lg">
                    <button id="addrow" type="button" class="btn btn-success"><span class="fa fa-plus"></span> Tambah
                        Kontak Person</button>
                </div>
                <!-- <div class="btn-group">
                    <h4><b>Tambah Kontak</b></h4>
                </div> -->
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="kontak-Detail" class="table table-bordered table-Detail">
                        <thead>
                            <tr>
                                <th style="width: 10px">No</th>
                                <th>Prov_Naker</th>
                                <th>Jns_Usaha</th>
                                <th>Nama_Pimp</th>
                                <th>Jab_Pimp</th>
                                <th>Hp_Pimp</th>
                                <th>Email_Pimp</th>
                                <th>Nama_Kontak_P</th>
                                <th>Jab_Kontak_P</th>
                                <th>Hp_Kontak_P</th>
                                <th>Email_Kontak_P</th>
                                <th>Hapus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($detailbu as $key)
                            <tr>
                                <input type="hidden" name='type_detail_{{$loop->iteration}}'
                                    id='type_detail_{{$loop->iteration}}' value='{{$key->id}}'>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    <select class="form-control select2 provnaker" name="prov_dtl_{{$loop->iteration}}"
                                        id="prov_dtl_{{$loop->iteration}}" style="width: 100%;">
                                        <option value="{{$key->provinsi->id}}">{{$key->provinsi->nama}}</option>
                                        <!-- @foreach($prov as $select)
                                        <option value="{{ $select->id }}"
                                            {{ $select->id == $key->prop_naker ? 'selected' : '' }}>
                                            {{ $select->nama }} </option>
                                        @endforeach -->
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control select2" name="jns_usaha_detail_{{$loop->iteration}}"
                                        id="jns_usaha_detail_{{$loop->iteration}}"
                                        idjenisusaha="jns_usaha_detail_{{$loop->iteration}}" style="width: 100%;">
                                        <option value="{{$key->jenisusaha->id}}">{{$key->jenisusaha->nama_jns_usaha}}
                                        </option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" placeholder="Nama Pimpinan"
                                        name="nama_pimp_{{$loop->iteration}}" id="nama_pimp_{{$loop->iteration}}"
                                        value="{{$key->nama_pimp}}"></td>
                                <td><input type="text" class="form-control" placeholder="Jabatan Pimpinan"
                                        name="jab_pimp_{{$loop->iteration}}" id="jab_pimp_{{$loop->iteration}}"
                                        value="{{$key->jab_pimp}}"></td>
                                <td><input type="text" class="form-control" placeholder="No Hp Pimpinan"
                                        name="hp_pimp_{{$loop->iteration}}" id="hp_pimp_{{$loop->iteration}}"
                                        value="{{$key->hp_pimp}}"></td>
                                <td><input type="text" class="form-control" placeholder="Email Pimpinan"
                                        name="email_pimp_{{$loop->iteration}}" id="email_pimp_{{$loop->iteration}}"
                                        value="{{$key->email_pimp}}"></td>
                                <td><input type="text" class="form-control" placeholder="Nama Kontak Person"
                                        name="nama_kp_{{$loop->iteration}}" id="nama_kp_{{$loop->iteration}}"
                                        value="{{$key->kontak_p}}"></td>
                                <td><input type="text" class="form-control" placeholder="Jabatan Kontak Person"
                                        name="jab_kp_{{$loop->iteration}}" id="jab_kp_{{$loop->iteration}}"
                                        value="{{$key->jab_kontak_p}}"></td>
                                <td><input type="text" class="form-control" placeholder="No Hp Kontak Person"
                                        name="hp_kp_{{$loop->iteration}}" id="hp_kp_{{$loop->iteration}}"
                                        value="{{$key->no_kontak_p}}"></td>
                                <td><input type="text" class="form-control" placeholder="Email Kontak Person"
                                        name="email_kp_{{$loop->iteration}}" id="email_kp_{{$loop->iteration}}"
                                        value="{{$key->email_kontak_p}}"></td>
                                <td><button type="button" class="btn btn-block btn-danger btn-sm btn-detail-hapus"
                                        nomor="{{$loop->iteration}}" onclick=""><span
                                            class="fa fa-trash"></span></button></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <input type="hidden" name='id_jumlah_detail' id='id_jumlah_detail' value=''>
                <!-- End Detail -->
                <div class="box-footer">
                    <a href="{{ url('badanusaha') }}" class="btn btn-md btn-default pull-left"><i
                            class="fa fa-times-circle"></i> Batal</a>
                    <button type="submit" class="btn btn-md btn-info pull-left"> <i class="fa fa-save"></i>
                        Simpan</button>
                </div>
            </form>

        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

</section>
<!-- /.content -->

@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
<script type="text/javascript">
    // $('.select2').val(null).trigger('change');
    var home = "{{ route('badanusaha.index') }}";

    $(function () {

        // fungsi Tambah Baris Detail
        function add_row(no) {
            $('#kontak-Detail > tbody:last').append(`
            <tr>
            <input type="hidden" name="type_detail_` + no + `" id="type_detail_` + no + `" value="">
                                <td>` + no + `</td>
                                <td>
                                    <select class="form-control select2 provnaker" name="prov_dtl_` + no +
                `" id="prov_dtl_` +
                no + `" idjenisusaha="jns_usaha_detail_` + no + `"
                                        style="width: 100%;">
                                        <option value="" disabled selected>Provinsi Naker</option>
                                        @foreach($prov as $key)
                                        <option value="{{ $key->id }}">
                                            {{ $key->nama }} </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control select2" name="jns_usaha_detail_` + no +
                `" id="jns_usaha_detail_` + no +
                `"
                                        style="width: 100%;">
                                        <option value="" disabled selected>Jenis Usaha</option>
                                         </select>
                                </td>
                                <td><input type="text" class="form-control" placeholder="Nama Pimpinan" name="nama_pimp_` +
                no + `" id="nama_pimp_` + no +
                `"></td>
                                <td><input type="text" class="form-control" placeholder="Jabatan Pimpinan" name="jab_pimp_` +
                no + `" id="jab_pimp_` +
                no +
                `"></td>
                                <td><input type="text" class="form-control" placeholder="No Hp Pimpinan" name="hp_pimp_` +
                no + `" id="hp_pimp_` + no +
                `"></td>
                                <td><input type="text" class="form-control" placeholder="Email Pimpinan" name="email_pimp_` +
                no +
                `" id="email_pimp_` + no +
                `"></td>
                                <td><input type="text" class="form-control" placeholder="Nama Kontak Person" name="nama_kp_` +
                no +
                `" id="nama_kp_` + no +
                `"></td>
                                <td><input type="text" class="form-control" placeholder="Jabatan Kontak Person" name="jab_kp_` +
                no +
                `" id="jab_kp_` + no +
                `"></td>
                                <td><input type="text" class="form-control" placeholder="No Hp Kontak Person" name="hp_kp_` +
                no +
                `" id="hp_kp_` + no +
                `"></td>
                                <td><input type="text" class="form-control" placeholder="Email Kontak Person" name="email_kp_` +
                no +
                `" id="email_kp_` + no +
                `"></td>
                                <td><button type="button" class="btn btn-block btn-danger btn-sm btn-detail-hapus" nomor="` +
                no + `"
                                        onclick=""><span
                                            class="fa fa-trash"></span></button></td>
                            </tr>
            `);
        }

        //Button Hapus Baris Detail
        $(document).on('click', '.btn-detail-hapus', function (e) {
            nomor = $(this).attr('nomor');
            prop_naker = $("#prov_dtl_" + nomor).val();
            jns_usaha = $("#jns_usaha_detail_" + nomor).val();

            // Hapus data dari table temporary
            hapustemp(prop_naker, jns_usaha);

            last_element = id_detail[id_detail.length - 1];
            if (last_element == nomor) {
                removeItem = nomor;
                id_detail = jQuery.grep(id_detail, function (value) {
                    return value != removeItem;
                });
                $('#id_jumlah_detail').val(id_detail);

                last_element = id_detail[id_detail.length - 1];

                prop_naker = $("#prov_dtl_" + last_element).val();
                jns_usaha = $("#jns_usaha_detail_" + last_element).val();
                hapustemp(prop_naker, jns_usaha);

                $("#prov_dtl_" + last_element).parent().find('.select2-selection--single')
                    .css('background', 'white');
                $("#prov_dtl_" + last_element).parent().find(
                    '.select2-container--default').css('pointer-events', '');

                $("#jns_usaha_detail_" + last_element).parent().find('.select2-selection--single')
                    .css('background', 'white');
                $("#jns_usaha_detail_" + last_element).parent().find(
                    '.select2-container--default').css('pointer-events', '');

            } else {
                removeItem = nomor;
                id_detail = jQuery.grep(id_detail, function (value) {
                    return value != removeItem;
                });
                $('#id_jumlah_detail').val(id_detail);

                last_element = id_detail[id_detail.length - 1];

                prop_naker = $("#prov_dtl_" + last_element).val();
                idjenisusaha = "jns_usaha_detail_" + last_element;
                jenisusahachange(prop_naker, idjenisusaha);
            }

            $(this).closest('tr').remove();
        });

        // Button Tambah Baris Detail
        var no = 1;
        var id_detail = [];
        var jumlah_detail = "{{$jumlahdetail}}";

        for (index = 1; index <= jumlah_detail; index++) {
            prop_naker = $("#prov_dtl_" + no).val();
            jns_usaha = $("#jns_usaha_detail_" + no).val();

            // Input data ke table temporary
            inserttemp(prop_naker, jns_usaha, index);

            id_detail.push(no);
            $('#id_jumlah_detail').val(id_detail);
            no++;
        }

        $('#addrow').on('click', function () {
            if (id_detail == '') {
                add_row(no);
                id_detail.push(no);
                $('#id_jumlah_detail').val(id_detail);
                $('.select2').select2();
                no++;
            } else {
                last_element = id_detail[id_detail.length - 1];
                prop_naker = $("#prov_dtl_" + last_element).val();
                jns_usaha = $("#jns_usaha_detail_" + last_element).val();
                if (prop_naker == null || jns_usaha == null) {
                    Swal.fire({
                        title: "Provinsi Naker atau Jenis Usaha belum diisi !",
                        type: 'error',
                        confirmButtonText: 'Close',
                        confirmButtonColor: '#AAA'
                    });
                    // alert('Prov_Naker atau Jenis Usaha belum diisi')
                } else {
                    // Input data ke table temporary
                    inserttemp(prop_naker, jns_usaha, last_element);

                    add_row(no);
                    id_detail.push(no);
                    $('#id_jumlah_detail').val(id_detail);

                    // Menjalankan Select2 pada baris baru
                    $('#prov_dtl_' + no).select2();
                    $('#jns_usaha_detail_' + no).select2();
                    // $('.select2').select2();
                    no++;
                }
            }
        });

        $(document).on('change', '.provnaker', function (e) {
            prop_naker = $(this).val();
            idjenisusaha = $(this).attr('idjenisusaha');
            $('#' + idjenisusaha).empty();

            // Select data jenis usaha yang belum terpilih
            jenisusahachange(prop_naker, idjenisusaha);
        });

        // format input
        $('[data-mask]').inputmask()

        // Filter Kota Berdasarkan Provinsi
        $('#id_prov_bu').on('select2:select', function () {
            var url = `{{ url('register_perusahaan/chain') }}`;
            chainedProvinsi(url, 'id_prov_bu', 'id_kota_bu', "*Kota BU");
        });

        //Kunci Input No Hp Hanya Angka
        $('#id_no_telp,#id_hp_p,#id_hp_kp,#id_norek_bank').on('input blur paste', function () {
            $(this).val($(this).val().replace(/\D/g, ''))
        });

        // Fungsi hapus dari table temporary
        function hapustemp(prop_naker, jns_usaha) {
            var url = "{{ url('delete_temp_bu_kontak_p') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    prop_naker: prop_naker,
                    jns_usaha: jns_usaha
                },
                success: function (data) {
                    console.log('Sukses');
                },
                error: function (xhr, status) {
                    alert('Error');
                }
            });
        }

        // Insert ke table temporary dan mengunci nilai detail terakhir agar tidak bisa dirubah
        function inserttemp(prop_naker, jns_usaha, last_element) {
            url = "{{ url('add_temp_bu_kontak_p') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    prop_naker: prop_naker,
                    jns_usaha: jns_usaha
                },
                success: function (data) {
                        $("#prov_dtl_" + last_element).parent().find('.select2-container--default')
                            .css('pointer-events', 'none');
                        $("#jns_usaha_detail_" + last_element).parent().find(
                            '.select2-container--default').css('pointer-events', 'none');

                        $("#prov_dtl_" + last_element).parent().find('.select2-selection--single')
                            .css('background', 'silver');
                        $("#jns_usaha_detail_" + last_element).parent().find(
                            '.select2-selection--single').css('background', 'silver');

                        // id_jns_ush = $("#jns_usaha_detail_" + last_element).val();
                        // nm_jns_ush = $("#jns_usaha_detail_" + last_element +
                        //     " option:selected").text();
                        // var datajnsush = {
                        //     id: id_jns_ush,
                        //     text: nm_jns_ush
                        // };
                        // $("#jns_usaha_detail_" + last_element).empty();
                        // var newOption = new Option(datajnsush.text, datajnsush.id,
                        //     false, false);
                        // $("#jns_usaha_detail_" + last_element).append(newOption)
                        //     .trigger('change');

                    
                },
                error: function (xhr, status) {
                    alert('Error');
                }
            });
        }

        // Memunculkan bidang berdasarkan jenis usaha yang dipilih
        function jenisusahachange(prop_naker, idjenisusaha) {
            var url = "{{ url('select_temp_bu_kontak_p') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    prop_naker: prop_naker
                },
                success: function (data) {
                    $("#" + idjenisusaha).html(
                        "<option value='' selected disabled>Jenis Usaha</option>");
                    $("#" + idjenisusaha).select2({
                        data: data
                    }).val(null).trigger('change');
                },
                error: function (xhr, status) {
                    alert('Error');
                }
            });
        }

    });

    //Initialize Select2 Elements
    $('.select2').select2()

    $('.datepicker').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true
    })

</script>
@endpush
