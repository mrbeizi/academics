<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Prodi;

class ApiMahasiswaProdiController extends Controller
{
    public function index(Request $request)
    {
        // Just for Prodi
        $getProdi = file_get_contents('put-your-url-here/api/prodi');
        $jsonProdi = json_decode($getProdi, TRUE);

        return view('administrator.api-mahasiswa-prodi.index', compact('jsonProdi'));
    }

    protected function showDataTable(Request $request)
    {
        $getApi = 'put-your-url-here/api/search-mahasiswa-prodi/'.$request->prodiSelect;
        $datas = file_get_contents($getApi);
        $json = json_decode($datas, TRUE);
        $rows = array();

        
            $contents = '<div class="card-body">
                        <table id="datatable-mahasiswa" class="table table-hover table-responsive">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>NIM Generated</th>
                                <th>Nama Lengkap</th>
                                <th>Prodi</th>
                                <th>Action</th>                
                            </tr>
                        </thead>
                        <tbody>';
            if(!empty($json)){
            foreach($json as $no => $data){
            $contents .= '
                            <tr>
                                <td>'.++$no.'</td>
                                <td><span class="badge bg-label-primary me-1">'.$data['tahun'].' . '.$data['kode_nim'].' . '. sprintf('%03d', $no++).'</span></td>
                                <td>'.$data['nama_lengkap'].'</td>
                                <td>'.$data['prodi_fix'].'</td>
                                <td>
                                    <button type="button" name="view_detail" id="'.$data['kode_registrasi'].'" class="view_detail btn btn-info btn-xs" data-toggle="tooltip" data-placement="bottom" title="View Details"><i class="bx bx-xs bx-show"></i></button>&nbsp;&nbsp;
                                    <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data['kode_registrasi'].'" data-toggle="tooltip" data-placement="bottom" title="Edit" data-original-title="Edit" class="edit btn btn-success btn-xs edit-post"><i class="bx bx-xs bx-edit"></i></a>&nbsp;&nbsp;
                                    <button type="button" name="delete" id="'.$data['kode_registrasi'].'" data-toggle="tooltip" data-placement="bottom" title="Delete" class="delete btn btn-danger btn-xs"><i class="bx bx-xs bx-trash"></i></button>
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
}
