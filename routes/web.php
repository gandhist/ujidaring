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
		Route::resource('dashboardinstruktur','DashboardInstrukturController');
	});

	Route::post('updateDurasiUjian','DashboardInstrukturController@updateDurasiUjian');

	Route::get('sms','PesertaController@kirimSMS');
	Route::get('wa','PesertaController@kirimWA');

	Route::group(['prefix' => 'peserta'], function () {
		Route::get('dashboard','PesertaController@index');
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

	// Daftar Kantor
	Route::resource('penilaian', 'PenilaianController');

	// Fungsi Chain Bidang
	Route::post('bidang/chain','ChainController@bidang');
	Route::post('getDataModul/chain','ChainController@getDataModul');
	
	// Route::post('daftarkantor/filter', 'SuketControllers\DaftarKantorController@filter');
	// end

	
});
