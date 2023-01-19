<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Keuangan\YearPeriod;
use Response;
use Session;
use Validator;
use Auth;

class YearPeriodController extends Controller
{
    public function index(Request $request)
    {
        $dataYearPeriod = YearPeriod::all();
                
        if($request->ajax()){
            return datatables()->of($dataYearPeriod)
                ->addColumn('action', function($data){
                        $button = '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="bottom" title="Edit" data-id="'.$data->id.'" data-original-title="Edit" class="edit btn btn-success btn-xs edit-post"><i class="bx bx-xs bx-edit"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="bx bx-xs bx-trash"></i></button>';
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
        return view('keuangan.year-period.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun'           => 'required',
        ],[
            'tahun.required'  => 'Anda belum mamasukkan tahun ajaran'
        ]);

        $checkState = YearPeriod::where('is_active','=',1)->get();
        $isActive = $request->input('is_active');
        foreach($checkState as $data){
            if($isActive == null) {
                $isActive = 0;
            } else {
                $data->update(['is_active' => 0]);
                $isActive = 1;
            }
        }

        $post   =   YearPeriod::updateOrCreate(['id' => $request->id],
                    [
                        'tahun'     => $request->tahun,
                        'is_active' => $isActive,
                    ]); 

        return response()->json($post);
    }

    public function switchPeriod(Request $request)
    {
        $checkState = YearPeriod::where('is_active','=',1)->get();
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

        $post   = YearPeriod::updateOrCreate(['id' => $request->id],['is_active' => $req]); 
        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = YearPeriod::where($where)->first();
     
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = YearPeriod::where('id',$id)->delete();     
        return response()->json($post);
    }
}
