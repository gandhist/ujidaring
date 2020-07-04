@extends('frontend.main')

@section('content')

<h3 id="demo">Halaman Dashboard</h3>
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

        <div class="col-lg 6">
            <div class="card" >
                <img class="card-img-top" src="#" alt="Pass Foto {{ $peserta->nama }}">
                <div class="card-body">
                  <h5 class="card-title">{{ $peserta->nama }}</h5>
                </div>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">NIK : {{ $peserta->nik }}</li>
                </ul>
                
              </div>
        </div>
        <div class="col-lg 4">
            <div class="card" >
                <div class="card-header">
                  {{ $peserta->jadwal_r->jenis_usaha_r->nama_jns_usaha }}
                </div>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">Bidang : {{ $peserta->jadwal_r->bidang_r->nama_bidang }}</li>
                  <li class="list-group-item">{{ $peserta->jadwal_r->sertifikat_alat_r->nama_srtf_alat }}</li>
                </ul>
              </div>
        </div>
        <div class="col-lg-2">
            @if ($is_allow_uji)
            {{-- <button class="btn btn-outline-info" id="mulaiUjian">Mulai Ujian</button> --}}
            <a href="{{ url('peserta/ujian/pg') }}" class="btn btn-outline-info">Mulai Ujian</a>
            @else
            {{-- <h6>Anda Sudah Melaksanakan Ujian</h6>
            <p><small>Silahkan Isi Kuisioner</small> <a href="{{ url('peserta/kuisioner') }}" class="btn btn-outline-info">Isi Kuisioner</a></p> --}}
            @endif
            <p><a href="{{ url('peserta/presensi') }}" class="btn btn-outline-info">Absen</a></p>

        </div>

    </div>
    <hr>
    <h3>Modul & Materi</h3>
    <div class="row">
        <div class="col-lg-8">
            <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Modul</th>
                    <th scope="col">Jam Pelajaran</th>
                    <th scope="col">Materi</th>
                    <th scope="col">Link</th>
                  </tr>
                </thead>
                <tbody>
                   @foreach($peserta->jadwal_r->jadwal_modul_r as $key)
                   <tr>
                       <td>{{ $loop->iteration }}</td>
                       <td>{{ $key->modul_r->modul }}</td>
                       <td>{{ $key->modul_r->jp }} Jam</td>
                       <td>
                        @if($key->materi)
                        <a href="{{ url('uploads/materi/'.$key->materi) }}" class="btn btn-success">Materi</a>
                        @endif
                       </td>
                       <td>
                        @if($key->materi)
                          <a href="{{ $key->link }}" class="btn btn-info">Link</a>
                        @endif
                       </td>
                   </tr>
                   <?php $persyaratan = $key->modul_r->persyaratan; $hari = $key->modul_r->hari ?>
                   @endforeach
                  
                 
                </tbody>
              </table>
        </div>
        <div class="col-lg-4">
            <p class="lead">Persayaratan
                <br>
                {{ $persyaratan }}
                <br>
                Hari Pelaksanaan : {{ $hari }}
              </p>
        </div>
    </div>

</div>





@endsection
@push('script')
<script>
  $(document).ready(function () {
      // OPSIONAL: Buat event listener untuk pindah
// ke soal selanjutnya ketika input radio dipilih
$('[id^="soal-"] input:radio').on('change', function() {
	// Dapatkan obyek jQuery dari panel soal aktif
  var $panelSoalAktif = $(this).closest('.tab-pane');

  // active li
  var id = $panelSoalAktif.attr('id');
  $('.page-item').removeClass('active')
  $("a[href$='"+id+"']").parent().addClass('active')
  console.log($panelSoalAktif.attr('id'))
  // Cari id panel soal selanjutnya
  var idSoalSelanjutnya = $panelSoalAktif.next('[id^="soal-"]').attr('id');
  // Aktifkan panel soal selanjutnya
  $('a[href="#' + idSoalSelanjutnya + '"]').tab('show');
});


// onclick navigasi soal ujian
$('.page-item').on('click', function(){
  $('.page-item').removeClass('active')
    $(this).addClass('active')
})


$("#mulaiUjian").on('click',function(){
  $('#largeModal').modal('show');
});


  })


</script>
@endpush