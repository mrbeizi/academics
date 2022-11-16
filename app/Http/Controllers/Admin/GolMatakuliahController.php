<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\GolMatakuliah;

class GolMatakuliahController extends Controller
{
    public function index(Request $request)
    {
        $dataGolongan = GolMatakuliah::all();
                
        if($request->ajax()){
            return datatables()->of($dataGolongan)
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
        return view('administrator.gol-matakuliah.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_golongan'               => 'required',
        ],[
            'nama_golongan.required'      => 'Anda belum menginputkan nama golongan'
        ]);

        $post = GolMatakuliah::updateOrCreate(['id' => $request->id],
                [
                    'nama_golongan'     => $request->nama_golongan,
                    'keterangan'        => $request->keterangan
                ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = GolMatakuliah::where($where)->first();
     
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = GolMatakuliah::where('id',$id)->delete();     
        return response()->json($post);
    }
}
