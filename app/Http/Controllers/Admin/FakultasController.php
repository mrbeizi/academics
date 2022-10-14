<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Fakultas;
use DataTables;
use Response;
use Session;
use Validator;
use Auth;

class FakultasController extends Controller
{
    public function index(Request $request)
    {
        $dataFakultas = Fakultas::all();
                
        if($request->ajax()){
            return datatables()->of($dataFakultas)
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
        return view('administrator.fakultas.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_periode'        => 'required',
            'nama_id'           => 'required',
        ],[
            'id_periode.required'    => 'Anda belum memilih periode',
            'nama_id.required'       => 'Anda belum mamasukkan nama ID',

        ]);

        $post   =   Fakultas::updateOrCreate(['id' => $request->id],
                    [
                        'id_periode'  => $request->id_periode,
                        'nama_id'     => $request->nama_id,
                        'nama_en'     => $request->nama_en,
                        'nama_ch'     => $request->nama_ch,
                        'is_archived' => 0
                    ]); 

        return response()->json($post);
    }
}
