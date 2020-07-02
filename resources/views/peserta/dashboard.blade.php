@extends('frontend.main')

@section('content')

<h3 id="demo">Halaman Dashboard</h3>
<div class="containel-fluid">

    <div class="row">

        <div class="col-lg 6">
            <div class="card" >
                <img class="card-img-top" src="..." alt="Pass Foto {{ $peserta->nama }}">
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
            @if ($peserta->jadwal_r->durasi_ujian)
            <a href="{{ url('peserta/ujian/pg') }}" class="btn btn-outline-info">Mulai Ujian</a>
            @endif
        </div>

    </div>
    <hr>
    <h3>Modul & Materi</h3>
    <div class="row">
        <div class="col-lg-10">
            <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Modul</th>
                    <th scope="col">Jam Pelajaran</th>
                    <th scope="col">Materi/Link</th>
                  </tr>
                </thead>
                <tbody>
                    {{-- {{ $peserta->jadwal_r->jadwal_modul_r }} --}}
                   
                  
                 
                </tbody>
              </table>
        </div>
        <div class="col-lg-2">
            <p class="lead">Persayaratan
                Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non commodo luctus.
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


    $("#foto").change(function(){
        readURL(this);
    });
  })
  
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      
      reader.onload = function(e) {
        $('#blah').attr('src', e.target.result);
      }
      
      reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
  }

</script>
@endpush