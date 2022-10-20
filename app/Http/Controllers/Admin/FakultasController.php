<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use App\Model\Fakultas;
use App\Model\Periode;
// use DataTables;
use Response;
use Session;
use Validator;
use Auth;

class FakultasController extends Controller
{
    public function index(Request $request)
    {
        $dataFakultas = Fakultas::leftJoin('periodes','periodes.id','=','fakultas.id_periode')
            ->select('fakultas.id AS id','fakultas.*','periodes.nama_periode')
            ->where([['periodes.is_active','=',1],['fakultas.is_archived','=',0]])
            ->get();
                
        if($request->ajax()){
            return datatables()->of($dataFakultas)
                ->addColumn('action', function($data){
                        $button = '<a href="javascript:void(0)" name="archive-faculty" data-toggle="tooltip" data-placement="bottom" title="Archive" onclick="archiveFaculty('.$data->id.','.$data->is_archived.')" data-id="'.$data->id.'" data-placement="bottom" data-original-title="archivefaculty" class="archivefaculty btn btn-warning btn-xs archive-post"><i class="fa fa-archive"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="bottom" title="Edit" data-id="'.$data->id.'" data-original-title="Edit" class="edit btn btn-success btn-xs edit-post"><i class="fa fa-pen"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fa fa-trash"></i></button>';
                        return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn(true)
                ->make(true);
        }
        $getPeriode = Periode::where('is_active','=',1)->get();
        return view('administrator.fakultas.index', compact('getPeriode'));
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

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = Fakultas::where($where)->first();
     
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = Fakultas::where('id',$id)->delete();     
        return response()->json($post);
    }

    public function archiveFaculty(Request $request)
    {
        $req    = $request->is_archived == '1' ? 0 : 1;
        $post   = Fakultas::updateOrCreate(['id' => $request->id],['is_archived' => $req]); 
        return response()->json($post);
    }

}
