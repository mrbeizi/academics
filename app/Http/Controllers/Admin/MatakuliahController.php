<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Matakuliah;
use App\Model\Periode;

class MatakuliahController extends Controller
{
    public function index(Request $request)
    {
        $dataMatakuliah = Matakuliah::leftJoin('periodes','periodes.id','=','matakuliahs.id_periode')
            ->select('matakuliahs.id AS id','matakuliahs.*','periodes.nama_periode')
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
        $getPeriode = Periode::where('is_active','=',1)->get();
        return view('administrator.matakuliah.index', compact('getPeriode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode'              => 'required',
            'nama_id'           => 'required',
            'sks_teori'         => 'required',
            'sks_praktek'       => 'required',
            'golongan_fakultas' => 'required',
            'golongan_prodi'    => 'required',
            'id_periode'        => 'required',
        ],[
            'kode.required'              => 'Anda belum menginputkan kode matakuliah',
            'nama_id.required'           => 'Anda belum menginputkan nama',
            'sks_teori.required'         => 'Anda belum menginputkan jumlah SKS teori',
            'sks_praktek.required'       => 'Anda belum menginputkan jumlah SKS praktek',
            'golongan_fakultas.required' => 'Anda belum memilih golongan fakultas',
            'golongan_prodi.required'    => 'Anda belum memilih golongan prodi',
            'id_periode.required'        => 'Anda belum memilih periode'
        ]);

        $post = Matakuliah::updateOrCreate(['id' => $request->id],
                [
                    'kode'              => $request->kode,
                    'nama_id'           => $request->nama_id,
                    'nama_en'           => $request->nama_en,
                    'nama_ch'           => $request->nama_ch,
                    'sks_teori'         => $request->sks_teori,
                    'sks_praktek'       => $request->sks_praktek,
                    'golongan_fakultas' => $request->golongan_fakultas,
                    'golongan_prodi'    => $request->golongan_prodi,
                    'id_periode'        => $request->id_periode,
                    'is_active'         => 1,
                    'is_archived'       => 0
                ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = Matakuliah::where($where)->first();
     
        return response()->json($post);
    }

    public function switchMatakuliah(Request $request)
    {
        $req    = $request->is_active == '1' ? 0 : 1;
        $post   = Matakuliah::updateOrCreate(['id' => $request->id],['is_active' => $req]); 
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = Matakuliah::where('id',$id)->delete();     
        return response()->json($post);
    }

    protected function view(Request $request)
    {
        $where = array('matakuliahs.id' => $request->dataId);
        $getDatas  = Matakuliah::leftJoin('periodes','periodes.id','=','matakuliahs.id_periode')
            ->select('matakuliahs.id AS id','matakuliahs.*','matakuliahs.is_active AS is_active','periodes.id AS id_periode','periodes.is_active AS status_periode','periodes.nama_periode')
            ->where($where)
            ->get(); 
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
                            <tr><td>Period</td><td>:</td><td>'.$data->nama_periode.'</td></tr>
                            <tr><td>State</td><td>:</td><td>'.(($data->is_active == 1) ? "Active <div class='spinner-grow spinner-grow-sm text-success' role='status'>" : "Non-active").'</td>
                            </tr>
                        </tbody>
                    </table>';
        }    

        return response()->json(['table' => $content]);
    }
}
