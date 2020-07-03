@extends('frontend.main')

@section('content')

<h3>Waktu Pengerjaan Tersisa <span id="timer"></span></h3>
<p>Waktu Ujian: {{ \Carbon\Carbon::parse($peserta->jadwal_r->mulai_ujian)->isoFormat('HH:mm:SS') }} s/d {{ \Carbon\Carbon::parse($peserta->jadwal_r->akhir_ujian)->isoFormat('HH:mm:SS') }}</p>
<p>Durasi Ujian: {{ $peserta->jadwal_r->durasi_ujian }}</p>
<p>Jam Anda Mulai Ujian: {{ \Carbon\Carbon::parse($peserta->mulai_ujian)->isoFormat('HH:mm:SS') }}</p>

<div class="containel-fluid">
    {{-- pilihan ganda --}}
    <div class="row">
        <div class="col-lg-12">
            <h4>Soal Pilihan Ganda :</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <nav aria-label="Navigasi soal ujian">
                <ul class="nav" role="tablist">
                    @foreach ($soal as $key)
                        <li class="page-item {{ $key->jawaban != null ? "active" : "" }}" role="presentation"><a class="page-link" href="#soal-{{ $key->soal_r->no_soal }}" aria-control="soal-{{ $key->soal_r->no_soal }}" role="tab" data-toggle="tab">{{ $key->soal_r->no_soal }}</a></li>
                    @endforeach
                </ul>
              </nav>
        </div>
    </div>
    
    <div class="row" style="margin-top:10px">
        <div class="col-lg-12">
            <div class="tab-content">
                @foreach ($soal as $key)
                <div role="tabpanel" class="tab-pane {{ $loop->iteration == 1 ? 'active' : '' }}" id="soal-{{ $key->soal_r->no_soal }}">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">{{ $key->soal_r->no_soal }}. {{ $key->soal_r->soal }}</h4></div>
                      <div class="panel-body">
                        <div class="radio"> 
                            @if($loop->first)
                                <form name="formAdd" id="formAdd">
                                <input type="hidden" name="id_jadwal" id="id_jadwal" value="{{ $peserta->jadwal_r->id }}">
                            @endif
                          <label>
                            <input type="radio" {{ $key->jawaban == "a" ? "checked" : "" }} name="jawaban[{{ $key->soal_r->no_soal }}]" id="jawaban-{{ $key->soal_r->no_soal }}a" value="{{ $key->soal_r->id }}#a">A. {{ $key->soal_r->pg_a }}</label>
                        </div>
                        <div class="radio">
                          <label>
                            <input type="radio" {{ $key->jawaban == "b" ? "checked" : "" }} name="jawaban[{{ $key->soal_r->no_soal }}]" id="jawaban-{{ $key->soal_r->no_soal }}b" value="{{ $key->soal_r->id }}#b">B. {{ $key->soal_r->pg_b }}</label>
                        </div>
                        <div class="radio">
                          <label>
                            <input type="radio" {{ $key->jawaban == "c" ? "checked" : "" }} name="jawaban[{{ $key->soal_r->no_soal }}]" id="jawaban-{{ $key->soal_r->no_soal }}c" value="{{ $key->soal_r->id }}#c">C. {{ $key->soal_r->pg_c }}</label>
                        </div>
                        <div class="radio">
                          <label>
                            <input type="radio" {{ $key->jawaban == "d" ? "checked" : "" }} name="jawaban[{{ $key->soal_r->no_soal }}]" id="jawaban-{{ $key->soal_r->no_soal }}d" value="{{ $key->soal_r->id }}#d">D. {{ $key->soal_r->pg_d }}</label>
                        </div>
                        @if($loop->last)
                            </form>
                        @endif
                      </div>
                    </div>
                  </div>
                  <?php $soal = $loop->iteration; ?>
                @endforeach
            


              </div>
        </div>
        
    </div>
    {{-- end of pilihan ganda --}}
<hr>
    {{-- essay --}}
    <div class="row">
        <div class="col-lg-12">
            <h4>Soal Essay :</h4>
        </div>
    </div>
    <form name="formEssay" id="formEssay">
        <input type="hidden" name="id_jadwal" id="id_jadwal" value="{{ $peserta->jadwal_r->id }}">
    @foreach($soal_essay as $key)
    <div class="row" style="margin-top:5px">
        <div class="col-lg-6">
            <h5>{{ $key->soal_r->no_soal }}. {{ $key->soal_r->soal }}</h5>
        </div>
        <div class="col-lg-6">
            <textarea class="form-control txtEssay" name="essay_{{ $key->id_soal }}" id="essay_{{ $key->id_soal }}">@if($key->jawaban){{ $key->jawaban }}@endif</textarea>
        </div>
    </div>
    @endforeach
    </form>
    {{-- end of soal essay --}}

    <div class="row" style="margin-top:10px">
        <div class="col-lg-12">
            <div align="center">
                <button type="button" class="btn btn-outline-success" id="btnSelesai"><i class="fa fa-save"></i> Selesaikan Ujian</button>
            </div>
        </div>
    </div>

</div>
<hr>
<div class="container">
    <main role="main" class="container">
          <blockquote class="blockquote text-center">
              <p class="mb-0">Kurang Cerdas dapat diperbaiki dengan belajar, Kurang cakap dapat dihilangkan dengan pengalaman. Namun tidak jujur itu sulit di perbaiki</p>
              <footer class="blockquote-footer"> Muhammad Hatta</footer>
            </blockquote>
      </main>
          
  </div>



@endsection
@push('script')
<script>
    var jml_soal = "{{ $soal }}";
    var home = "{{ url('peserta/dashboard') }}";
    var timer;
$(document).ready(function () {
      // OPSIONAL: Buat event listener untuk pindah
    // ke soal selanjutnya ketika input radio dipilih
    $('[id^="soal-"] input:radio').on('change', function() {
        // Dapatkan obyek jQuery dari panel soal aktif
        var $panelSoalAktif = $(this).closest('.tab-pane');

        //id panel soal sekarang
        var idSoalSekarang = $(this).attr('id')
        is_filled(idSoalSekarang,$panelSoalAktif.attr('id'))
        // console.log('idsoalskrg'+$('#'+idSoalSekarang+'').val())
        // storeTemp(idSoalSekarang)

        // Cari id panel soal selanjutnya
        var idSoalSelanjutnya = $panelSoalAktif.next('[id^="soal-"]').attr('id');

        // Aktifkan panel soal selanjutnya
        $('a[href="#' + idSoalSelanjutnya + '"]').tab('show');
        //active class soal selanjutnya
            //   $('.page-item').removeClass('active')
        // $("a[href$='"+idSoalSelanjutnya+"']").parent().addClass('active')
    });


    // onclick navigasi soal ujian
    $('.page-item').on('click', function(){
        //   $('.page-item').removeClass('active')
        // $(this).addClass('active')
    })

    // onclick btn save
    $('#btnSelesai').on('click', function(){
            // console.log($('.formSoal').length)
            var s = $('[name^="jawaban"]').val()
            // console.log(s)
        storeData();
        // storeDataEssay();
    }) 

    // on change jawaban essay
    $('.txtEssay').on('change', function(){
        var id = $(this).attr('id')
        var val = $('#'+id+'').val()
        storeDataParEs(id, val)
        // console.log(id)
    })

    // timer soal ujian
    // var currentTime= "{{ strtotime($peserta->mulai_ujian) }}"; // Timestamp - Sun, 21 Apr 2013 13:00:00 GMT
    var currentTime= "{{ \Carbon\Carbon::now()->timestamp }}"; // Timestamp - Sun, 21 Apr 2013 13:00:00 GMT
    var eventTime = "{{ strtotime($peserta->jadwal_r->akhir_ujian) }}"; // Timestamp - Sun, 21 Apr 2013 12:30:00 GMT
    var diffTime = eventTime - currentTime;
    var duration = moment.duration(diffTime*1000, 'milliseconds');
    var interval = 1000;

    timer = setInterval(function(){
        
    duration = moment.duration(duration - interval, 'milliseconds');
    stopTimer(duration);
        $('#timer').text(duration.hours() + ":" + duration.minutes() + ":" + duration.seconds())
        }, interval
    );

})

function stopTimer(duration){
    if (duration._data.hours <= 0 && duration._data.minutes <= 0 && duration._data.seconds <= 0) {
    var formData = new FormData($('#formAdd')[0]);
    var url = "{{ url('peserta/ujian/pg/save') }}";
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
            title: "Waktu Ujian Telah Habis!!",
            text: "Semua Jawaban Anda Sudah Tersimpan.",
            type: 'warning',
            confirmButtonText: 'Close',
            confirmButtonColor: '#AAA',
            onClose: function() {
                window.location.replace(home);
            }
          })
        }
      },
      error: function(xhr, status) {
          alert('terjadi error saat menyimpan data');
      }
    });
    // hentikan timer
        clearInterval(timer);
        
    }
}

// function active nav menu on jawaban filled up
function is_filled(id, tabsoal){
    console.log(id)
    var val = $('#'+id+'').val();
    storeDataPar(id, val)
    if(id){
    $("a[href$='"+tabsoal+"']").parent().addClass('active')
    }
}

// store data on click pg
function storeDataPar(id, val){
    var url = "{{ url('peserta/ujian/pg/save_parsial') }}";
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      url: url,
      type: 'POST',
      dataType: "JSON",
      data: {
          jawaban : val,
          id_jadwal : $('#id_jadwal').val()
      },
      success: function(response) {
        
      },
      error: function(xhr, status) {
          alert('terjadi error');
      }
    });
}

// store data on change essay
function storeDataParEs(id, val){
    var url = "{{ url('peserta/ujian/essay/save_parsial') }}";
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      url: url,
      type: 'POST',
      dataType: "JSON",
      data: {
          id_soal : id,
          jawaban : val,
          id_jadwal : $('#id_jadwal').val()
      },
      success: function(response) {
        
      },
      error: function(xhr, status) {
          alert('terjadi error');
      }
    });
}

// store all data essay
function storeDataEssay(){
    var formData = new FormData($('#formEssay')[0]);
    var url = "{{ url('peserta/ujian/essay/save') }}";
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
          alert('terjadi error saat simpan data')
      }
    });
}



function storeData(){
    var formData = new FormData($('#formAdd')[0]);
    var url = "{{ url('peserta/ujian/pg/save') }}";
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
        $('.form-group').removeClass('has-error');
        $('.help-block').hide(); // hide error span message

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
          var a = JSON.parse(xhr.responseText);
            // reset to remove error
            $('.form-group').parent().removeClass('has-error');
            $('.help-block').hide(); // hide error span message
            $.each(a.errors, function(key, value) {
                // console.log(key)
            $('[name="' + key + '"]').parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
            $('span[id^="' + key + '"]').show(); // show error message span
            // for select2
            if (!$('[id="' + key + '"]').is("select")) {
                $('[id="' + key + '"]').next().text(value); //select span help-block class set text error string
            }
            });
      }
    });
}



</script>
@endpush