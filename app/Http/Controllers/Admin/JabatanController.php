<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Jabatan;
use App\Model\Periode;

class JabatanController extends Controller
{
    public function index(Request $request)
    {
        $dataJabatan = Jabatan::leftJoin('periodes','periodes.id','=','jabatans.id_periode')
            ->select('jabatans.id AS id','jabatans.*','periodes.nama_periode')
            ->where('periodes.is_active','=',1)
            ->get();
                
        if($request->ajax()){
            return datatables()->of($dataJabatan)
                ->addColumn('action', function($data){
                        $button = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Edit" data-original-title="Edit" class="edit btn btn-success btn-xs edit-post"><i class="bx bx-xs bx-edit"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Delete" class="delete btn btn-danger btn-xs"><i class="bx bx-xs bx-trash"></i></button>';
                        return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn(true)
                ->make(true);
        }
        $getPeriode = Periode::where('is_active','=',1)->get();
        return view('administrator.jabatan.index', compact('getPeriode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_periode'    => 'required',
            'kode_jabatan'  => 'required',
            'nama_in'       => 'required',
            'golongan'      => 'required',
        ],[
            'id_periode.required'    => 'Anda belum memilih periode',
            'kode_jabatan.required'  => 'Anda belum menginputkan kode jabatan',
            'nama_in.required'       => 'Anda belum menginputkan nama jabatan',
            'golongan.required'      => 'Anda belum menginputkan golongan'
        ]);

        $post = Jabatan::updateOrCreate(['id' => $request->id],
                [
                    'id_periode'        => $request->id_periode,
                    'kode_jabatan'      => $request->kode_jabatan,
                    'nama_in'           => $request->nama_in,
                    'nama_en'           => $request->nama_en,
                    'nama_ch'           => $request->nama_ch,
                    'golongan'          => $request->golongan
                ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = Jabatan::where($where)->first();     
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = Jabatan::where('id',$id)->delete();     
        return response()->json($post);
    }

}
