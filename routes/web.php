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

	Route::get('sms','PesertaController@kirimSMS');
	Route::get('wa','PesertaController@kirimWA');
	Route::group(['prefix' => 'peserta'], function () {
		Route::get('dashboard','PesertaController@index');
		Route::group(['prefix' => 'ujian'], function () {
			Route::get('pg','PesertaController@ujian_pg');
			Route::post('pg/save','PesertaController@pg_save');
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

	
});
