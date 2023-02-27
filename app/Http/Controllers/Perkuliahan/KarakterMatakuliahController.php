<?php

namespace App\Http\Controllers\Perkuliahan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Perkuliahan\KarakterMatakuliah;
use App\Model\Periode;
use Response;
use Session;
use Validator;
use Auth;

class KarakterMatakuliahController extends Controller
{
    public function index(Request $request)
    {
        $getData = KarakterMatakuliah::leftJoin('periodes','periodes.id','=','karakter_matakuliahs.id_periode')
            ->select('karakter_matakuliahs.id AS id','karakter_matakuliahs.*','periodes.nama_periode')
            ->get();
                
        if($request->ajax()){
            return datatables()->of($getData)
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
        return view('perkuliahan.karakter-matakuliah.index', compact('getPeriode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_karakter' => 'required',
            'keterangan'    => 'required',
            'id_periode'    => 'required',
        ],[
            'nama_karakter.required' => 'Anda belum menginputkan nama karakter',
            'keterangan.required'    => 'Anda belum menginputkan keterangan',
            'id_periode.required'    => 'Anda belum memilih periode'
        ]);

        $post = KarakterMatakuliah::updateOrCreate(['id' => $request->id],
                [
                    'nama_karakter' => $request->nama_karakter,
                    'id_periode'    => $request->id_periode,
                    'keterangan'    => $request->keterangan,
                    'is_archived'   => 0,
                ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = KarakterMatakuliah::where($where)->first();
     
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = KarakterMatakuliah::where('id',$id)->delete();     
        return response()->json($post);
    }
}
