<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\MatakuliahKurikulum;
use App\Model\Matakuliah;
use App\Model\Kurikulum;
use App\Model\Periode;

class MatakuliahKurikulumController extends Controller
{
    public function index(Request $request)
    {
        $dataMatakuliah = MatakuliahKurikulum::leftJoin('kurikulums','kurikulums.id','=','matakuliah_kurikulums.id_kurikulum')
            ->leftJoin('periodes','periodes.id','=','kurikulums.id_periode')
            ->leftJoin('matakuliahs','matakuliahs.kode','=','matakuliah_kurikulums.kode_matakuliah')
            ->select('matakuliah_kurikulums.id AS id','matakuliah_kurikulums.*','kurikulums.nama','matakuliahs.nama_id')
            ->where('periodes.is_active','=',1)
            ->get();
                
        if($request->ajax()){
            return datatables()->of($dataMatakuliah)
                ->addColumn('action', function($data){
                        $button = '<a href="javascript:void(0)" data-id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Edit" class="edit btn btn-success btn-xs edit-post"><i class="fa fa-pen"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fa fa-trash"></i></button>';
                        return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn(true)
                ->make(true);
        }
        $getMatakuliah = Matakuliah::where('is_active','=',1)->get();
        $getKurikulum = Kurikulum::where('is_active','=',1)->get();
        return view('administrator.mk-kurikulum.index', compact('getMatakuliah','getKurikulum'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kurikulum'              => 'required',
            'kode_matakuliah'           => 'required',
            'semester'                  => 'required',
        ],[
            'id_kurikulum.required'     => 'Anda belum memilih kurikulum',
            'kode_matakuliah.required'  => 'Anda belum memilih matakuliah',
            'semester.required'         => 'Anda belum mengisi kolom semester'
        ]);

        $post = MatakuliahKurikulum::updateOrCreate(['id' => $request->id],
                [
                    'id_kurikulum'      => $request->id_kurikulum,
                    'kode_matakuliah'   => $request->kode_matakuliah,
                    'semester'          => $request->semester
                ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = MatakuliahKurikulum::where($where)->first();
     
        return response()->json($post);
    }

    public function switchMatakuliah(Request $request)
    {
        $req    = $request->is_active == '1' ? 0 : 1;
        $post   = MatakuliahKurikulum::updateOrCreate(['id' => $request->id],['is_active' => $req]); 
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = MatakuliahKurikulum::where('id',$id)->delete();     
        return response()->json($post);
    }
}
