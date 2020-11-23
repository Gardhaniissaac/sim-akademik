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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('dosen', 'DosenController');

Route::resource('fakultas', 'FakultasController');

Route::resource('jurusan', 'JurusanController');

Route::resource('kelas', 'KelasController');

Route::resource('mahasiswa', 'MahasiswaController');

Route::resource('matkulr', 'MatkulrController');

Route::resource('profile', 'ProfileController');

Route::resource('rencana', 'RencanaController');

Route::resource('transkrip', 'TranskripController');

Route::resource('tu', 'TuController');

Route::get('/listmahasiswa', 'MahasiswaController@showPdf');

Route::get('/listjurusan', 'JurusanController@showPdf');

Route::get('/listfakultas', 'FakultasController@showPdf');

Route::get('/listdosen', 'DosenController@showPdf');

Route::get('/listtu', 'TuController@showPdf');

Route::get('/listkelas', 'KelasController@showPdf');

Route::get('/transkripmahasiswa', 'TranskripController@showPdf');

Route::get('/rencanastudi/{rencana}', 'RencanaController@showPdf')->name('rencana.rencanastudi');

Route::get('/mahasiswaexport', 'MahasiswaController@exportExcel');

Route::get('/jurusanexport', 'JurusanController@exportExcel');

Route::get('/fakultasexport', 'FakultasController@exportExcel');

Route::get('/dosenexport', 'DosenController@exportExcel');

Route::get('/tuexport', 'TuController@exportExcel');

Route::get('/kelasexport', 'KelasController@exportExcel');