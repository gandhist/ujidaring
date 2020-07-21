<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::auth();
Route::get('test/{id}','JadwalController@gen');
Route::group(['middleware' => 'auth'], function () {

	Route::group(['prefix' => 'instruktur'], function () {
		Route::get('modul/{id}','DashboardInstrukturController@modul');
		Route::post('modul/save','DashboardInstrukturController@store_modul');
		Route::resource('dashboardinstruktur','DashboardInstrukturController');
	});

	Route::post('cekDurasiUjian','DashboardInstrukturController@cekDurasiUjian');
	Route::post('updateDurasiUjian','DashboardInstrukturController@updateDurasiUjian');
	Route::post('instruktur/lihatevaluasi','DashboardInstrukturController@lihatevaluasi');
	Route::post('instruktur/dashboardinstruktur/{id}/uploadtugas','DashboardInstrukturController@uploadtugas');
	Route::post('instruktur/dashboardinstruktur/{id}/uploadsoal','DashboardInstrukturController@uploadsoal');

	Route::get('sms','PesertaController@kirimSMS');
	Route::get('wa','PesertaController@kirimWA');

	Route::group(['prefix' => 'peserta'], function () {
		Route::get('dashboard','PesertaController@index');
		Route::get('tugas','PesertaController@tugas');
		Route::post('tugas/save','PesertaController@tugas_store');
		Route::get('kuisioner','PesertaController@kuisioner');
		Route::get('makalah','PesertaController@makalah');
		Route::get('presentasi','PesertaController@presentasi');
		Route::post('presentasi/save','PesertaController@presentasi_store');
		Route::post('makalah/save','PesertaController@makalah_store');
		Route::post('kuisioner/save','PesertaController@kuisioner_store');
		Route::post('pkl/save','JadwalController@upload_pkl_store');

		Route::group(['prefix' => 'presensi'], function () {
			Route::get('/','PesertaController@absen');
			Route::post('datang','PesertaController@datang');
			Route::post('pulang','PesertaController@pulang');
		});

		Route::group(['prefix' => 'quis'], function () {
			// pre
			Route::group(['prefix' => 'pre'], function () {
				Route::get('/','PrequisController@index');
				Route::get('kerjakan/{id_p}/{id_jdwl_mod}','PrequisController@show');
				Route::post('tm/save_parsial','PrequisController@tm_save_parsial');
				Route::post('save_parsial','PrequisController@pg_save_parsial');
				Route::post('save','PrequisController@pg_save');
			});

			// pre
			Route::group(['prefix' => 'post'], function () {
				Route::get('/','PostQuisController@index');
				Route::get('kerjakan/{id_p}/{id_jdwl_mod}','PostQuisController@show');
				Route::post('tm/save_parsial','PostQuisController@tm_save_parsial');
				Route::post('save_parsial','PostQuisController@pg_save_parsial');
				Route::post('save','PostQuisController@pg_save');
			});

		});

		Route::group(['prefix' => 'ujian'], function () {
			Route::get('pg','PesertaController@ujian_pg');
			Route::post('pg/save','PesertaController@pg_save');
			Route::post('pg/save_parsial','PesertaController@pg_save_parsial');
			Route::post('essay/save','PesertaController@es_save');
			Route::post('essay/save_parsial','PesertaController@es_save_parsial');
			Route::get('essay','PesertaController@ujian_essay');
		});

		Route::group(['prefix' => 'buka'], function(){
			Route::get('materi/{id}','PesertaController@bukaMateri');
		});
	});

	// route absensi
	Route::group(['prefix' => 'absen'], function () {
		Route::get('/{id_jdwl}','AbsensiController@index');
	});
	// end of route absensi
	
	Route::group(['middleware' => 'auth.input'], function () {
		Route::get('', 'HomeController@index');
	});

	Route::group(['middleware' => 'auth.admin'], function () {
		Route::resources([
			'users' => 'UserController',
		]);
		Route::resources([
			'user_role' => 'UserRoleController',
		]);
	});

	// Daftar Kantor
	Route::resource('jadwal', 'JadwalController');
	Route::get('jadwal/{id}/dashboard','JadwalController@dashboard');
	Route::get('jadwal/peserta/{id}','JadwalController@peserta');
	Route::get('jadwal/peserta/{id_jadwal}/{id_peserta}','JadwalController@pesertadetail');
	Route::get('jadwal/instruktur/{id}','JadwalController@instruktur');
	Route::get('jadwal/soal/{id}','JadwalController@soal');
	Route::get('jadwal/tugas/{id}','JadwalController@tugas');
	Route::get('jadwal/absen/{id}','JadwalController@absen');
	Route::get('jadwal/aturjadwal/{id}','JadwalController@aturjadwal');
	Route::get('aturjadwal/{id_jadwal}/{id}/uploadquiz','JadwalController@uploadquiz');
	Route::get('jadwal/presentasi/{id}','JadwalController@presentasi');
	Route::post('jadwal/kirimaccount/instruktur','JadwalController@AccountInstruktur');
	Route::post('jadwal/kirimaccount/peserta','JadwalController@AccountPeserta');
	Route::get('jadwal/pkl/{id}','JadwalController@pkl')->name('pkl');
	Route::post('jadwal/upload/pkl','JadwalController@upload_pkl_store');
	Route::post('jadwal/absen/filter', 'JadwalController@filter_absen');
	Route::post('jadwal/aturjadwalstore','JadwalController@aturjadwalstore');
	Route::post('aturjadwal/uploadquizstore','JadwalController@uploadquizstore');
	
	Route::get('jadwal/evaluasi/{id}','JadwalController@evaluasi');
	Route::get('jadwal/evaluasi/{id_jadwal}/{id}/show','JadwalController@evaluasishow');
	Route::get('jadwal/evaluasi/{id_jadwal}/{id}/filter','JadwalController@evaluasifilter');
	Route::get('jadwal/evaluasi/{id_jadwal}/{id}/peserta','JadwalController@evaluasipeserta');

	Route::post('jadwal/lihatsoalpre','JadwalController@lihatsoalpre');
	Route::post('jadwal/lihatsoalpost','JadwalController@lihatsoalpost');

	Route::post('jadwal/peserta/tm','JadwalController@pesertatm');
	Route::post('jadwal/peserta/quisioner','JadwalController@pesertaquisioner');
	
	// Daftar Kantor
	Route::resource('penilaian', 'PenilaianController');

	// Fungsi Chain Bidang
	Route::post('bidang/chain','ChainController@bidang');
	Route::post('getDataModul/chain','ChainController@getDataModul');
	
	// Route::post('daftarkantor/filter', 'SuketControllers\DaftarKantorController@filter');
	// end

	
});
