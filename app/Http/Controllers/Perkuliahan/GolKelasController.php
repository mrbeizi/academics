<?php

namespace App\Http\Controllers\Perkuliahan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Perkuliahan\GolKelas;
use App\Model\Periode;
use Response;
use Session;
use Validator;
use Auth;

class GolKelasController extends Controller
{
    public function index(Request $request)
    {
        $getData = GolKelas::leftJoin('periodes','periodes.id','=','gol_kelas.id_periode')
            ->select('gol_kelas.id AS id','gol_kelas.*','periodes.nama_periode')
            ->get();
                
        if($request->ajax()){
            return datatables()->of($getData)
                ->addColumn('action', function($data){
                        $button = '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="bottom" title="Edit" data-id="'.$data->id.'" data-original-title="Edit" class="edit btn btn-success btn-xs edit-post"><i class="bx bx-xs bx-edit"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="bx bx-xs bx-trash"></i></button>';
                        return $button;
                })->addColumn('setting', function($data){
                    return '<a href="'.Route('in.kelas',['id' => $data->id]).'" name="setting" class="dropdown-shortcuts-add text-body setting" data-id="'.$data->id.'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Add Class"><span class="badge bg-label-primary me-1"><i class="bx bx-xs bx-plus-circle"></i> '.$data->nama_golongan.'</span></a>';
                })
                ->rawColumns(['action','setting'])
                ->addIndexColumn(true)
                ->make(true);
        }
        $getPeriode = Periode::where('is_active','=',1)->get();
        return view('perkuliahan.gol-kelas.index', compact('getPeriode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_golongan' => 'required',
            'keterangan'    => 'required',
            'id_periode'    => 'required',
        ],[
            'nama_golongan.required' => 'Anda belum menginputkan nama golongan',
            'keterangan.required'    => 'Anda belum menginputkan keterangan',
            'id_periode.required'    => 'Anda belum memilih periode'
        ]);

        $post = GolKelas::updateOrCreate(['id' => $request->id],
                [
                    'nama_golongan' => $request->nama_golongan,
                    'id_periode'    => $request->id_periode,
                    'keterangan'    => $request->keterangan,
                    'is_archived'   => 0,
                ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = GolKelas::where($where)->first();
     
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = GolKelas::where('id',$id)->delete();     
        return response()->json($post);
    }
}
