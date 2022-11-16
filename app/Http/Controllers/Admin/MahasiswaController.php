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
        $getApi = 'put your api here';
        $datas = file_get_contents($getApi);
        $json = json_decode($datas, TRUE);

        if($request->ajax()){
            return datatables()->of($json)
                ->addColumn('action', function($data){
                        $button = '<button type="button" name="view_detail" id="'.$data[0]['kode_registrasi'].'" class="view_detail btn btn-info btn-xs" data-toggle="tooltip" data-placement="bottom" title="View Details"><i class="bx bx-xs bx-show"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data[0]['kode_registrasi'].'" data-toggle="tooltip" data-placement="bottom" title="Edit" data-original-title="Edit" class="edit btn btn-success btn-xs edit-post"><i class="bx bx-xs bx-edit"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data[0]['kode_registrasi'].'" data-toggle="tooltip" data-placement="bottom" title="Delete" class="delete btn btn-danger btn-xs"><i class="bx bx-xs bx-trash"></i></button>';
                        return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn(true)
                ->make(true);
        }
        $getPeriode = Periode::where('is_active','=',1)->get();
        return view('administrator.mahasiswa.index', compact('json'));
    }

    protected function view(Request $request)
    {
        
        $getApi = 'put your api here';
        $datas = file_get_contents($getApi);
        $json = json_decode($datas, TRUE);
        $rows = array();

        foreach($json as $data){
            $content = '<table class="table table-borderless table-sm">
                        <tbody>
                            <tr><td>Subject ID</td><td>:</td><td>'.$data[0]['kode_registrasi'].'</td></tr>
                            <tr><td>Name ID</td><td>:</td><td>'.$data[0]['isi_data'].'</td></tr>
                            <tr><td>Name EN</td><td>:</td><td>'.$data[0]['no_hp'].'</td></tr>
                            <tr><td>Name CH</td><td>:</td><td>'.$data[0]['nama_prodi'].'</td></tr>
                        </tbody>
                    </table>';
        }    

        return response()->json(['table' => $content]);

    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = Mahasiswa::where($where)->first();
     
        return response()->json($post);
    }
}
