<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Periode;
use App\Model\Keuangan\Fine;
use Response;
use Session;
use Validator;
use Auth;

class FineController extends Controller
{
    public function index(Request $request)
    {
        $dataFines = Fine::leftJoin('periodes','periodes.id','=','fines.id_periode')
            ->select('fines.id AS id','fines.*','periodes.nama_periode','periodes.kode')
            ->where('periodes.is_active',1)
            ->orderBy('fines.created_at','DESC')
            ->get();
        if($request->ajax()){
            return datatables()->of($dataFines)
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
        $getPeriode = Periode::where('is_active','=',1)->get();
        return view('keuangan.fines.index', compact('getPeriode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_periode'    => 'required',
            'tgl_deadline'  => 'required',
            'nilai'         => 'required',
        ],[
            'id_periode.required'        => 'Anda belum memilih periode',
            'tgl_deadline.required'      => 'Anda belum menginputkan tgl deadline',
            'nilai.required'             => 'Anda belum menginputkan nilai denda'
        ]);

        $post = Fine::updateOrCreate(['id' => $request->id],
                [
                    'id_periode'      => $request->id_periode,
                    'tgl_deadline'    => $request->tgl_deadline,
                    'nilai'           => preg_replace('/\D/','', $request->nilai),
                ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = Fine::where($where)->first();     
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = Fine::where('id',$id)->delete();     
        return response()->json($post);
    }
}
