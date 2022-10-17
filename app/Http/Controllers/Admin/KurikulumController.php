<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Kurikulum;

class KurikulumController extends Controller
{
    public function index(Request $request)
    {
        $dataKurikulum = Kurikulum::all();
                
        if($request->ajax()){
            return datatables()->of($dataKurikulum)
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
        return view('administrator.kurikulum.index');
    }
}
