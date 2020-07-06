@extends('frontend.main')

@section('content')

<div class="containel-fluid">

    <div class="row">
        <div class="col-lg-6">
            <h3>Tugas yang harus anda kerjakan</h3>
            <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" src="{{ url($peserta->jadwal_r->pdf_tugas) }}" ></iframe>
            </div>
        </div>
        <div class="col-lg-6">
            @if($peserta->jawaban_tugas)
            <h3>Tugas yang sudah di upload</h3>
            <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" src="{{ url('uploads/tugas/peserta/'.$peserta->jawaban_tugas->pdf_tugas) }}" ></iframe>
            </div>
            @endif
            <h3>Upload Tugas</h3>
            <form id="formAdd" name="formAdd">
                  <input type="file" class="form-control" name="tugas" id="tugas">
                  <span id="tugas" class="invalid-feedback" > {{ $errors->first('tugas') }}</span>

                <div class="input-group-append">
                  <button class="btn btn-outline-secondary" type="button" id="btnSave" name="btnSave">Kirim Tugas</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('script')
<script>
    var home = "{{ url('peserta/dashboard') }}";
$(document).ready(function () {
    $('#btnSave').on('click', function(e){
      e.preventDefault();
      store()
    })
})
function store(){
  var formData = new FormData($('#formAdd')[0]);
  var url = "{{ url('peserta/tugas/save') }}";
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
        if (response.status) {
        Swal.fire({
            title: response.message,
            // text: response.success,
            type: 'success',
            confirmButtonText: 'Close',
            confirmButtonColor: '#AAA',
            onClose: function() {
                window.location.reload();
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