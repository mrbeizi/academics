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
        $data = file_get_contents($getApi);
        $json = json_decode($data, TRUE);

        if($request->ajax()){
            return datatables()->of($json)
                ->addColumn('action', function($data){
                        $button = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data['id'].'" data-toggle="tooltip" data-placement="bottom" title="Edit" data-original-title="Edit" class="edit btn btn-success btn-xs edit-post"><i class="bx bx-xs bx-edit"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data['id'].'" data-toggle="tooltip" data-placement="bottom" title="Delete" class="delete btn btn-danger btn-xs"><i class="bx bx-xs bx-trash"></i></button>';
                        return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn(true)
                ->make(true);
        }
        $getPeriode = Periode::where('is_active','=',1)->get();
        return view('administrator.mahasiswa.index', compact('json'));
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = Mahasiswa::where($where)->first();
     
        return response()->json($post);
    }
}
