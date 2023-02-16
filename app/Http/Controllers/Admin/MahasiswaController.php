<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Mahasiswa;
use Response;
use Session;
use Validator;
use Auth;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $dataMhs = Mahasiswa::leftJoin('periodes','periodes.id','=','mahasiswas.id_periode')
            ->leftJoin('prodis','prodis.id','=','mahasiswas.id_prodi')
            ->select('mahasiswas.id AS id','mahasiswas.*','periodes.nama_periode','prodis.nama_id AS nama_prodi')
            ->where('prodis.is_archived','=',0)
            ->get();
                
        if($request->ajax()){
            return datatables()->of($dataMhs)
                ->addColumn('action', function($data){
                        $button = '<a href="javascript:void(0)" name="archive-prodi" data-toggle="tooltip" data-placement="bottom" title="Archive" data-id="'.$data->id.'" data-placement="bottom" data-original-title="archiveprodi" class="archiveprodi btn btn-warning btn-xs archive-post"><i class="bx bx-xs bx-archive"></i></a>';
                        return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn(true)
                ->make(true);
        }
        return view('administrator.mahasiswa.index');
    }
}
