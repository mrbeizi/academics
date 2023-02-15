<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Keuangan\CustomBiaya;
use App\Model\Prodi;
use App\Model\Periode;
use Response;
use Session;
use Validator;
use Auth;

class CustomBiayaController extends Controller
{
    public function index(Request $request)
    {
        $dataCustomBiaya = CustomBiaya::leftJoin('periodes','periodes.id','=','custom_biayas.id_periode')
            ->select('custom_biayas.id AS id','custom_biayas.*','periodes.kode','periodes.nama_periode')
            ->get();                
        if($request->ajax()){
            return datatables()->of($dataCustomBiaya)
                ->addColumn('action', function($data){
                        $button = '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="bottom" title="Edit" data-id="'.$data->id.'" data-original-title="Edit" class="edit btn btn-success btn-xs edit-post"><i class="bx bx-xs bx-edit"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="bx bx-xs bx-trash"></i></button>';
                        return $button;
                })->addColumn('status', function($data){
                    return '<div class="custom-control">
                    <label class="switch switch-primary" for="'.$data->id.'">
                    <input type="checkbox" class="switch-input" onclick="CustomBiayaStatus('.$data->id.','.$data->is_active.')" name="custom-biaya-status" id="'.$data->id.'" '.(($data->is_active=='1')?'checked':"").'>
                    <span class="switch-toggle-slider"><span class="switch-on"><i class="bx bx-check"></i></span><span class="switch-off"><i class="bx bx-x"></i></span></span></label></div>';
                })->addColumn('setting', function($data){
                    if($data->is_active != 0){
                        return '<a href="'.Route('potongan-biaya',['id' => $data->id]).'" name="potongan" class="dropdown-shortcuts-add text-body potongan" data-id="'.$data->id.'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Set Disc."><span class="badge bg-label-warning me-1"><i class="bx bx-xs bx-plus-circle bx-tada"></i> Atur Potongan</span></a>';
                    }else{
                        return '<span class="badge bg-label-secondary me-1"><i class="bx bx-xs"></i> Inactive</span>';
                    }
                })
                ->rawColumns(['action','status','setting'])
                ->addIndexColumn(true)
                ->make(true);
        }
        $getProdi = Prodi::where('is_archived','=',0)->get();
        $getYearPeriod = Periode::all();
        return view('keuangan.custom-biaya.index', compact('getProdi','getYearPeriod'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_custom_biaya'    => 'required',
            'id_periode'           => 'required',
        ],[
            'nama_custom_biaya.required' => 'Anda belum mamasukkan nama biaya',
            'id_periode.required'        => 'Anda belum memilih periode'
        ]);

        $isactive = $request->input('is_active');
        if($isactive == null) { $isactive = $request->input('is_active') ?? 0; } 
        else { $isactive = $request->input('is_active') ?? 1; }

        $post   =   CustomBiaya::updateOrCreate(['id' => $request->id],
                    [
                        'nama_custom_biaya' => $request->nama_custom_biaya,
                        'id_periode'        => $request->id_periode,
                        'is_active'         => $isactive,
                        'is_archive'        => 0,
                    ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = CustomBiaya::where($where)->first();
     
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = CustomBiaya::where('id',$id)->delete();     
        return response()->json($post);
    }

    public function switchStatus(Request $request)
    {
        $checkState = CustomBiaya::where('is_active','=',1)->get();
        $req    = $request->is_active == '1' ? 0 : 1;
        foreach($checkState as $data){
            if($req == '1'){
                $data->update(['is_active' => 0]);
                $req = 1;
            } else {
                $data->update(['is_active' => 1]);
                $req = 0;
            }
        }

        $post   = CustomBiaya::updateOrCreate(['id' => $request->id],['is_active' => $req]); 
        return response()->json($post);
    }
}
