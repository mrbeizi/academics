<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\GolMatakuliah;
use App\Model\Fakultas;
use App\Model\Prodi;

class GolMatakuliahController extends Controller
{
    public function index(Request $request)
    {
        $dataGolongan = GolMatakuliah::leftJoin('prodis','prodis.id','=','gol_matakuliahs.id_prodi')
            ->leftJoin('fakultas','fakultas.id','=','gol_matakuliahs.id_fakultas')
            ->select('gol_matakuliahs.id AS id','gol_matakuliahs.nama_golongan','gol_matakuliahs.keterangan','prodis.nama_id AS nama_prodi','fakultas.nama_id AS nama_fakultas')
            ->get();
                
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
        $getFakultas = Fakultas::where('is_archived','=',0)->get();
        $getProdi = Prodi::where('is_archived','=',0)->get();
        return view('administrator.gol-matakuliah.index', compact('getFakultas','getProdi'));
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
                    'nama_golongan'   => $request->nama_golongan,
                    'id_fakultas'     => $request->id_fakultas,
                    'id_prodi'        => $request->id_prodi,
                    'keterangan'      => $request->keterangan
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
