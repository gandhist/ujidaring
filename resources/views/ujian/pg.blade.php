@extends('frontend.main')

@section('content')

<h3>Waktu Pengerjaan <span id="timer"></span></h3>


<div class="containel-fluid">
    
    <div class="row">
        <div class="col-lg-6">
            <nav aria-label="Navigasi soal ujian">
                <ul class="nav" role="tablist">
                @foreach ($peserta->jadwal_r->soalpg_r as $key)
                <li class="page-item {{ $loop->iteration == 1 ? 'active' : '' }}" role="presentation"><a class="page-link" href="#soal-{{ $key->no_soal }}" aria-control="soal-{{ $key->no_soal }}" role="tab" data-toggle="tab">{{ $key->no_soal }}</a></li>
                @endforeach
                  {{-- <li class="page-item" role="presentation"><a href="#soal-2" class="page-link" aria-control="soal-2" role="tab" data-toggle="tab">2</a></li>
                  <li class="page-item" role="presentation"><a href="#soal-3" class="page-link" aria-control="soal-3" role="tab" data-toggle="tab">3</a></li>
                  <li class="page-item" role="presentation"><a href="#soal-4" class="page-link" aria-control="soal-4" role="tab" data-toggle="tab">4</a></li>
                  <li class="page-item" role="presentation"><a href="#soal-5" class="page-link" aria-control="soal-5" role="tab" data-toggle="tab">5</a></li>
                  <li class="page-item" role="presentation"><a href="#soal-6" class="page-link" aria-control="soal-6" role="tab" data-toggle="tab">6</a></li>
                  <li class="page-item" role="presentation"><a href="#soal-7" class="page-link" aria-control="soal-7" role="tab" data-toggle="tab">7</a></li>
                  <li class="page-item" role="presentation"><a href="#soal-8" class="page-link" aria-control="soal-8" role="tab" data-toggle="tab">8</a></li>
                  <li class="page-item" role="presentation"><a href="#soal-9" class="page-link" aria-control="soal-9" role="tab" data-toggle="tab">9</a></li>
                  <li class="page-item" role="presentation"><a href="#soal-10"class="page-link"  aria-control="soal-10" role="tab" data-toggle="tab">10</a></li> --}}
                </ul>
              </nav>
        </div>
        {{-- <div class="col-lg-6 pull-right">
            <button type="button" class="btn btn-outline-success pull-right"><i class="fa fa-save"></i> Selesai</button>
        </div> --}}
    </div>
    
    <div class="row" style="margin-top:200px">

        <div class="col-lg-12">
            <div class="tab-content">
                @foreach ($peserta->jadwal_r->soalpg_r as $key)
                <div role="tabpanel" class="tab-pane {{ $loop->iteration == 1 ? 'active' : '' }}" id="soal-{{ $key->no_soal }}">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">{{ $key->no_soal }}. {{ $key->soal }}</h4></div>
                      <div class="panel-body">
                        <div class="radio">
                          <label>
                            <input type="radio" name="jawaban[{{ $key->no_soal }}]" id="jawaban-{{ $key->no_soal }}a" value="a">{{ $key->pg_a }}</label>
                        </div>
                        <div class="radio">
                          <label>
                            <input type="radio" name="jawaban[{{ $key->no_soal }}]" id="jawaban-{{ $key->no_soal }}b" value="b">{{ $key->pg_b }}</label>
                        </div>
                        <div class="radio">
                          <label>
                            <input type="radio" name="jawaban[{{ $key->no_soal }}]" id="jawaban-{{ $key->no_soal }}c" value="c">{{ $key->pg_c }}</label>
                        </div>
                        <div class="radio">
                          <label>
                            <input type="radio" name="jawaban[{{ $key->no_soal }}]" id="jawaban-{{ $key->no_soal }}d" value="d">{{ $key->pg_d }}</label>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
                {{-- <div role="tabpanel" class="tab-pane active" id="soal-1">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">1. Amet ullamco incididunt tempor sit commodo labore pariatur eiusmod nostrud exercitation proident non anim. Adipisicing et amet dolore in ut?</h4></div>
                    <div class="panel-body">
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[1]" id="jawaban-1a" value="a">Officia adipisicing adipisicing id qui cupidatat ipsum amet ex.</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[1]" id="jawaban-1b" value="b">Aliqua voluptate anim tempor deserunt dolore aliquip nulla eiusmod sit voluptate.</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[1]" id="jawaban-1c" value="c">Velit incididunt ex et veniam aute adipisicing ut consectetur reprehenderit aute qui ex ex adipisicing.</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[1]" id="jawaban-1d" value="d">Aute incididunt eu laborum in sit.</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[1]" id="jawaban-1e" value="e">Reprehenderit ea consectetur voluptate eu.</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="soal-2">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">2. Sit eu mollit aliquip exercitation eiusmod ullamco ipsum commodo. Aliquip sit consectetur eiusmod minim est dolor fugiat anim incididunt ad et sit sint?</h4></div>
                    <div class="panel-body">
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[2]" id="jawaban-2a" value="a">Nulla irure sunt in exercitation tempor ipsum occaecat incididunt ad.</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[2]" id="jawaban-2b" value="b">Et minim id laboris cupidatat nulla eiusmod duis id magna velit anim.</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[2]" id="jawaban-2c" value="c">Laboris quis nostrud dolor cillum.</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[2]" id="jawaban-2d" value="d">Do veniam ea ut irure excepteur duis nisi aute velit.</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[2]" id="jawaban-2e" value="e">Tempor consectetur ea Lorem non reprehenderit nulla sit eiusmod irure voluptate.</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="soal-3">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">3. Nulla cillum ad qui fugiat fugiat laboris sint ad cupidatat consequat magna. Exercitation consectetur nulla tempor est ea dolor exercitation non proident occaecat eu proident?</h4></div>
                    <div class="panel-body">
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[3]" id="jawaban-3a" value="a">Incididunt esse tempor ut quis duis amet consectetur deserunt consequat quis mollit consectetur non sunt.</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[3]" id="jawaban-3b" value="b">Tempor voluptate duis laboris labore ut.</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[3]" id="jawaban-3c" value="c">Irure esse excepteur sint do in.</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[3]" id="jawaban-3d" value="d">Dolore ad amet eu aliqua cupidatat quis tempor aliqua pariatur culpa et.</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[3]" id="jawaban-3e" value="e">Ea laborum irure Lorem deserunt mollit elit id aliquip eiusmod id eiusmod.</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="soal-4">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">4. Magna nostrud eiusmod culpa laboris sit ea occaecat fugiat aliqua adipisicing et. Deserunt veniam exercitation sunt eu ea enim dolore duis?</h4></div>
                    <div class="panel-body">
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[4]" id="jawaban-4a" value="a">Incididunt laborum consectetur irure non enim amet ut incididunt nostrud cillum et esse.</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[4]" id="jawaban-4b" value="b">Pariatur fugiat non dolor irure commodo est sunt qui incididunt veniam laboris dolor do.</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[4]" id="jawaban-4c" value="c">Velit Lorem ad magna cillum officia non nulla eiusmod dolore reprehenderit.</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[4]" id="jawaban-4d" value="d">Minim nulla ullamco aute qui.</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[4]" id="jawaban-4e" value="e">Nulla officia nostrud aute anim exercitation ut culpa aute.</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="soal-5">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">5. Tempor aliqua aliquip laboris nostrud fugiat qui nostrud. Non nisi Lorem voluptate nostrud ut ea id deserunt?</h4></div>
                    <div class="panel-body">
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[5]" id="jawaban-5a" value="a">Eu sit laborum sit deserunt eu pariatur eiusmod.</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[5]" id="jawaban-5b" value="b">Cupidatat ipsum elit sit Lorem aute tempor eiusmod ad nostrud cupidatat mollit irure.</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[5]" id="jawaban-5c" value="c">Est veniam elit sit qui Lorem ad ea mollit commodo magna eu commodo dolore.</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[5]" id="jawaban-5d" value="d">In minim duis quis minim cillum exercitation commodo laboris amet eu voluptate.</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[5]" id="jawaban-5e" value="e">Adipisicing sunt elit voluptate dolore minim amet voluptate aliqua tempor cupidatat laborum cillum do velit.</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="soal-6">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">6. Ut minim id sit enim ea ex consequat id nulla. Magna exercitation reprehenderit sunt cupidatat eu exercitation mollit mollit cupidatat irure fugiat?</h4></div>
                    <div class="panel-body">
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[6]" id="jawaban-6a" value="a">Aute exercitation laborum cupidatat laborum voluptate nisi Lorem.</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[6]" id="jawaban-6b" value="b">Voluptate proident non ad laborum velit deserunt duis in ipsum ut ex pariatur ex exercitation.</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[6]" id="jawaban-6c" value="c">Consectetur irure occaecat ad amet laborum velit cillum magna occaecat ut sint quis laborum.</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[6]" id="jawaban-6d" value="d">Mollit ea sint proident non laboris dolore veniam consequat dolor.</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[6]" id="jawaban-6e" value="e">Non irure ullamco commodo voluptate sit.</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="soal-7">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">7. Cillum ullamco laborum in ex cillum laboris fugiat. Occaecat aliquip dolore voluptate exercitation consectetur sit do dolore eiusmod laboris Lorem nisi nostrud non?</h4></div>
                    <div class="panel-body">
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[7]" id="jawaban-7a" value="a">Duis id in quis officia elit fugiat adipisicing laboris.</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[7]" id="jawaban-7b" value="b">Aliquip tempor exercitation amet enim irure non consectetur occaecat mollit pariatur.</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[7]" id="jawaban-7c" value="c">Anim excepteur dolore in est Lorem sit.</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[7]" id="jawaban-7d" value="d">Occaecat ullamco sit Lorem esse id pariatur ipsum amet.</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[7]" id="jawaban-7e" value="e">Laborum aute qui fugiat dolor nostrud tempor sint sit.</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="soal-8">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">8. Voluptate veniam nulla ullamco aliquip dolor consequat minim labore labore minim veniam incididunt aliqua nulla. Labore in officia elit ex cillum irure ea?</h4></div>
                    <div class="panel-body">
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[8]" id="jawaban-8a" value="a">Adipisicing sunt adipisicing laborum adipisicing adipisicing voluptate nostrud eu ut ut laborum.</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[8]" id="jawaban-8b" value="b">Reprehenderit nostrud est id est ea qui.</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[8]" id="jawaban-8c" value="c">Ut excepteur reprehenderit consequat elit aliquip laborum irure occaecat ad.</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[8]" id="jawaban-8d" value="d">Dolore excepteur fugiat dolor elit nisi.</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[8]" id="jawaban-8e" value="e">Commodo excepteur sint exercitation culpa.</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="soal-9">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">9. Ex dolor in ex eu incididunt in deserunt deserunt eiusmod est velit reprehenderit. Et adipisicing ea eiusmod dolor anim cillum?</h4></div>
                    <div class="panel-body">
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[9]" id="jawaban-9a" value="a">Irure adipisicing ea in fugiat velit eu ut eu anim ex nulla pariatur ea amet.</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[9]" id="jawaban-9b" value="b">Adipisicing nisi laborum veniam laboris eiusmod mollit consequat.</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[9]" id="jawaban-9c" value="c">Cupidatat commodo eiusmod voluptate irure occaecat Lorem exercitation officia.</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[9]" id="jawaban-9d" value="d">Mollit mollit nulla enim commodo veniam anim qui esse sit voluptate voluptate non.</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[9]" id="jawaban-9e" value="e">Commodo occaecat duis enim ut dolore.</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="soal-10">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">10. Nulla non labore cillum amet est magna magna aute. Irure est voluptate ipsum esse?</h4></div>
                    <div class="panel-body">
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[10]" id="jawaban-10a" value="a">Qui nostrud eiusmod culpa ullamco esse officia esse ad do qui.</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[10]" id="jawaban-10b" value="b">Do magna proident quis eu adipisicing.</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[10]" id="jawaban-10c" value="c">In irure aliquip ullamco esse ut laboris in irure commodo consectetur irure.</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[10]" id="jawaban-10d" value="d">Elit voluptate culpa id voluptate mollit amet ea eiusmod laborum.</label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="jawaban[10]" id="jawaban-10e" value="e">Duis fugiat consequat enim eiusmod anim.</label>
                      </div>
                    </div>
                  </div>
                </div> --}}

              </div>
        </div>
        
    </div>
</div>

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
$(document).ready(function () {
      // OPSIONAL: Buat event listener untuk pindah
    // ke soal selanjutnya ketika input radio dipilih
    $('[id^="soal-"] input:radio').on('change', function() {
        // Dapatkan obyek jQuery dari panel soal aktif
        var $panelSoalAktif = $(this).closest('.tab-pane');

        //id panel soal sekarang
        var idSoalSekarang = $(this).attr('id')
        // storeTemp(idSoalSekarang)

        // Cari id panel soal selanjutnya
        var idSoalSelanjutnya = $panelSoalAktif.next('[id^="soal-"]').attr('id');

        // Aktifkan panel soal selanjutnya
        $('a[href="#' + idSoalSelanjutnya + '"]').tab('show');
        //active class soal selanjutnya
            //   $('.page-item').removeClass('active')
        $("a[href$='"+idSoalSelanjutnya+"']").parent().addClass('active')
    });


    // onclick navigasi soal ujian
    $('.page-item').on('click', function(){
        //   $('.page-item').removeClass('active')
        $(this).addClass('active')
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




</script>
@endpush