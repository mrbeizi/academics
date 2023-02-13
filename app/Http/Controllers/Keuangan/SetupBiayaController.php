<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Keuangan\SetupBiaya;
use App\Model\Prodi;
use App\Model\Periode;
use Response;
use Session;
use Validator;
use Auth;

class SetupBiayaController extends Controller
{
    public function index(Request $request)
    {
        $dataSetupBiaya = SetupBiaya::leftJoin('prodis','prodis.id','=','setup_biayas.id_lingkup_biaya')
            ->leftJoin('periodes','periodes.id','=','setup_biayas.id_periode')
            ->select('setup_biayas.id AS id','setup_biayas.*','prodis.nama_id','periodes.kode','periodes.nama_periode')
            ->get();
                
        if($request->ajax()){
            return datatables()->of($dataSetupBiaya)
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
        $getProdi = Prodi::where('is_archived','=',0)->get();
        $getYearPeriod = Periode::where('is_active','=',1)->get();
        return view('keuangan.setup-biaya.index', compact('getProdi','getYearPeriod'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_biaya'           => 'required',
            'id_lingkup_biaya'     => 'required',
            'nilai'                => 'required',
            'id_periode'           => 'required',
        ],[
            'nama_biaya.required'        => 'Anda belum mamasukkan nama biaya',
            'id_lingkup_biaya.required'  => 'Anda belum memilih lingkup biaya',
            'nilai.required'             => 'Anda belum menginput biaya',
            'id_periode.required'        => 'Anda belum memilih periode'
        ]);

        $post   =   SetupBiaya::updateOrCreate(['id' => $request->id],
                    [
                        'nama_biaya'       => $request->nama_biaya,
                        'id_lingkup_biaya' => $request->id_lingkup_biaya,
                        'nilai'            => preg_replace('/\D/','', $request->nilai),
                        'id_periode'       => $request->id_periode,
                    ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = SetupBiaya::where($where)->first();
     
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = SetupBiaya::where('id',$id)->delete();     
        return response()->json($post);
    }
}
