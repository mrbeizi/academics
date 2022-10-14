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
                })
                ->rawColumns(['action'])
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
