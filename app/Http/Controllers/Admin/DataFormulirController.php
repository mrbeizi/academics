<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\DataFormulir;
use App\Model\Periode;
use Response;
use Session;
use Validator;
use Auth;

class DataFormulirController extends Controller
{
    public function index(Request $request)
    {
        $dataFormulir = DataFormulir::leftJoin('periodes','periodes.id','=','data_formulirs.id_periode')
            ->select('data_formulirs.id AS id','data_formulirs.nama_data','periodes.nama_periode')
            ->where([['periodes.is_active','=',1],['data_formulirs.is_archived','=',0]])
            ->get();
                
        if($request->ajax()){
            return datatables()->of($dataFormulir)
                ->addColumn('action', function($data){
                        $button = '<a href="javascript:void(0)" name="archive-data-formulir" data-toggle="tooltip" data-placement="bottom" title="Archive" onclick="archiveDataFormulir('.$data->id.','.$data->is_archived.')" data-id="'.$data->id.'" data-placement="bottom" data-original-title="archiveDataFormulir" class="archiveDataFormulir btn btn-warning btn-xs archive-post"><i class="bx bx-xs bx-archive"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<a href="javascript:void(0)" data-toggle="tooltip" data-placement="bottom" title="Edit" data-id="'.$data->id.'" data-original-title="Edit" class="edit btn btn-success btn-xs edit-post"><i class="bx bx-xs bx-edit"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="bx bx-xs bx-trash"></i></button>';
                        return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn(true)
                ->make(true);
        }
        $getPeriode = Periode::where('is_active','=',1)->get();
        return view('administrator.data-formulir.index', compact('getPeriode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_periode'        => 'required',
            'nama_data'         => 'required',
            'no_urut'           => 'required',
        ],[
            'id_periode.required'    => 'Anda belum memilih periode',
            'nama_data.required'     => 'Anda belum mamasukkan nama data',
            'no_urut.required'       => 'Anda belum mamasukkan no urut'

        ]);

        $post   =   DataFormulir::updateOrCreate(['id' => $request->id],
                    [
                        'id_periode'  => $request->id_periode,
                        'nama_data'   => $request->nama_data,
                        'no_urut'     => $request->no_urut,
                        'is_archived' => 0
                    ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = DataFormulir::where($where)->first();
     
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = DataFormulir::where('id',$id)->delete();     
        return response()->json($post);
    }

    public function archiveDataFormulir(Request $request)
    {
        $req    = $request->is_archived == '1' ? 0 : 1;
        $post   = DataFormulir::updateOrCreate(['id' => $request->id],['is_archived' => $req,'archived_at' => now()]); 
        return response()->json($post);
    }

    public function show(Request $request)
    {
        if($request->ajax()){
            return datatables()->of(DataFormulir::getArchivedDataFormulir())
                ->addColumn('action', function($data){
                        return '<a href="javascript:void(0)" name="unarchive-data-formulir" data-toggle="tooltip" data-placement="bottom" title="Unarchive" onclick="unarchiveDataFormulir('.$data->id.','.$data->is_archived.')" data-id="'.$data->id.'" data-placement="bottom" data-original-title="unarchivedataformulir" class="archivedataformulir unarchive-post"><i class="bx bx-sm bx-archive-out"></i></a>';
                })
                ->rawColumns(['action'])
                ->addIndexColumn(true)
                ->make(true);
        }
        return view('administrator.data-formulir.index');
    }

    public function unarchiveDataFormulir(Request $request)
    {
        $req    = $request->is_archived == '1' ? 0 : 1;
        $post   = DataFormulir::updateOrCreate(['id' => $request->id],['is_archived' => $req]); 
        return response()->json($post);
    }
}
