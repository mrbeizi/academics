<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\JabatanAkademik;
use App\Model\Periode;
use App\Model\Pegawai;
use App\Model\Jabatan;
use App\Model\Fakultas;
use App\Model\Prodi;

class JabatanAkademikController extends Controller
{
    public function index(Request $request)
    {
        $dataJabatanAkademik = JabatanAkademik::leftJoin('jabatans','jabatans.id','=','jabatan_akademiks.id_jabatan')
            ->leftJoin('pegawais','pegawais.id','=','jabatan_akademiks.id_pegawai')
            ->leftJoin('periodes','periodes.id','=','jabatan_akademiks.id_periode')
            ->leftJoin('fakultas','fakultas.id','=','jabatan_akademiks.fakultas')
            ->leftJoin('prodis','prodis.id','=','jabatan_akademiks.prodi')
            ->select('jabatan_akademiks.id AS id','pegawais.nama_in AS nama_pegawai','jabatans.nama_in AS nama_jabatan','periodes.nama_periode','fakultas.nama_id AS nama_fakultas','prodis.nama_id AS nama_prodi')
            ->where('jabatan_akademiks.is_archived','=',0)
            ->get();
                
        if($request->ajax()){
            return datatables()->of($dataJabatanAkademik)
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
        return view('administrator.jabatan-akademik.index', compact('getPeriode','getJabatan','getPegawai','getFakultas','getProdi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_periode' => 'required',
            'id_jabatan' => 'required',
            'id_pegawai' => 'required',
            'fakultas'   => 'required',
            'prodi'      => 'required',
        ],[
            'id_periode.required' => 'Anda belum memilih periode', 
            'id_jabatan.required' => 'Anda belum memilih jabatan',
            'id_pegawai.required' => 'Anda belum memilih nama pegawai',
            'fakultas.required'   => 'Anda belum memilih fakultas',
            'prodi.required'      => 'Anda belum memilih prodi'
        ]);

        $post = JabatanAkademik::updateOrCreate(['id' => $request->id],
                [
                    'id_jabatan'  => $request->id_jabatan,
                    'id_periode'  => $request->id_periode,
                    'id_pegawai'  => $request->id_pegawai,
                    'fakultas'    => $request->fakultas,
                    'prodi'       => $request->prodi,
                    'is_archived' => 0
                ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = JabatanAkademik::where($where)->first();
     
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = JabatanAkademik::where('id',$id)->delete();     
        return response()->json($post);
    }
}
