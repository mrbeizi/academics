<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Prodi;

class ApiMahasiswaController extends Controller
{
    public function index(Request $request)
    {
        // Just for Api Mahasiswa
        $getApiMahasiswa = file_get_contents('put your api here');
        $jsonMahasiswa = json_decode($getApiMahasiswa, TRUE);

        if($request->ajax()){
            return datatables()->of($jsonMahasiswa)
                ->addColumn('action', function($data){
                        return '<button type="button" name="view_detail" id="'.$data['kode_registrasi'].'" class="view_detail btn btn-info btn-xs" data-toggle="tooltip" data-placement="bottom" title="View Details"><i class="bx bx-xs bx-show"></i></button>';
                })->addColumn('nim', function($data){
                    $string = "0";
                    $getProdi = Prodi::select('kode_nim','kode_prodi')->where('is_archived','=',0)->get();
                    foreach($getProdi as $kode){
                        if($kode->kode_prodi == $data['kode_prodi']){
                            $generateNim = $data['tahun'].' . '.$kode->kode_nim.' . '. sprintf('%03d', $string);                                               
                        }
                    }
                    return '<span class="badge bg-label-primary me-1">'.$generateNim.'</span>';
                })
                ->rawColumns(['action','nim'])
                ->addIndexColumn(true)
                ->make(true);
        }

        return view('administrator.api-mahasiswa.index', compact('jsonMahasiswa'));
    }

    public function viewformdetail(Request $request)
    {
        $getApi = 'put your api here/'.$request->dataId;
        $datas = file_get_contents($getApi);
        $json = json_decode($datas, TRUE);
        $rows = array();

        foreach($json as $data){
            $content = '<table class="table table-borderless table-sm">
                <tbody>
                    <tr><td>'.$data[39]['nama_data'].'</td><td>:</td><td>'.$data[39]['isi_data'].'</td></tr>
                    <tr><td>No Form</td><td>:</td><td>'.$data[0]['kode_registrasi'].'</td></tr>
                    <tr><td>Prodi</td><td>:</td><td>'.$data[0]['nama_prodi'].'</td></tr>
                    <tr><td>Angkatan</td><td>:</td><td>'.$data[0]['tahun'].'</td></tr>
                    <tr><td>'.$data[29]['nama_data'].'</td><td>:</td><td>'.$data[29]['isi_data'].'</td></tr>
                    <tr><td>Tempat, tanggal lahir</td><td>:</td><td>'.$data[30]['isi_data'].', '.$data[31]['isi_data'].'</td></tr>
                    <tr><td>'.$data[32]['nama_data'].'</td><td>:</td><td>'.$data[32]['isi_data'].'</td></tr>
                    <tr><td>'.$data[38]['nama_data'].'</td><td>:</td><td>'.$data[38]['isi_data'].'</td></tr>
                </tbody>
            </table>';
        }

        return response()->json(['table' => $content]);
    }
}
