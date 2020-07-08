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

Route::group(['middleware' => 'auth'], function () {

	Route::group(['prefix' => 'instruktur'], function () {
		Route::get('modul/{id}','DashboardInstrukturController@modul');
		Route::post('modul/save','DashboardInstrukturController@store_modul');
		Route::resource('dashboardinstruktur','DashboardInstrukturController');
	});

	Route::post('cekDurasiUjian','DashboardInstrukturController@cekDurasiUjian');
	Route::post('updateDurasiUjian','DashboardInstrukturController@updateDurasiUjian');
	Route::post('instruktur/dashboardinstruktur/{id}/uploadtugas','DashboardInstrukturController@uploadtugas');
	Route::post('instruktur/dashboardinstruktur/{id}/uploadsoal','DashboardInstrukturController@uploadsoal');

	Route::get('sms','PesertaController@kirimSMS');
	Route::get('wa','PesertaController@kirimWA');

	Route::group(['prefix' => 'peserta'], function () {
		Route::get('dashboard','PesertaController@index');
		Route::get('tugas','PesertaController@tugas');
		Route::post('tugas/save','PesertaController@tugas_store');
		Route::get('kuisioner','PesertaController@kuisioner');
		Route::post('kuisioner/save','PesertaController@kuisioner_store');

		Route::group(['prefix' => 'presensi'], function () {
			Route::get('/','PesertaController@absen');
			Route::post('datang','PesertaController@datang');
			Route::post('pulang','PesertaController@pulang');
		});

		Route::group(['prefix' => 'ujian'], function () {
			Route::get('pg','PesertaController@ujian_pg');
			Route::post('pg/save','PesertaController@pg_save');
			Route::post('pg/save_parsial','PesertaController@pg_save_parsial');
			Route::post('essay/save','PesertaController@es_save');
			Route::post('essay/save_parsial','PesertaController@es_save_parsial');
			Route::get('essay','PesertaController@ujian_essay');
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
	Route::get('jadwal/instruktur/{id}','JadwalController@instruktur');
	Route::get('jadwal/soal/{id}','JadwalController@soal');
	Route::get('jadwal/tugas/{id}','JadwalController@tugas');
	Route::get('jadwal/absen/{id}','JadwalController@absen');
	Route::post('jadwal/kirimaccount/instruktur','JadwalController@AccountInstruktur');
	Route::post('jadwal/kirimaccount/peserta','JadwalController@AccountPeserta');
	Route::get('jadwal/{id}/upload/pkl','JadwalController@upload_pkl')->name('uploadPkl');
	Route::post('jadwal/upload/pkl','JadwalController@upload_pkl_store');
	
	// Daftar Kantor
	Route::resource('penilaian', 'PenilaianController');

	// Fungsi Chain Bidang
	Route::post('bidang/chain','ChainController@bidang');
	Route::post('getDataModul/chain','ChainController@getDataModul');
	
	// Route::post('daftarkantor/filter', 'SuketControllers\DaftarKantorController@filter');
	// end

	
});
