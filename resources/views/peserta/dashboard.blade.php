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

        <div class="col-lg 4">
            <div class="card" >
              @if($peserta->foto)
                <img class="card-img-top" src="{{ asset("uploads/peserta/",$peserta->foto) }}" alt="Pass Foto {{ $peserta->nama }}">
                @endif
                <div class="card-body">
                  <h5 class="card-title">{{ $peserta->nama }} @if($is_ketua) (Ketua Kelompok {{ $peserta->kelompok->no_kelompok }} ) @endif</h5>
                </div>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">NIK : {{ $peserta->nik }}</li>
                </ul>
                @if($is_ketua)
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">NIK : {{ $peserta->nik }}</li>
                </ul>
                @endif
                
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
          {{-- if in jadwal --}}
          <div class="card" >
            <div class="card-header">
              Pintasan
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group list-group-flush"><a target="_blank" href="{{ url($peserta->jadwal_r->pdf_jadwal) }}" class="btn btn-outline-info">Lihat Jadwal</a></li>
                <li class="list-group list-group-flush"><a target="_blank" href="{{ url('peserta/presensi') }}" class="btn btn-outline-info">Absen</a></li>
                @if ($is_pkl)
                <li class="list-group list-group-flush">
                  <a href="{{ url('peserta/makalah') }}" class="btn btn-outline-info">Upload Makalah</a>
                </li>
                @endif
                @if ($is_pre_quis)
                  <li class="list-group list-group-flush">
                    <a href="{{ url('peserta/quis/pre') }}" class="btn btn-outline-info">Kerjakan Pre Quis</a>
                  </li>
                @endif
                @if ($is_post_quis)
                  <li class="list-group list-group-flush">
                    <a href="{{ url('peserta/quis/post') }}" class="btn btn-outline-info">Kerjakan Post Quis</a>
                  </li>
                @endif
                @if ($is_allow_uji)
                  <li class="list-group list-group-flush">
                    <a href="{{ url('peserta/ujian/pg') }}" class="btn btn-outline-info">Mulai Ujian</a>
                  </li>
                @else
                  @if($is_tugas)
                  <li class="list-group list-group-flush">
                    <a href="{{ url('peserta/tugas') }}" class="btn btn-outline-info">Kerjakan Tugas</a>
                  </li>
                  @endif
                @endif
                <li class="list-group list-group-flush"><a target="_blank" href="{{ url('peserta/presentasi') }}" class="btn btn-outline-info">Presentasi</a></li>
            </ul>
          </div>
          {{-- if not in jadwal --}}

        </div>

    </div>
    <hr>
    <h3>Jadwal Pelatihan</h3>
    <div class="row">
      <div class="col-lg-12">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Tanggal</th>
              <th scope="col">Materi</th>
              <th scope="col">Instruktur</th>
            </tr>
          </thead>
          <tbody>
             @foreach($rd as $key)
             @if($key->tanggal <= \Carbon\Carbon::now()->isoFormat('YYYY-MM-DD'))
             <tr>
                 <td>{{ $loop->iteration }}</td>
                 <td>{{ \Carbon\Carbon::parse($key->tanggal)->isoFormat('DD MMMM YYYY') }}</td>
                 <td>
                  @foreach($key->modul_rundown_r as $md)
                  @if(substr($md->jadwal_modul_r->materi,0,4) == "http")
                    {{ $loop->iteration }}. <a target="_blank" href="{{ $md->jadwal_modul_r->materi }}"> {{ $md->jadwal_modul_r->modul_r->modul }} </a> 
                  @else 
                    {{-- {{ $loop->iteration }}. <a target="_blank" href="{{ url('uploads/materi/'.$md->jadwal_modul_r->materi) }}"> {{ $md->jadwal_modul_r->modul_r->modul }} </a>  --}}
                    @if($md->jadwal_modul_r->modul_r->materi)
                      {{ $loop->iteration }}. <a target="_blank" href="{{ url('peserta/buka/materi/modul/'.$md->jadwal_modul_r->modul_r->id) }}"> {{ $md->jadwal_modul_r->modul_r->modul }} </a> 
                    @else
                      {{ $loop->iteration }}. {{ $md->jadwal_modul_r->modul_r->modul }}
                      {{-- jika modulnya berupa link --}}
                    @endif
                  @endif
                  {{-- link dari master modul --}}
                  @if($md->jadwal_modul_r->materi) 
                    | <a target="_blank" href="{{ url('peserta/buka/materi/'.$md->id) }}"" class="btn btn-success btn-sm" ><i class="fa fa-link"></i> Materi Inst</a>
                  @endif
                  {{-- end of link dari master modul --}}
                  {{-- link dari master modul --}}
                  @if($md->jadwal_modul_r->modul_r->link) 
                    | <a target="_blank" href="{{ $md->jadwal_modul_r->modul_r->link}}" class="btn btn-success btn-sm" ><i class="fa fa-link"></i></a>
                  @endif
                  {{-- end of link dari master modul --}}
                  {{-- zoom --}}
                  @if($md->jadwal_modul_r->link) 
                    | <a target="_blank" href="{{ $md->jadwal_modul_r->link}}" class="btn btn-info btn-sm"><i class="fa fa-link"></i> Zoom</a>
                  @endif
                  {{-- end zoom --}}
                  <br>
                  @endforeach
                 </td>
                 <td>
                  @foreach($key->ins_rundown_r as $ins)
                  {{ $loop->iteration }}. {{ $ins->jadwal_instruktur_r->instruktur_r->nama}} <br>
                  @endforeach
                 </td>
             </tr>
             @endif
             @endforeach
            
           
          </tbody>
      </table>
      </div>
      
    </div>
    {{-- <div class="row">
        <div class="col-lg-8">
            <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Modul</th>
                    <th scope="col">Jam Pertemuan</th>
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
                        <a target="_blank" href="{{ url('uploads/materi/'.$key->materi) }}" class="btn btn-success btn-sm"><i class="fa fa-file" ></i></a>
                        @endif
                       </td>
                       <td>
                        @if($key->link)
                          <a target="_blank" href="{{ $key->link }}" class="btn btn-info btn-sm"><i class="fa fa-link"></i></a>
                        @endif
                       </td>
                   </tr>
                   @endforeach
                  
                 
                </tbody>
            </table>
        </div>
        <div class="col-lg-4">
            <p class="lead">Persayaratan
                <br>
                <br>
                Hari Pelaksanaan : {{ $hari }}
              </p>
        </div>
    </div> --}}

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