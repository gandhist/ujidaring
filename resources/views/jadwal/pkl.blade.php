@extends('templates.header')
@push('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
@endpush
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><a href="{{ url('jadwal/'.$id.'/dashboard') }}" class="btn btn-md bg-purple"><i
                class="fa fa-arrow-left"></i></a>
        Daftar Makalah/PKL
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
            <br>
            <div class="row">
                <form id="formAdd" name="formAdd" method="post" action="{{ url('jadwal/upload/pkl') }}"  enctype="multipart/form-data">
                <input type="hidden" id="id_jadwal" name="id_jadwal" value="{{ $id }}">
                <div class="col-lg-5">
                    <div class="form-group">
                        <input type="file" class="form-control" id="materiPkl" name="materiPkl">
                        <span id="materiPkl" class="help-block customspan">{{ $errors->first('materiPkl') }}</span>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="form-group">
                          <input type='text' class="form-control" id='batas_up_makalah' name="batas_up_makalah" />
                            <span id="batas_up_makalah" class="help-block customspan">{{ $errors->first('batas_up_makalah') }}</span>
                      </div>
                </div>
                </form>

                <div class="col-lg-2">
                    <button class="btn btn-primary" type="button" id="btnUploadPkl" >Upload</button>
                </div>
                <div class="col-lg-12">
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped" style="min-width: 20px;"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <h3>Materi terupload</h3>
                </div>
                <div class="col-lg-10">
                    <!-- 21:9 aspect ratio -->
                    <div >
                        {{-- https://www.youtube.com/embed/LI-_0_q1rDI --}}
                        <iframe class="embed-responsive-item" src="{{ url("uploads/pkl/$jadwal->f_pkl") }}" allowfullscreen></iframe>
                      </div>
                </div>
            </div>
            <hr>
            <table id="data-tables" class="table table-striped table-bordered dataTable customTable">
                <thead>
                    <tr>
                        <th><i class="fa fa-check-square-o"></i></th>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Tanggal Upload</th>
                        <th>File</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($makalah as $key)
                    <tr>
                        <td>
                            <input type="checkbox" data-id="{{ $key->id }}" class="selection" id="selection[]" name="selection[]">
                        </td>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $key->peserta_r->nama }}</td>
                        <td>{{ $key->created_at }}</td>
                        <td>
                            @if($key->pdf_makalah)
                                <a href="{{ url('uploads/makalah/peserta/'.$key->pdf_makalah) }}" class="btn btn-success">Makalah</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            
        </div>
        <!-- /.box-body -->
        <!-- /.box-footer-->
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




<!-- <script type="text/javascript" src="{{ asset('chained.js') }}"></script> -->
<script type="text/javascript">
    var save_method = "add";
    $('.progress').hide();
    $(function () {
        $('#btnUploadPkl').on('click', function(e){
            e.preventDefault();
            if($('#batas_up_makalah').val() == ""){
                alert('tanggal tidak boleh kosong')
            }
            else if($('#materiPkl').val() == ""){
                alert('materi tidak boleh kosong')
            }
            else {
                store()
            }
        })
        $('#batas_up_makalah').datetimepicker({
            locale : 'id',
            format : 'YYYY-MM-DD HH:mm:ss'
        });
    });

function store(){
  var formData = new FormData($('#formAdd')[0]);
  var url = "{{ url('jadwal/upload/pkl') }}";
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
    xhr: function() {
        $('.progress').show();
        var xhr = new window.XMLHttpRequest();
        xhr.upload.addEventListener("progress", function(evt) {
            if (evt.lengthComputable) {
                var percentComplete = (evt.loaded / evt.total) * 100;
                percentComplete = parseInt(percentComplete);
                console.log(percentComplete);
            $('.progress').addClass('active')
            $(".progress-bar").css("width", percentComplete + "%").text(percentComplete + " %");

                //Do something with upload progress here
            }
       }, false);
       return xhr;
    },
    success: function(response) {
        if (response.status) {
        Swal.fire({
            title: response.message,
            // text: response.success,
            type: 'success',
            confirmButtonText: 'Close',
            confirmButtonColor: '#AAA',
            onClose: function() {
                $('.progress').hide();
                // window.location.reload();
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
  })
}
    //Initialize Select2 Elements
    $('.select2').select2();

    //Initialize datetimepicker
    $('.datepicker').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true
    });

</script>
@endpush
