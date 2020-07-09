@extends('templates/header')

@section('content')
<section class="content-header">
    <h1><a href="{{ url('jadwal/'.$id_jadwal.'/dashboard') }}" class="btn btn-md bg-purple"><i
                class="fa fa-caret-left"></i> Kembali</a>
        Modul Pelatihan
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Modul</a></li>
    </ol>
</section>
<section class="content">
    <div class="box box-content">
        <div class="box-body">

            <div class="row">
                <div class="col-lg-12"><h1>MODUL PELATIHAN</h1></div>
                <!-- Left col -->
                <div class="col-md-12">
                    <!-- TABLE: LATEST ORDERS -->
                    <div class="box box-info collapsed-box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Detail Modul</h3>

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
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Modul</th>
                                            <th>Jam Pertemuan</th>
											<th>Materi</th>
											<th>Upload Materi(pdf,word,excel)</th>
											<th>Input Link</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <form name="formAdd" id="formAdd" enctype="multipart/form-data">
                                            @foreach($data as $key)
                                            <input type="hidden" name="id_jadwal" id="id_jadwal" value="{{ $key->id_jadwal }}">
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $key->modul_r->modul }}</td>
                                                    <td style="text-align:center" >{{ $key->modul_r->jp }}</td>
                                                    <td style="text-align:center" > 
                                                        @if($key->materi)
                                                        <a href="{{ url('uploads/materi/'.$key->materi) }}" class="btn btn-success">Materi</a>
                                                        @endif
                                                    </td>
                                                    <td style="text-align:center">
                                                        <input type="file" class="form-control" id="materi_{{ $key->id }}" name="materi_{{ $key->id }}" value="" >
                                                        <span id="materi_{{ $key->id }}" class="help-block" > {{ $errors->first('materi_'.$key->id) }} </span>
                                                    </td>
                                                    <td style="text-align:center">
                                                        <input type="text" class="form-control" id="link_{{ $key->id }}" name="link_{{ $key->id }}" value="{{ $key->link }}" >
                                                        <span id="link_{{ $key->id }}" class="help-block" > {{ $errors->first('link_'.$key->id) }} </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </form>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                   
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->

                <div class="col-lg-12">
                    <button type="button" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Sedang Proses..." class="btn btn-info" name="btnSave" id="btnSave">Simpan</button>
                </div>
            </div>
        <br>
        </div>
    </div>
</section>
@endsection
@push('script')
<script>
$(document).ready(function () {
    $('#btnSave').on('click', function(e){
      e.preventDefault();
      store()
    })

});

function store(){
  var formData = new FormData($('#formAdd')[0]);
  var url = "{{ url('instruktur/modul/save') }}";
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
    success: function(response) {
        console.log(response['id_jadwal']);
        if (response.status) {
        Swal.fire({
            title: response.message,
            // text: response.success,
            type: 'success',
            confirmButtonText: 'Close',
            confirmButtonColor: '#AAA',
            onClose: function() {
                window.location = document.referrer;
            }
        })
        
        }
    },
    error: function(xhr, status) {
        // reset to remove error
        var a = JSON.parse(xhr.responseText);
        // reset to remove error
        $('.form-group').removeClass('has-error');
        $('.help-block').hide(); // hide error span message
        $.each(a.errors, function(key, value) {
            $('[name="' + key + '"]').parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
            $('span[id^="' + key + '"]').show(); // show error message span
            // for select2
            if (!$('[name="' + key + '"]').is("select")) {
                $('[name="' + key + '"]').next().text(value); //select span help-block class set text error string
            }
        });

    }
  });
}
</script>    
@endpush