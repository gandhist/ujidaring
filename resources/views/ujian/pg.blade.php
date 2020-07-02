@extends('frontend.main')

@section('content')

<h3>Waktu Pengerjaan <span id="timer"></span></h3>


<div class="containel-fluid">
    {{ $peserta->jawaban_r }}
    <div class="row">
        <div class="col-lg-6">
            <nav aria-label="Navigasi soal ujian">
                <ul class="nav" role="tablist">
                    @foreach ($peserta->jadwal_r->soalpg_r as $key)
                        @foreach ($peserta->jawaban_r as $item)
                            <?php
                            if ($peserta->jadwal_r->id == $item->id_jadwal && $key->no_soal == $item->id_soal) {
                                $is_active = "active";
                            }
                            else {
                                $is_active = "";
                            }
                             ?>
                        @endforeach
                        <li class="page-item {{ $is_active }}" role="presentation"><a class="page-link" href="#soal-{{ $key->no_soal }}" aria-control="soal-{{ $key->no_soal }}" role="tab" data-toggle="tab">{{ $key->no_soal }}</a></li>
                    @endforeach
                </ul>
              </nav>
        </div>
    </div>
    
    <div class="row" style="margin-top:100px">
        <div class="col-lg-12">
            <div class="tab-content">
                @foreach ($peserta->jadwal_r->soalpg_r as $key)
                <div role="tabpanel" class="tab-pane {{ $loop->iteration == 1 ? 'active' : '' }}" id="soal-{{ $key->no_soal }}">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">{{ $key->no_soal }}. {{ $key->soal }}</h4></div>
                      <div class="panel-body">
                        <div class="radio"> 
                            @if($loop->first)
                                <form name="formAdd" id="formAdd">
                                <input type="hidden" name="id_jadwal" id="id_jadwal" value="{{ $peserta->jadwal_r->id }}">
                            @endif
                          <label>
                            <input type="radio" name="jawaban[{{ $key->no_soal }}]" id="jawaban-{{ $key->no_soal }}a" value="{{ $key->id }}#a">A. {{ $key->pg_a }}</label>
                        </div>
                        <div class="radio">
                          <label>
                            <input type="radio" name="jawaban[{{ $key->no_soal }}]" id="jawaban-{{ $key->no_soal }}b" value="{{ $key->id }}#b">B. {{ $key->pg_b }}</label>
                        </div>
                        <div class="radio">
                          <label>
                            <input type="radio" name="jawaban[{{ $key->no_soal }}]" id="jawaban-{{ $key->no_soal }}c" value="{{ $key->id }}#c">C. {{ $key->pg_c }}</label>
                        </div>
                        <div class="radio">
                          <label>
                            <input type="radio" name="jawaban[{{ $key->no_soal }}]" id="jawaban-{{ $key->no_soal }}d" value="{{ $key->id }}#d">D. {{ $key->pg_d }}</label>
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
    <div class="row">
        <div class="col-lg-12">
            <div align="center">
                <button type="button" class="btn btn-outline-success" id="btnSelesai"><i class="fa fa-save"></i> Selesai</button>
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
    }) 

    // timer soal ujian
    var eventTime= 1366549200; // Timestamp - Sun, 21 Apr 2013 13:00:00 GMT
    var currentTime = 1366547400; // Timestamp - Sun, 21 Apr 2013 12:30:00 GMT
    var diffTime = eventTime - currentTime;
    var duration = moment.duration(diffTime*1000, 'milliseconds');
    var interval = 1000;

    setInterval(function(){
    duration = moment.duration(duration - interval, 'milliseconds');
        $('#timer').text(duration.hours() + ":" + duration.minutes() + ":" + duration.seconds())
        }, interval
    );

})

// function active nav menu on jawaban filled up
function is_filled(id, tabsoal){
    // console.log(id)
    // console.log(tabsoal)
    if(id){
    $("a[href$='"+tabsoal+"']").parent().addClass('active')
    }
}


function storeData(){
    var formData = new FormData($('#formAdd')[0]);
    // for (i = 1; i <= jml_soal; i++) {
    //     var name = "jawaban["+i+"]";
    //     value = $('[name="' + name + '"]').val()
    //     console.log(value)
    // }
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
                // window.location.replace(home);
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