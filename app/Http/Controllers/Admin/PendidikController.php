<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Pendidik;
use App\Model\Periode;
use App\Model\Pegawai;
use App\Model\Jabatan;
use App\Model\Fakultas;
use App\Model\Prodi;

class PendidikController extends Controller
{
    public function index(Request $request)
    {
        $dataPendidik = Pendidik::leftJoin('jabatans','jabatans.id','=','pendidiks.id_jabatan')
            ->leftJoin('pegawais','pegawais.id','=','pendidiks.id_pegawai')
            ->leftJoin('periodes','periodes.id','=','pendidiks.id_periode')
            ->leftJoin('fakultas','fakultas.id','=','pendidiks.fakultas')
            ->leftJoin('prodis','prodis.id','=','pendidiks.prodi')
            ->select('pendidiks.id AS id','pegawais.nama_in AS nama_pegawai','jabatans.nama_in AS nama_jabatan','periodes.nama_periode','fakultas.nama_id AS nama_fakultas','prodis.nama_id AS nama_prodi','pendidiks.prodi AS prodi')
            ->where('pendidiks.is_archived','=',0)
            ->get();
                
        if($request->ajax()){
            return datatables()->of($dataPendidik)
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
        $getJabatan = Jabatan::all();
        $getPegawai = Pegawai::where('id_status_pegawai','=',1)->get();
        $getFakultas = Fakultas::where('is_archived','!=',1)->get();
        $getProdi = Prodi::where('is_archived','!=',1)->get();
        return view('administrator.pendidik.index', compact('getPeriode','getJabatan','getPegawai','getFakultas','getProdi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_periode' => 'required',
            'id_jabatan' => 'required',
            'id_pegawai' => 'required',
            'fakultas'   => 'required',
        ],[
            'id_periode.required' => 'Anda belum memilih periode', 
            'id_jabatan.required' => 'Anda belum memilih jabatan',
            'id_pegawai.required' => 'Anda belum memilih nama pegawai',
            'fakultas.required'   => 'Anda belum memilih fakultas'
        ]);

        if($request->prodi == ''){
            $prodi = 0;
        } else {
            $prodi = $request->prodi;
        }

        $post = Pendidik::updateOrCreate(['id' => $request->id],
                [
                    'id_jabatan'  => $request->id_jabatan,
                    'id_periode'  => $request->id_periode,
                    'id_pegawai'  => $request->id_pegawai,
                    'fakultas'    => $request->fakultas,
                    'prodi'       => $prodi,
                    'is_archived' => 0
                ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = Pendidik::where($where)->first();
     
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = Pendidik::where('id',$id)->delete();     
        return response()->json($post);
    }
}
