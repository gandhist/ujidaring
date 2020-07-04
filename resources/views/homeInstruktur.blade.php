@extends('templates/header')

@section('content')
<section class="content-header">
    <h1>
        Dashboard Instruktur
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard Instruktur</a></li>
    </ol>
</section>
<section class="content">
    <div class="box box-content">
        <div class="box-body">
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
                <div class="col-md-6">
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
                                            <th>Tanggal Mulai</th>
                                            <th>Tanggal Selesai</th>
                                            <th>TUK</th>
                                            <th>Mulai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $key)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ \Carbon\Carbon::parse($key->jadwal_r->tgl_awal)->isoFormat("DD MMMM YYYY") }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($key->jadwal_r->tgl_akhir)->isoFormat("DD MMMM YYYY") }}
                                            </td>
                                            <td>{{$key->jadwal_r->tuk}}
                                            </td>

                                            @if($key->jadwal_r->akhir_ujian == "" )
                                            <td style="text-align:center"><a
                                                    href="{{ url('instruktur/dashboardinstruktur/'.$key->id.'/edit') }}"
                                                    type="button" class="btn btn-sm bg-olive btn-flat">Mulai Ujian</a>
                                            </td>
                                            @elseif( \Carbon\Carbon::now()->toDateTimeString() > $key->jadwal_r->awal_ujian && \Carbon\Carbon::now()->toDateTimeString() < $key->jadwal_r->akhir_ujian )
                                            <td style="text-align:center">
                                            <button type="button" class="btn btn-sm btn-danger">Ujian Sedang Berlangsung</button>
                                            </td>
                                            @else
                                            <td style="text-align:center">
                                            <a
                                                    href="{{ url('penilaian') }}"
                                                    type="button" class="btn btn-sm bg-olive btn-flat">Ujian Telah Selesai</a>
                                                <!-- <button type="button" class="btn btn-sm bg-olive btn-flat">Ujian Telah Selesai</button> -->
                                            </td>
                                            @endif

                                           
                                        </tr>
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

                <div class="col-md-4">

                </div>
                <!-- /.col -->
            </div>
        </div>
    </div>
</section>
@endsection
