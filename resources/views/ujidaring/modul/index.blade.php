@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Modul
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

            @if(session()->get('message'))
            <div class="alert alert-success alert-dismissible fade in"> {{ session()->get('message') }}
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            </div>
            @endif

            {{-- sub menu  --}}
            <form action="{{ url('badanusaha/filter') }}" enctype="multipart/form-data" name="filterData"
                id="filterData" method="post">
                <!-- @method("PUT") -->
                @csrf
                <!-- <input type="hidden" name="key" id="key">
                <input type="hidden" name="_method" id="_method"> -->
                <div class="row">
                    <div class="col-sm-5">

                        <!-- Table Filter -->
                        <!-- <table class="table table-condensed table-filter">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="input-group customSelect2md">
                                            <select class="form-control select2" name="f_pjk3" id="f_pjk3">
                                                <option selected value="">PJK3</option>

                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group customSelect2md">
                                            <select class="form-control select2" name="f_provinsi" id="f_provinsi">
                                                <option value="">Provinsi</option>

                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group customSelect2md">
                                            <select class="form-control select2" name="f_instansi" id="f_instansi">
                                                <option selected value="">Instansi_Reff</option>

                                            </select>
                                        </div>
                                    </td>
                                    <td style="padding-right: 0px">
                                        <button type="submit" class="btn btn-sm btn-info"> <i class="fa fa-filter"></i>
                                            Filter</button>
                                    </td>
                                    <td style="padding-left: 0px">
                                        <a href="{{ url('badanusaha') }}" class="btn btn-sm btn-default"> <i
                                                class="fa fa-refresh"></i>
                                            Reset</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="input-group customSelect2md">
                                            <select class="form-control select2" name="f_naker_prov" id="f_naker_prov">
                                                <option selected value="">Naker_Prov</option>

                                            </select>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="input-group customSelect2md">
                                            <select class="form-control select2" name="f_kota" id="f_kota">
                                                <option selected value="">Kota</option>

                                            </select>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="input-group customSelect2md">
                                            <select class="form-control select2" name="f_jenis_usaha"
                                                id="f_jenis_usaha">
                                                <option selected value="">Jenis Usaha</option>

                                            </select>
                                        </div>
                                    </td>
                                    <td>

                                    </td>
                                    <td>

                                    </td>
                                </tr>
                            </tbody>
                        </table> -->
                        <!-- End -->
                    </div>

                    <div class="col-sm-2">

                    </div>

                    <div class="col-sm-3">

                    </div>

                    <div class="col-sm-2" style='text-align:right'>
                        <div class="btn-group">
                            <button class="btn btn-success" id="btnEdit" name="btnEdit"> <i class="fa fa-pencil-square-o"></i>
                                Edit</button>
                            <a href="{{ route('mastermodul.create') }}" class="btn btn-info"> <i class="fa fa-plus"></i>
                                Tambah</a>

                            <!--  <button class="btn btn-danger" id="btnHapus" name="btnHapus"> <i class="fa fa-trash"></i>
                                Hapus</button> -->
                        </div>
                    </div>
                </div>
            </form>
            <br>
            <!-- /.box-footer -->
            {{-- end of sub menu  --}}
            <!-- <hr> -->
            {{-- table data of car  --}}
            {{-- <div class="table-responsive"> --}}
            <table id="data-tables" class="table table-striped table-bordered dataTable customTable">
                <thead>
                    <tr>
                        <th><i class="fa fa-check-square-o"></i></th>
                        <th>No</th>
                        <th>Jenis Usaha</th>
                        <th>Bidang</th>
                        <th>Bidang Srtf Alat</th>
                        <th>User Tambah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $key)
                    <tr>
                        <td style='width:1%'><input type="checkbox" data-id="{{ $key->id }}" class="selection"
                                id="selection[]" name="selection[]"></td>
                        <td style='width:1%'>{{ $loop->iteration }}</td>

                        <td style='text-align:center' data-toggle="tooltip" data-placement="bottom" data-html="true"
                            title="{{$key->bidang_srtf_alat_r->bidang_r->jenis_usaha_r->nama_jns_usaha}}">
                                {{$key->bidang_srtf_alat_r->bidang_r->jenis_usaha_r->kode_jns_usaha}}</td>
                        <td style='text-align:center' data-toggle="tooltip" data-placement="bottom" data-html="true"
                            title="{{$key->bidang_srtf_alat_r->bidang_r->nama_bidang}}">
                                {{$key->bidang_srtf_alat_r->bidang_r->kode_bidang}}</td>
                        <td style='text-align:center' data-toggle="tooltip" data-placement="bottom" data-html="true"
                            title="{{$key->bidang_srtf_alat_r->nama_srtf_alat}}">
                                {{$key->bidang_srtf_alat_r->kode_srtf_alat}}</td>
                        <!-- <td>{{$key->bidang_srtf_alat_r->bidang_r->nama_bidang}}</td>
                        <td>{{$key->bidang_srtf_alat_r->nama_srtf_alat}}</td> -->
                        <td style='width:8%;text-align:right'>{{ \Carbon\Carbon::parse($key->reated_at)->isoFormat("DD MMMM YYYY") }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- </div> --}}
            {{-- end of car data  --}}
        </div>
        <!-- /.box-body -->
        <div class="box-footer"></div>
        <!-- /.box-footer-->
    </div>
    <!-- /.box -->

</section>
<!-- /.content -->

<!-- modal konfirmasi -->
<div class="modal fade" id="modal-konfirmasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <form action="{{ url('badanusaha/destroy') }}" class="form-horizontal" id="formDelete" name="formDelete"
        method="post" enctype="multipart/form-data">
        @method("DELETE")
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
                    Yakin ingin menghapus data?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger" data-id=""
                        data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Deleting..."
                        id="confirm-delete">Hapus</button>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- end of modal konfirmais -->

<!-- modal lampiran -->
<div class="modal fade" id="modalLampiran" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="lampiranTitle"></h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <iframe src="" id="iframeLampiran" width="100%" height="500px" frameborder="0"
                            allowtransparency="true"></iframe>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>

        </div>
    </div>
</div>
<!-- end of modal lampiran -->
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
<!-- <script type="text/javascript" src="{{ asset('chained.js') }}"></script> -->
<script type="text/javascript">
    var save_method = "add";
    $(function () {

        // Filter kota berdasarkan provinsi
        $('#f_provinsi').on('select2:select', function () {
            var url = `{{ url('register_perusahaan/chain') }}`;
            chainedProvinsi(url, 'f_provinsi', 'f_kota', "Kota");
        });

        // Input data mask
        $('[data-mask]').inputmask();

        // Button edit click
        $('#btnEdit').on('click', function (e) {
            e.preventDefault();
            var id = [];
            $('.selection:checked').each(function () {
                id.push($(this).data('id'));
            });
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
                    title: "Harap pilih satu data untuk diedit",
                    type: 'warning',
                    confirmButtonText: 'Close',
                    confirmButtonColor: '#AAA'
                });
                // alert('Harap pilih satu data untuk di ubah');
            } else {
                url = id[0];
                window.location.href = "{{ url('mastermodul') }}/" + url + "/edit";
            }
        });

        // Button hapus click
        $('#btnHapus').on('click', function (e) {
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
    });

    //Initialize Select2 Elements
    $('.select2').select2();

    //Initialize datetimepicker
    $('.datepicker').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true
    });

</script>
@endpush
