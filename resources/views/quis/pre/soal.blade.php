<noscript>

  <style type="text/css">

      .pagecontainer {display:none;}

  </style>

  <div class="noscriptmsg">

  You don't have javascript enabled.  Good luck with that.

  </div>

</noscript>
<div class="soal" style="position: relative;">
    <div class="row">
      <div class="col-lg-12">
        <div >Halaman: {!! $pg->render() !!}</div>
    </div>
        <div class="col-lg-12">
            <nav aria-label="Navigasi soal ujian">No Soal : 
                <ul class="nav" role="tablist">
                    @foreach ($pg as $key)
                        {{-- <li class="page-item {{ $key->jawaban != null ? "active" : "" }}" role="presentation"><a class="page-link" href="#soal-{{ $key->soal_r->no_soal }}" aria-control="soal-{{ $key->soal_r->no_soal }}" role="tab" data-toggle="tab">{{ $key->soal_r->no_soal }}</a></li> --}}
                        <li class="page-item {{ $key->jawaban != null ? "active" : "" }}" role="presentation"><a class="page-link" href="#soal-{{ $key->no_soal }}" aria-control="soal-{{ $key->no_soal }}" >{{ $key->no_soal }}</a></li>
                    @endforeach
                </ul>
              </nav>
        </div>
    </div>
    
    <div class="row" style="margin-top:10px">
        <div class="col-lg-12">
            <div class="tab-content">
              <form name="formAdd" id="formAdd">
                <input type="hidden" name="id_jadwal" id="id_jadwal" value="{{ $modul_today->id }}">
                @foreach ($pg as $key)
                <div role="tabpanel" class="tab-pane active" id="soal-{{ $key->no_soal }}">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">{{ $key->no_soal }}.  {{ $key->soal_r->soal }}</h4></div>
                        
                      <div class="panel-body">
                        <div class="radio"> 
                          <label>
                            <input type="radio" onclick="is_filled($(this).attr('id'),$(this).closest('.tab-pane').attr('id'))" {{ $key->jawaban == "a" ? "checked" : "" }} name="jawaban[{{ $key->soal_r->id }}]" id="jawaban-{{ $key->soal_r->id }}a" value="{{ $key->soal_r->id }}#a">A. {{ $key->soal_r->pg_a }}</label>
                        </div>
                        <div class="radio">
                          <label>
                            <input type="radio" onclick="is_filled($(this).attr('id'),$(this).closest('.tab-pane').attr('id'))" {{ $key->jawaban == "b" ? "checked" : "" }} name="jawaban[{{ $key->soal_r->id }}]" id="jawaban-{{ $key->soal_r->id }}b" value="{{ $key->soal_r->id }}#b">B. {{ $key->soal_r->pg_b }}</label>
                        </div>
                        <div class="radio">
                          <label>
                            <input type="radio" onclick="is_filled($(this).attr('id'),$(this).closest('.tab-pane').attr('id'))" {{ $key->jawaban == "c" ? "checked" : "" }} name="jawaban[{{ $key->soal_r->id }}]" id="jawaban-{{ $key->soal_r->id }}c" value="{{ $key->soal_r->id }}#c">C. {{ $key->soal_r->pg_c }}</label>
                        </div>
                        <div class="radio">
                          <label>
                            <input type="radio" onclick="is_filled($(this).attr('id'),$(this).closest('.tab-pane').attr('id'))" {{ $key->jawaban == "d" ? "checked" : "" }} name="jawaban[{{ $key->soal_r->id }}]" id="jawaban-{{ $key->soal_r->id }}d" value="{{ $key->soal_r->id }}#d">D. {{ $key->soal_r->pg_d }}</label>
                        </div>
                        
                      </div>
                    </div>
                  </div>
                  <?php $soall = $loop->iteration; ?>
                  <hr>
                @endforeach
              </form>

                
              </div>
        </div>
        
        
    </div>
  </div>
  <div >Halaman: {!! $pg->render() !!}</div>
