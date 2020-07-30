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
                  {{-- <h5 class="card-title">Info card title</h5> --}}
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
        <div class="col-lg-6">
            <div class="card border-info mb-5">
                <div class="card-header">Pelatihan anda</div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Nama Pelatihan : {{ $peserta->jadwal_r->jenis_usaha_r->nama_jns_usaha }}</li>
                    <li class="list-group-item">Tanggal Pelatihan : {{ \Carbon\Carbon::parse($peserta->jadwal_r->tgl_awal)->isoFormat('DD MMMM YYYY') }} - {{ \Carbon\Carbon::parse($peserta->jadwal_r->tgl_akhir)->isoFormat('DD MMMM YYYY') }}</li>
                    <li class="list-group-item">Nama Peserta : {{ $peserta->nama }}</li>
                  </ul>
            </div>
        </div>
        <div class="col-lg-3">
          <div class="card border-info mb-5">
              <div class="card-header">Modul Pelatihan Hari Ini</div>
              <ul class="list-group list-group-flush">
                  @foreach($rd->modul_rundown_r as $key)
                  <li class="list-group-item">{{ $loop->iteration }}. {{ $key->jadwal_modul_r->modul_r->modul }}</li>
                  @endforeach
                </ul>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="card border-info mb-5">
              <div class="card-header">Instruktur Pelatihan Hari Ini</div>
              <ul class="list-group list-group-flush">
                  @foreach($rd->ins_rundown_r as $key)
                  <li class="list-group-item">{{ $loop->iteration }}. {{ $key->jadwal_instruktur_r->instruktur_r->nama}}</li>
                  @endforeach
                </ul>
          </div>
        </div>
    </div>
    <hr>
    <h3 align="center">Beri Tanggapan</h3>
    <ul class="nav nav-tabs" id="myTab" role="tablist">

      {{-- <li class="nav-item">
        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
      </li> --}}
      @foreach($rd->ins_rundown_r as $key)
      <li class="nav-item">
        <a class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab-{{ $key->jadwal_instruktur_r->instruktur_r->id }}" data-toggle="tab" href="#tablink_{{ $key->jadwal_instruktur_r->instruktur_r->id }}" role="tab" aria-controls="contact" aria-selected="false">{{ $key->jadwal_instruktur_r->instruktur_r->nama}}</a>
      </li>
      @endforeach

    </ul>
    <div class="tab-content" id="myTabContent">
    @foreach($rd->ins_rundown_r as $key)
      <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="tablink_{{ $key->jadwal_instruktur_r->instruktur_r->id }}" role="tabpanel" aria-labelledby="tab-{{ $key->jadwal_instruktur_r->instruktur_r->id }}">
        <h6>Beri Penilaian untuk instrtuktur {{ $key->jadwal_instruktur_r->instruktur_r->nama}}</h6> 
            <form name="formAdd" id="formAdd">
              <div class="row">
                <div class="col-lg-4">
                  <input type="hidden" id="total" value="{{ $loop->iteration }}" name="total" >
                  <input type="hidden" value="{{ $key->jadwal_instruktur_r->instruktur_r->id }}" class="form-control" name="id_instruktur_{{ $loop->iteration }}" id="id_instruktur_{{ $loop->iteration }}">
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
                              @foreach($peserta->jawaban_eva_r as $eva)

                                @if($eva->id_instruktur == $key->jadwal_instruktur_r->instruktur_r->id)
                                  <tr>
                                      <th scope="row">{{ $loop->iteration }}</th>
                                      <td>{{ $eva->soal_r->materi }}</td>
                                      <td>
                                          <select name="nilai_{{ $eva->id }}" id="nilai_{{ $eva->id }}">
                                              @for($i=1; $i<=5; $i++)
                                              <option {{ $eva->nilai == $i ? 'selected' : '' }} value="{{ $eva->id }}#{{ $i }}">{{ $i }}</option>
                                              @endfor
                                          </select>
                                      </td>
                                  </tr>
                                @endif
                              
                              @endforeach
                          
                          </tbody>
                        </table>
                        @if($loop->last)
                        </form>
                        <button class="btn btn-primary" id="btnSave">Beri Tanggapan</button>
                        @endif
                  </div>
              </div>

      </div>
    @endforeach
      {{-- <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">...</div>
      <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
      <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div> --}}
    </div>


</div>





@endsection
@push('script')
<script>
  var home = "{{ url('peserta/presensi') }}";
$(document).ready(function () {
    $('#btnSave').on('click', function(e){
      e.preventDefault();
      store()
    })

});

function store(){
  var hal_absen = "{{ url('peserta/presensi') }}";
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
                window.location.replace(hal_absen);
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