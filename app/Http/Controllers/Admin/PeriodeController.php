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
                        $button = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->id.'" data-original-title="Edit" class="edit btn btn-outline-success btn-sm edit-post"><i class="fa fa-pen"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i></button>';
                        return $button;
                })->addColumn('status', function($data){
                    return '<div class="custom-control">
                    <label class="switch switch-primary" for="'.$data->id.'">
                    <input type="checkbox" class="switch-input PeriodeStatus" onclick="changeStatus('.$data->id.','.$data->is_active.')" name="period-status" id="'.$data->id.'" '.(($data->is_active=='1')?'checked':"").'>
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
            'tahun'        => 'required',
        ],[
            'tahun.required'    => 'Anda belum menginputkan tahun',

        ]);

        $post   =   Periode::updateOrCreate(['id' => $request->id],
                    [
                        'tahun'  => $request->tahun,
                        'is_active' => 1,
                        'is_archived' => 0
                    ]); 

        return response()->json($post);
    }
}
