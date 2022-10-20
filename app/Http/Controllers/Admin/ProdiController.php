<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Fakultas;
use App\Model\Periode;
use App\Model\Prodi;

class ProdiController extends Controller
{
    public function index(Request $request)
    {
        $dataProdi = Prodi::leftJoin('periodes','periodes.id','=','prodis.id_periode')
            ->leftJoin('fakultas','fakultas.id','=','prodis.id_fakultas')
            ->select('prodis.id AS id','prodis.*','periodes.nama_periode','fakultas.nama_id AS nama_fakultas')
            ->where('periodes.is_active','=',1)
            ->get();
                
        if($request->ajax()){
            return datatables()->of($dataProdi)
                ->addColumn('action', function($data){
                        $button = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->id.'" data-original-title="Edit" class="edit btn btn-success btn-xs edit-post"><i class="fa fa-pen"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>';
                        return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn(true)
                ->make(true);
        }
        $getFaculty = Fakultas::where('is_archived','=',0)->get();
        $getPeriode = Periode::where('is_active','=',1)->get();
        return view('administrator.prodi.index', compact('getFaculty','getPeriode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_prodi'    => 'required',
            'kode_dikti'    => 'required',
            'id_fakultas'   => 'required',
            'id_periode'    => 'required',
            'nama_id'       => 'required',
        ],[
            'kode_prodi.required'    => 'Anda belum menginputkan kode prodi',
            'kode_dikti.required'    => 'Anda belum menginputkan kode dikti',
            'id_fakultas.required'   => 'Anda belum memilih fakultas',
            'id_periode.required'    => 'Anda belum memilih periode',
            'nama_id.required'       => 'Anda belum menginputkan nama'
        ]);

        $post = Prodi::updateOrCreate(['id' => $request->id],
                [
                    'kode_prodi'        => $request->kode_prodi,
                    'kode_dikti'        => $request->kode_dikti,
                    'id_fakultas'       => $request->id_fakultas,
                    'id_periode'        => $request->id_periode,
                    'nama_id'           => $request->nama_id,
                    'nama_en'           => $request->nama_en,
                    'nama_ch'           => $request->nama_ch,
                    'is_archived'       => 0
                ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = Prodi::where($where)->first();     
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = Prodi::where('id',$id)->delete();     
        return response()->json($post);
    }
}
