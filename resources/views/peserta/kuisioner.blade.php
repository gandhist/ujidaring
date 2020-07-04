@extends('frontend.main')

@section('content')

<h3 id="demo">Halaman Kuisioner Evaluasi Instruktur</h3>
@if(session('status'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
      {{ session('status') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
@endif
<div class="containel-fluid">

    <div class="row">

        <div class="col-lg-6">
            <div class="card border-info mb-3">
                <div class="card-header">Keterangan</div>
                <div class="card-body text-info">
                  <h5 class="card-title">Info card title</h5>
                  <p class="card-text">
                    Dalam rangka meningkatkan mutu penyelenggaraan pelatihan di masa mendatang, serta pengukuran kepuasan pelanggan, maka kami mohon kesediaan Anda untuk mengisi kuisioner ini dengan memberikan nilai 1-5 pada kotak yang sesuai. Penilaian Anda di jamin kerahasiaannya. 
                </p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <table class="table table-sm table-striped">
                <thead>
                  <tr>
                    <th scope="col">Nilai</th>
                    <th scope="col">Keterangan</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">1</th>
                    <td>Buruk</td>
                  </tr>
                  <tr>
                    <th scope="row">2</th>
                    <td>Kurang</td>
                  </tr>
                  <tr>
                    <th scope="row">3</th>
                    <td>Cukup</td>
                  </tr>
                  <tr>
                    <th scope="row">4</th>
                    <td>Bagus</td>
                  </tr>
                  <tr>
                    <th scope="row">5</th>
                    <td>Memuaskan</td>
                  </tr>
                </tbody>
              </table>
        </div>
    </div>
    <hr>
    <h3 align="center">Detail Pelatihan</h3>
    <div class="row">
        <div class="col-lg-4">
            <div class="card border-info mb-5">
                <div class="card-header">Detail Pelatihan</div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Nama Pelatihan : {{ $peserta->jadwal_r->jenis_usaha_r->nama_jns_usaha }}</li>
                    <li class="list-group-item">Tanggal Pelatihan : {{ \Carbon\Carbon::parse($peserta->jadwal_r->tgl_awal)->isoFormat('DD MMMM YYYY') }} - {{ \Carbon\Carbon::parse($peserta->jadwal_r->tgl_akhir)->isoFormat('DD MMMM YYYY') }}</li>
                    <li class="list-group-item">Nama Peserta : {{ $peserta->nama }}</li>
                  </ul>
            </div>
        </div>
    </div>
    <hr>
    <h3 align="center">Beri Tanggapan</h3>
    <form name="formAdd" id="formAdd">
    <div class="row">
      <div class="col-lg-4">
        <input type="text" class="form-control" name="id_instruktur" id="id_instruktur">
        <input type="hidden" value="{{ $peserta->jadwal_r->id }}" class="form-control" name="id_jadwal" id="id_jadwal">
      </div>
        <div class="col-lg-12">
            <table class="table table-hover table-sm">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Materi Pelatihan</th>
                    <th scope="col">Nilai</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($peserta->jawaban_eva_r as $key)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $key->soal_r->materi }}</td>
                        <td>
                            <select name="nilai_{{ $key->id }}" id="nilai_{{ $key->id }}">
                                @for($i=1; $i<=5; $i++)
                                <option value="{{ $key->id }}#{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </td>
                    </tr>
                    @endforeach
                    </form>
                 
                </tbody>
              </table>
              <button class="btn btn-primary" id="btnSave">Beri Tanggapan</button>
        </div>
    </div>

</div>





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
  var url = "{{ url('peserta/kuisioner/save') }}";
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
                // window.location.reload();
            }
        })

        }
    },
    error: function(xhr, status) {
        alert('terjadi error saat simpan data')
    }
  });
}


</script>
@endpush