<?php

use Illuminate\Support\Facades\Route;

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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('dashboard');

Route::group(['middleware' => 'auth'], function(){
    Route::resource('prodi','Admin\ProdiController');
    Route::resource('kurikulum','Admin\KurikulumController');
    Route::resource('fakultas','Admin\FakultasController');
    Route::resource('periode','Admin\PeriodeController');
    Route::resource('matakuliah','Admin\MatakuliahController');
    Route::resource('mk-kurikulum','Admin\MatakuliahKurikulumController');
    Route::resource('user','Admin\UserController');

    Route::post('archived-faculty','Admin\FakultasController@archiveFaculty')->name('archiveFaculty');
    Route::post('archived-kurikulum','Admin\KurikulumController@archiveKurikulum')->name('archiveKurikulum');
    Route::post('archived-matakuliah','Admin\MatakuliahController@archiveMatakuliah')->name('archiveMatakuliah');
    Route::post('archived-prodi','Admin\ProdiController@archiveProdi')->name('archiveProdi');

    Route::post('switch-period','Admin\PeriodeController@switchPeriode')->name('change-period-status');
    Route::post('switch-matakuliah','Admin\MatakuliahController@switchMatakuliah')->name('change-matakuliah-status');
    Route::post('switch-kurikulum','Admin\KurikulumController@switchKurikulum')->name('change-kurikulum-status');
    Route::get('matakuliah-view','Admin\MatakuliahController@view')->name('view-detail-matakuliah');
    Route::get('profile','Admin\UserController@profile')->name('profile');

    Route::get('change-password', 'Admin\UserController@getPass');
    Route::post('change-password', 'Admin\UserController@postPass')->name('change-password');

    Route::get('/add-matakuliah-kurikulum/{id}','Admin\MatakuliahKurikulumController@index')->name('setting.mkkurikulum');
    Route::get('/add-matakuliah-kurikulums/{id}','Admin\MatakuliahKurikulumController@listMK')->name('list.mkkurikulum');
    Route::delete('/del-matakuliah-kurikulum/{id}','Admin\MatakuliahKurikulumController@destroy')->name('del.mkkurikulum');

    Route::get('show-archived-matakuliah','Admin\MatakuliahController@show')->name('show.archived.matakuliah');
    Route::post('unarchived-matakuliah','Admin\MatakuliahController@unarchiveMatakuliah')->name('unarchiveMatakuliah');
});
