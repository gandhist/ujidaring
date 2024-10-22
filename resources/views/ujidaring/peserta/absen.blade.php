@extends('frontend.main')

@section('content')

<h3 id="demo">Halaman Presensi</h3>
<div class="containel-fluid">


@if(session()->get('status'))
<div class="row">
  <div class="col-lg-6">
    <div class="alert alert-warning" role="alert">
      {{ session()->get('status') }}
    </div>
  </div>
</div>
@endif
        <form method="POST" name="formAdd" id="formAdd">
            <div class="row">
                <div class="col-md-6">
                    <div id="my_camera"></div>
                    <br/>
                    @if($allow_cekin)
                    <input type=button class="btn btn-outline-success" value="Presensi Masuk" onClick="take_snapshot()">
                    @else
                      @if($allow_cekout)
                        {{-- <a href="{{ url('peserta/kuisioner') }}" class="btn btn-outline-success" data-toggle="tooltip" data-placement="top" title="Isi evaluasi agar bisa absen pulang">Absen Keluar</a> --}}

                        @if($allow_tugas)
                          <a href="{{ url('peserta/kuisioner') }}" class="btn btn-outline-success" data-toggle="tooltip" data-placement="top" title="Isi evaluasi agar bisa absen pulang">Absen Keluar</a>
                        @else
                          <input type=button class="btn btn-outline-success" value="Presensi Keluar" onClick="take_snapshot_out()">
                        @endif
                      @else
                      <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Terimakasih, Anda Sudah Melakukan Presensi Masuk dan Pulang.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      @endif
                    @endif
                    
                    <input type="hidden" name="image" class="image-tag">
                </div>
                <div class="col-md-6">
                    <div id="results" style="padding:20px; border:1px solid; background:#ccc;">Gambar saat Presensi akan tampil disini</div>
                </div>
            </div>
        </form>
<hr>

    <div class="row">
        <h3>Daftar Presensi Anda</h3>
        <div class="col-lg-12">
            <table class="table">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                    <th>Gambar</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($data as $key)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($key->tanggal)->isoFormat('DD MMMM YYYY') }}</td>
                        <td>{{ $key->jam_cek_in }}</td>
                        <td>{{ $key->jam_cekout }}</td>
                        <td>
                            @if($key->foto_cek_in)
                            <a target="_blank" href="{{ url("uploads/peserta/$key->foto_cek_in") }}"  class="btn btn-info">Masuk</a>
                            @endif
                            @if($key->foto_cekout)
                            <a target="_blank" href="{{ url("uploads/peserta/$key->foto_cekout") }}"  class="btn btn-info">Keluar</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
        </div>
      
    </div>

</div>





@endsection
@push('script')
<script src="{{ asset('wbjs/webcam.min.js') }}" defer></script>

<script>
    var home = "{{ url('peserta/dashboard') }}";
  $(document).ready(function () {
    Webcam.set({
        width: 490,
        height: 390,
        image_format: 'jpeg',
        jpeg_quality: 90
    });
  
    Webcam.attach( '#my_camera' );
  
    
  })

  function take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
        } );
        // save data
        var formData = new FormData($('#formAdd')[0]);
        var url = "{{ url('peserta/presensi/datang') }}";
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
                window.location.replace(home);
            }
          })

        }
        else {
            Swal.fire({
            title: response.message,
            // text: response.success,
            type: 'error',
            confirmButtonText: 'Close',
            confirmButtonColor: '#AAA',
            onClose: function() {
                // window.location.replace(home);
            }
          })
            $('#alert').text(response.message).show();
        }
      },
      error: function(xhr, status) {
        alert('error saat Presensi');
      }
    });
  }

    function take_snapshot_out() {
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
        } );
        // save data
        var formData = new FormData($('#formAdd')[0]);
        var url = "{{ url('peserta/presensi/pulang') }}";
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
                window.location.replace(home);
            }
          })

        }
        else {
            Swal.fire({
                    title: response.message,
                    // text: response.success,
                    type: 'error',
                    confirmButtonText: 'Close',
                    confirmButtonColor: '#AAA',
                    onClose: function() {
                        // window.location.replace(home);
                    }
                })
        }
      },
      error: function(xhr, status) {
          alert('error saat Presensi');
      }
    });

    }




  

</script>
@endpush