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

    Route::post('archived-faculty','Admin\FakultasController@archiveFaculty')->name('archiveFaculty');
    Route::post('switch-period','Admin\PeriodeController@switchPeriode')->name('change-period-status');
    Route::post('switch-matakuliah','Admin\MatakuliahController@switchMatakuliah')->name('change-matakuliah-status');
    Route::post('switch-kurikulum','Admin\KurikulumController@switchKurikulum')->name('change-kurikulum-status');
    Route::get('matakuliah-view','Admin\MatakuliahController@view')->name('view-detail-matakuliah');
});
