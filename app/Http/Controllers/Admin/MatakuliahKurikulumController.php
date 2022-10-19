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
            ->select('matakuliah_kurikulums.id AS id','matakuliah_kurikulums.*','kurikulums.nama')
            ->where('periodes.is_active','=',1)
            ->get();
                
        if($request->ajax()){
            return datatables()->of($dataMatakuliah)
                ->addColumn('action', function($data){
                        $button = '<button type="button" name="view_detail" id="'.$data->id.'" class="view_detail btn btn-info btn-xs" data-toggle="tooltip" data-placement="bottom" title="View Details"><i class="fa fa-eye"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<a href="javascript:void(0)" data-id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Edit" class="edit btn btn-success btn-xs edit-post"><i class="fa fa-pen"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fa fa-trash"></i></button>';
                        return $button;
                })->addColumn('status', function($data){
                    return '<div class="custom-control">
                    <label class="switch switch-primary" for="'.$data->id.'">
                    <input type="checkbox" class="switch-input" onclick="MatakuliahStatus('.$data->id.','.$data->is_active.')" name="matakuliah-status" id="'.$data->id.'" '.(($data->is_active=='1')?'checked':"").'>
                    <span class="switch-toggle-slider"><span class="switch-on"><i class="bx bx-check"></i></span><span class="switch-off"><i class="bx bx-x"></i></span></span></label></div>';
                })
                ->rawColumns(['action','status'])
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
        ],[
            'id_kurikulum.required'     => 'Anda belum memilih kurikulum',
            'kode_matakuliah.required'  => 'Anda belum memilih matakuliah'
        ]);

        $post = MatakuliahKurikulum::updateOrCreate(['id' => $request->id],
                [
                    'id_kurikulum'      => $request->id_kurikulum,
                    'kode_matakuliah'   => $request->kode_matakuliah
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

    protected function view(Request $request)
    {
        $where = array('matakuliahs.id' => $request->dataId);
        $getDatas  = MatakuliahKurikulum::leftJoin('periodes','periodes.id','=','matakuliahs.id_periode')->where($where)->get(); 
        foreach($getDatas as $data){
            $content = '<table class="table table-borderless table-sm">
                        <tbody>
                            <tr><td>Subject ID</td><td>:</td><td>'.$data->kode.'</td></tr>
                            <tr><td>Name ID</td><td>:</td><td>'.$data->nama_id.'</td></tr>
                            <tr><td>Name EN</td><td>:</td><td>'.$data->nama_en.'</td></tr>
                            <tr><td>Name CH</td><td>:</td><td>'.$data->nama_ch.'</td></tr>
                            <tr><td>Theory Weight</td><td>:</td><td>'.$data->sks_teori.'</td></tr>
                            <tr><td>Practice Weight</td><td>:</td><td>'.$data->sks_praktek.'</td></tr>
                            <tr><td>Fac. Group</td><td>:</td><td>'.$data->golongan_fakultas.'</td></tr>
                            <tr><td>Prodi Group</td><td>:</td><td>'.$data->golongan_prodi.'</td></tr>
                            <tr><td>Period</td><td>:</td><td>'.$data->tahun.'</td></tr>
                            <tr><td>State</td><td>:</td><td>'.(($data->is_active == 1) ? "Active" : "Non-active").'</td>
                            </tr>
                        </tbody>
                    </table>';
        }    

        return response()->json(['table' => $content]);
    }
}
