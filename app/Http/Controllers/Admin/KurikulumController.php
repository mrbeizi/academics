<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Kurikulum;
use App\Model\Periode;
use App\Model\Prodi;

class KurikulumController extends Controller
{
    public function index(Request $request)
    {
        $dataKurikulum = Kurikulum::leftJoin('prodis','prodis.id','=','kurikulums.id_prodi')
            ->leftJoin('periodes','periodes.id','=','kurikulums.id_periode')
            ->select('kurikulums.id AS id','kurikulums.*','prodis.nama_in AS nama_prodi','periodes.tahun','kurikulums.is_active AS is_active')
            ->where('periodes.is_active','=',1)
            ->get();
                
        if($request->ajax()){
            return datatables()->of($dataKurikulum)
                ->addColumn('action', function($data){
                        $button = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->id.'" data-original-title="Edit" class="edit btn btn-success btn-xs edit-post"><i class="fa fa-pen"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>';
                        return $button;
                })->addColumn('status', function($data){
                    return '<div class="custom-control">
                    <label class="switch switch-primary" for="'.$data->id.'">
                    <input type="checkbox" class="switch-input" onclick="KurikulumStatus('.$data->id.','.$data->is_active.')" name="kurikulum-status" id="'.$data->id.'" '.(($data->is_active=='1')?'checked':"").'>
                    <span class="switch-toggle-slider"><span class="switch-on"><i class="bx bx-check"></i></span><span class="switch-off"><i class="bx bx-x"></i></span></span></label></div>';
                })
                ->rawColumns(['action','status'])
                ->addIndexColumn(true)
                ->make(true);
        }
        $getPeriode = Periode::where('is_active','=',1)->get();
        $getProdi = Prodi::where('is_archived','=',0)->get();
        return view('administrator.kurikulum.index', compact('getPeriode','getProdi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'       => 'required',
            'id_prodi'   => 'required',
            'id_periode' => 'required',
        ],[
            'nama.required'       => 'Anda belum menginputkan nama', 
            'id_prodi.required'   => 'Anda belum memilih prodi',
            'id_periode.required' => 'Anda belum memilih periode'
        ]);

        $post = Kurikulum::updateOrCreate(['id' => $request->id],
                [
                    'nama'        => $request->nama,
                    'id_prodi'    => $request->id_prodi,
                    'id_periode'  => $request->id_periode,
                    'is_active'   => 1,
                    'is_archived' => 0
                ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = Kurikulum::where($where)->first();
     
        return response()->json($post);
    }

    public function switchKurikulum(Request $request)
    {
        $req    = $request->is_active == '1' ? 0 : 1;
        $post   = Kurikulum::updateOrCreate(['id' => $request->id],['is_active' => $req]); 
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = Kurikulum::where('id',$id)->delete();     
        return response()->json($post);
    }
}
