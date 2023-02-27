<?php

namespace App\Http\Controllers\Perkuliahan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Perkuliahan\StatusKelasKuliah;
use App\Model\Periode;
use Response;
use Session;
use Validator;
use Auth;

class StatusKelasKuliahController extends Controller
{
    public function index(Request $request)
    {
        $getData = StatusKelasKuliah::leftJoin('periodes','periodes.id','=','status_kelas_kuliahs.id_periode')
            ->select('status_kelas_kuliahs.id AS id','status_kelas_kuliahs.*','periodes.nama_periode')
            ->get();
                
        if($request->ajax()){
            return datatables()->of($getData)
                ->addColumn('action', function($data){
                        $button = '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="bottom" title="Edit" data-id="'.$data->id.'" data-original-title="Edit" class="edit btn btn-success btn-xs edit-post"><i class="bx bx-xs bx-edit"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="bx bx-xs bx-trash"></i></button>';
                        return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn(true)
                ->make(true);
        }
        $getPeriode = Periode::where('is_active','=',1)->get();
        return view('perkuliahan.status-kelas-kuliah.index', compact('getPeriode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_status'   => 'required',
            'keterangan'    => 'required',
            'id_periode'    => 'required',
        ],[
            'nama_status.required'  => 'Anda belum menginputkan nama status',
            'keterangan.required'    => 'Anda belum menginputkan keterangan',
            'id_periode.required'    => 'Anda belum memilih periode'
        ]);

        $post = StatusKelasKuliah::updateOrCreate(['id' => $request->id],
                [
                    'nama_status'   => $request->nama_status,
                    'id_periode'    => $request->id_periode,
                    'keterangan'    => $request->keterangan,
                    'is_archived'   => 0,
                ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = StatusKelasKuliah::where($where)->first();
     
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = StatusKelasKuliah::where('id',$id)->delete();     
        return response()->json($post);
    }
}
