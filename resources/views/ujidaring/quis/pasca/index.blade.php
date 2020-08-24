@extends('frontend.main')
@push('style')
<style>
html {
  scroll-behavior: smooth;
}
</style>
@endpush
@section('content')
<div class="container-fluid">
  <div class="row">

    <div class="col-lg-6">
      <button type="button" class="btn btn-secondary btn-sm" onclick="window.history.back()"><i class="fa fa-caret-left"></i> Kembali</button>
      <h3>Quis Harian</h3>
    </div>

  </div>
</div>


<hr>
<div class="container-fluid">
    <div class="row">
        @foreach($modul_today as $key)
          <div class="col-lg-6" style="margin-top:10px">
              <div class="card">
                  <div class="card-header">
                  {{ $key->modul_r->modul }}
                  </div>
                  <div class="card-body">
                    {{-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> --}}
                    @if(\Carbon\Carbon::now()->toDateTimeString() >= $key->awal_post_quiz && \Carbon\Carbon::now()->toDateTimeString() <= $key->akhir_post_quiz)
                    <h6 class="card-title">Waktu Pengerjaan: {{ \Carbon\Carbon::parse($key->awal_post_quiz)->isoFormat('DD MMMM YYYY HH:mm:SS') }} s/d {{ \Carbon\Carbon::parse($key->akhir_post_quiz)->isoFormat('HH:mm:SS') }} </h6>
                  <a href="{{ url('peserta/quis/post/kerjakan',[$peserta->id, $key->id]) }}" class="btn btn-primary">Kerjakan Quis</a>
                  @elseif(\Carbon\Carbon::now()->toDateTimeString() >= $key->akhir_post_quiz)
                      <div class="alert alert-secondary" role="alert">
                          WAKTU QUIS SUDAH HABIS
                      </div>
                  @endif
                  </div>
              </div>
          </div>
        @endforeach

  
    </div>
  </div>





@endsection
@push('script')
<script>
$(document).ready(function () {

})





</script>
@endpush