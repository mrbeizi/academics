<?php

namespace App\Http\Controllers\Perkuliahan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Prodi;
use App\Model\Periode;
use Response;
use Session;
use Validator;
use Auth;
use DB;

class InKelasController extends Controller
{
    public function index(Request $request, $id)
    {
        $dataKelas = DB::table('gol_mahasiswas')->leftJoin('mahasiswas','mahasiswas.nim','=','gol_mahasiswas.nim')
            ->leftJoin('gol_kelas','gol_kelas.id','=','gol_mahasiswas.id_golongan')
            ->leftJoin('periodes','periodes.id','=','gol_kelas.id_periode')
            ->leftJoin('status_mahasiswas','status_mahasiswas.id','=','mahasiswas.id_status_Mahasiswa')
            ->select('gol_mahasiswas.id AS id','gol_mahasiswas.*','mahasiswas.nama_mahasiswa','nama_status','gol_kelas.nama_golongan','periodes.nama_periode')
            ->where('gol_mahasiswas.id_golongan','=',$id)
            ->get();
        if($request->ajax()){
            return datatables()->of($dataKelas)
                ->addColumn('action', function($data){
                       return '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="bx bx-xs bx-trash"></i></button>';
                })
                ->rawColumns(['action'])
                ->addIndexColumn(true)
                ->make(true);
        }
        $getGolKelas = DB::table('gol_kelas')->where('id','!=',$id)->get();
        $getPeriode = Periode::all();
        $getProdi = Prodi::all();
        return view('perkuliahan.add-kelas.index',['id' => $id,'dataKelas' => $dataKelas,'getGolKelas' => $getGolKelas,'getPeriode' => $getPeriode, 'getProdi' => $getProdi]);
    }

    public function listMahasiswa(Request $request, $id)
    {
        $dataKelas = DB::table('gol_mahasiswas')->leftJoin('mahasiswas','mahasiswas.nim','=','gol_mahasiswas.nim')
            ->leftJoin('gol_kelas','gol_kelas.id','=','gol_mahasiswas.id_golongan')
            ->leftJoin('periodes','periodes.id','=','gol_kelas.id_periode')
            ->leftJoin('status_mahasiswas','status_mahasiswas.id','=','mahasiswas.id_status_Mahasiswa')
            ->select('gol_mahasiswas.id AS id','gol_mahasiswas.*','mahasiswas.nama_mahasiswa','nama_status','gol_kelas.nama_golongan','periodes.nama_periode')
            ->where('gol_mahasiswas.id_golongan','=',$id)
            ->get();
        if($request->ajax()){
            return datatables()->of($dataKelas)
                ->addColumn('action', function($data){
                       return '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="bx bx-xs bx-trash"></i></button>';
                })
                ->rawColumns(['action'])
                ->addIndexColumn(true)
                ->make(true);
        }
        $getProdi = Prodi::all();
        return view('perkuliahan.add-kelas.index',['id' => $id,'dataKelas' => $dataKelas,'getProdi' => $getProdi]);
    }

    public function destroy($id)
    {
        $post = DB::table('gol_mahasiswas')->where('id',$id)->delete();     
        return response()->json($post);
    }
}
