<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Periode;

class PeriodeController extends Controller
{
    public function index(Request $request)
    {
        $dataPeriode = Periode::all();
                
        if($request->ajax()){
            return datatables()->of($dataPeriode)
                ->addColumn('action', function($data){
                        $button = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Edit" data-original-title="Edit" class="edit btn btn-success btn-xs edit-post"><i class="bx bx-xs bx-edit"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Delete" class="delete btn btn-danger btn-xs"><i class="bx bx-xs bx-trash"></i></button>';
                        return $button;
                })->addColumn('status', function($data){
                    return '<div class="custom-control">
                    <label class="switch switch-primary" for="'.$data->id.'">
                    <input type="checkbox" class="switch-input" onclick="PeriodeStatus('.$data->id.','.$data->is_active.')" name="period-status" id="'.$data->id.'" '.(($data->is_active=='1')?'checked':"").'>
                    <span class="switch-toggle-slider"><span class="switch-on"><i class="bx bx-check"></i></span><span class="switch-off"><i class="bx bx-x"></i></span></span></label></div>';
                })
                ->rawColumns(['action','status'])
                ->addIndexColumn(true)
                ->make(true);
        }
        return view('administrator.periode.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode'         => 'required',
            'nama_periode' => 'required',
            'input_nilai'  => 'required',
            'temp_open'    => 'required',
            'finish'       => 'required',
        ],[
            'kode.required'         => 'Anda belum menginputkan kode',
            'nama_periode.required' => 'Anda belum menginputkan nama periode',
            'input_nilai.required'  => 'Anda belum menginputkan nilai',
            'temp_open.required'    => 'Anda belum menginputkan temp open',
            'finish.required'       => 'Anda belum menginputkan finish',
        ]);

        $checkState = Periode::where('is_active','=',1)->get();
        $isActive = $request->input('is_active');
        foreach($checkState as $data){
            if($isActive == null) {
                $isActive = 0;
            } else {
                $data->update(['is_active' => 0]);
                $isActive = 1;
            }
        }

        $post = Periode::updateOrCreate(['id' => $request->id],
                [
                    'kode'          => $request->kode,
                    'nama_periode'  => $request->nama_periode,
                    'input_nilai'   => $request->input_nilai,
                    'temp_open'     => $request->temp_open,
                    'finish'        => $request->finish,
                    'is_active'     => $isActive,
                ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = Periode::where($where)->first();
     
        return response()->json($post);
    }

    public function switchPeriode(Request $request)
    {
        $checkState = Periode::where('is_active','=',1)->get();
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

        $post   = Periode::updateOrCreate(['id' => $request->id],['is_active' => $req]); 
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = Periode::where('id',$id)->delete();     
        return response()->json($post);
    }
}
