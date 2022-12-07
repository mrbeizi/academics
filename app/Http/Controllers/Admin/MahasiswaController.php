<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Mahasiswa;
use App\Model\Periode;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {

        // Just for TahunAjaran
        $getApiTahunAjaran = file_get_contents('http://join.uvers.ac.id/public/api/tahun-ajaran');
        $jsonTahunAjaran = json_decode($getApiTahunAjaran, TRUE);

        return view('administrator.mahasiswa.index', compact('jsonTahunAjaran'));
    }

    public function show(Request $request)
    {
        if($request->tahun){
            $getApi = 'put your api here/'.$request->tahun;
            $datas = file_get_contents($getApi);
            $json = json_decode($datas, TRUE);
        }else{
            $getApi = 'put your api here';
            $datas = file_get_contents($getApi);
            $json = json_decode($datas, TRUE);
        }
        if($request->ajax()){
            return datatables()->of($json)
                ->addColumn('action', function($data){
                        $button = '<button type="button" name="view_detail" id="'.$data['kode_registrasi'].'" class="view_detail btn btn-info btn-xs" data-toggle="tooltip" data-placement="bottom" title="View Details"><i class="bx bx-xs bx-show"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data['kode_registrasi'].'" data-toggle="tooltip" data-placement="bottom" title="Edit" data-original-title="Edit" class="edit btn btn-success btn-xs edit-post"><i class="bx bx-xs bx-edit"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data['kode_registrasi'].'" data-toggle="tooltip" data-placement="bottom" title="Delete" class="delete btn btn-danger btn-xs"><i class="bx bx-xs bx-trash"></i></button>';
                        return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn(true)
                ->make(true);
        }

        return view('administrator.mahasiswa.index');
    }

    protected function view(Request $request)
    {
        $getApi = 'put your api here/'.$request->dataId;
        $datas = file_get_contents($getApi);
        $json = json_decode($datas, TRUE);
        $rows = array();

        foreach($json as $no => $data){
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

    protected function showDataTable(Request $request)
    {
        $getApi = 'put your api here/'.$request->yearSelect;
        $datas = file_get_contents($getApi);
        $json = json_decode($datas, TRUE);
        $rows = array();
        $no = 1;
        $nim = 1;

        
            $contents = '<div class="card-body">
                        <table id="datatable-mahasiswa" class="table table-hover table-responsive">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>NIM Generated</th>
                                <th>Kode Registrasi</th>
                                <th>Nama Lengkap</th>
                                <th>Prodi</th>
                                <th>Action</th>                
                            </tr>
                        </thead>
                        <tbody>';
            if(!empty($json)){
            foreach($json as $data){
            $contents .= '
                            <tr>
                                <td>'.$no++.'</td>
                                <td><span class="badge bg-label-primary me-1">'.$data[0]['tahun'].' . '.$data[0]['kode_nim'].' . '. sprintf('%03d', $nim++).'</span></td>
                                <td>'.$data[0]['kode_registrasi'].'</td>
                                <td>'.$data[0]['nama_lengkap'].'</td>
                                <td>'.$data[0]['prodi_fix'].'</td>
                                <td>
                                    <button type="button" name="view_detail" id="'.$data[0]['kode_registrasi'].'" class="view_detail btn btn-info btn-xs" data-toggle="tooltip" data-placement="bottom" title="View Details"><i class="bx bx-xs bx-show"></i></button>&nbsp;&nbsp;
                                    <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data[0]['kode_registrasi'].'" data-toggle="tooltip" data-placement="bottom" title="Edit" data-original-title="Edit" class="edit btn btn-success btn-xs edit-post"><i class="bx bx-xs bx-edit"></i></a>&nbsp;&nbsp;
                                    <button type="button" name="delete" id="'.$data[0]['kode_registrasi'].'" data-toggle="tooltip" data-placement="bottom" title="Delete" class="delete btn btn-danger btn-xs"><i class="bx bx-xs bx-trash"></i></button>
                                </td>
                            </tr>';
            }} else {
            $contents .= '
                            <tr>
                                <td colspan="12" align="center">No data available in table</td>
                            </tr>
            ';
            }
            $contents .= '</tbody>
                        </table>
                        </div>';   

        return response()->json(['dataTable' => $contents]);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = Mahasiswa::where($where)->first();
     
        return response()->json($post);
    }
}
