@extends('templates/header')

@section('content')
<section class="content-header">
    <h1>
        Dashboard
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    </ol>
</section>
<section class="content">
    <div class="box box-content">
        <div class="box-body">
            @if(session()->get('message'))
            <div class="alert alert-success alert-dismissible fade in"> {{ session()->get('message') }}
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            </div>
            @endif
            <div class="row">
                <div class="col-md-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="fa fa-calendar"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Jadwal</span>
                            <span class="info-box-number">{{$jumlahjadwal}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <!-- fix for small devices only -->
                <div class="clearfix visible-sm-block"></div>

                <div class="col-md-6">

                </div>
            </div>


            <div class="row">
                <!-- Left col -->
                <div class="col-md-12">
                    <!-- TABLE: LATEST ORDERS -->
                    <div class="box box-info collapsed-box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Detail Jadwal</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body" style="display: block;">
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th style="width:12%">Tanggal Mulai</th>
                                            <th style="width:12%">Tanggal Selesai</th>
                                            <th>TUK</th>
                                            <th>Jenis Usaha</th>
                                            <th>Bidang</th>
                                            <th>Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $key)
                                        <tr>
                                            <td width="1%">{{ $loop->iteration }}</td>
                                            <td style="text-align:center">
                                                {{ \Carbon\Carbon::parse($key->tgl_awal)->isoFormat("DD MMMM YYYY") }}
                                            </td>
                                            <td style="text-align:center">
                                                {{ \Carbon\Carbon::parse($key->tgl_akhir)->isoFormat("DD MMMM YYYY") }}
                                            </td>
                                            <td style="text-align:left;width:40%">{{$key->tuk}}
                                            </td>
                                            <td style="text-align:left;width:10%">{{$key->jenis_usaha_r->nama_jns_usaha}}
                                            </td>
                                            <td style="text-align:left;width:10%">{{$key->bidang_r->nama_bidang}}
                                            </td>
                                            <td style="text-align:center;width:5%"><a  class="btn btn-success btn-xs" href="{{ url('jadwal/'.$key->id.'/dashboard') }}"><i
                                            class="fa fa-eye"></i> Detail </a></td>
                                        </tr>

                                        <!-- Modal -->
                                        <div class="modal fade" id="modalUploadTugas" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <form
                                                    action="{{ url('instruktur/dashboardinstruktur/'.$key->id.'/uploadtugas') }}"
                                                    class="form-horizontal" id="formAdd" name="formAdd" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-content">
                                                        <div class="modal-header"
                                                            style="background:#3c8dbc;color:white">
                                                            <button type="button" class="close"
                                                                data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">Upload Tugas</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="exampleInputFile">Pilih File</label>
                                                                <input required type="file" id="uploadTugas"
                                                                    name="uploadTugas">
                                                                <p class="help-block">File harus berupa pdf.</p>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button id="btnTugas" type="submit"
                                                                class="btn btn-md btn-danger">
                                                                <i class="fa fa-save"></i>
                                                                Simpan</button>
                                                            <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Batal</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Modal -->
                                        <div class="modal fade" id="modalUploadSoal" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <form
                                                    action="{{ url('instruktur/dashboardinstruktur/'.$key->id.'/uploadsoal') }}"
                                                    class="form-horizontal" id="formAdd" name="formAdd" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-content">
                                                        <div class="modal-header"
                                                            style="background:#3c8dbc;color:white">
                                                            <button type="button" class="close"
                                                                data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">Upload Soal</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="exampleInputFile">Pilih File Soal Pilihan
                                                                    Ganda</label>
                                                                <input required type="file" id="soalPg" name="soalPg">
                                                                <p class="help-block">File harus berupa pdf.</p>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="exampleInputFile">Pilih File Soal
                                                                    Essay</label>
                                                                <input required type="file" id="soalEssay"
                                                                    name="soalEssay">
                                                                <p class="help-block">File harus berupa pdf.</p>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button id="btnTugas" type="submit"
                                                                class="btn btn-md btn-danger">
                                                                <i class="fa fa-save"></i>
                                                                Simpan</button>
                                                            <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Batal</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>

                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->

                <!-- <div class="col-md-4">

                </div> -->
                <!-- /.col -->

            </div>
        </div>
    </div>
</section>
@endsection
