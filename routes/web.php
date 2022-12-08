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
    Route::resource('data-formulir','Admin\DataFormulirController');
    Route::resource('pegawai','Admin\PegawaiController');
    Route::resource('jabatan','Admin\JabatanController');
    Route::resource('jabatan-pegawai','Admin\JabatanPegawaiController');
    Route::resource('jabatan-akademik','Admin\JabatanAkademikController');
    Route::resource('mahasiswa','Admin\MahasiswaController');
    Route::resource('gol-matakuliah','Admin\GolMatakuliahController');
    Route::resource('status-pegawai','Admin\StatusPegawaiController');

    Route::post('archived-faculty','Admin\FakultasController@archiveFaculty')->name('archiveFaculty');
    Route::post('archived-kurikulum','Admin\KurikulumController@archiveKurikulum')->name('archiveKurikulum');
    Route::post('archived-matakuliah','Admin\MatakuliahController@archiveMatakuliah')->name('archiveMatakuliah');
    Route::post('archived-prodi','Admin\ProdiController@archiveProdi')->name('archiveProdi');
    Route::post('archived-data-formulir','Admin\DataFormulirController@archiveDataFormulir')->name('archiveDataFormulir');
    Route::post('archived-jabatan-pegawai','Admin\JabatanPegawaiController@archiveJabatanPegawai')->name('archiveJabatanPegawai');
    Route::post('archived-status-pegawai','Admin\StatusPegawaiController@archiveStatusPegawai')->name('archiveStatusPegawai');

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
    Route::get('show-archived-kurikulum','Admin\KurikulumController@show')->name('show.archived.kurikulum');
    Route::get('show-archived-fakultas','Admin\FakultasController@show')->name('show.archived.fakultas');
    Route::get('show-archived-prodi','Admin\ProdiController@show')->name('show.archived.prodi');
    Route::get('show-archived-data-formulir','Admin\DataFormulirController@show')->name('show.archived.dataformulir');
    Route::get('show-archived-jabatan-pegawai','Admin\JabatanPegawaiController@show')->name('show.archived.jabatanpegawai');
    Route::get('show-archived-status-pegawai','Admin\StatusPegawaiController@show')->name('show.archived.status.pegawai');
    
    Route::post('unarchived-matakuliah','Admin\MatakuliahController@unarchiveMatakuliah')->name('unarchiveMatakuliah');
    Route::post('unarchived-kurikulum','Admin\KurikulumController@unarchiveKurikulum')->name('unarchiveKurikulum');
    Route::post('unarchived-fakultas','Admin\FakultasController@unarchiveFakultas')->name('unarchiveFakultas');
    Route::post('unarchived-prodi','Admin\ProdiController@unarchiveProdi')->name('unarchiveProdi');
    Route::post('unarchived-data-formulir','Admin\DataFormulirController@unarchiveDataFormulir')->name('unarchiveDataFormulir');
    Route::post('unarchived-jabatan-pegawai','Admin\JabatanPegawaiController@unarchiveJabatanPegawai')->name('unarchiveJabatanPegawai');
    Route::post('unarchived-status-pegawai','Admin\StatusPegawaiController@unarchiveStatusPegawai')->name('unarchiveStatusPegawai');

    Route::get('mahasiswa-view','Admin\MahasiswaController@view')->name('view-detail-mahasiswa');

    // API Mahasiswa
    Route::get('/mahasiswa/tahun','Admin\MahasiswaController@show')->name('get.mahasiswa');
    Route::get('mahasiswa-view','Admin\MahasiswaController@view')->name('view-detail-mahasiswa');
    Route::get('datatable-mahasiswa','Admin\MahasiswaController@showDataTable')->name('datatable-mahasiswa');
    
    Route::resource('api-mahasiswa', 'Admin\ApiMahasiswaController');
    Route::get('api-mahasiswa-view','Admin\ApiMahasiswaController@viewformdetail')->name('view-detail-form');
    Route::resource('api-mahasiswa-prodi', 'Admin\ApiMahasiswaProdiController');
    Route::get('datatable-mahasiswa-prodi','Admin\ApiMahasiswaProdiController@showDataTable')->name('datatable-mahasiswa-prodi');
});
