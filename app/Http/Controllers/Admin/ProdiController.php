<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Fakultas;
use App\Model\Periode;
use App\Model\Prodi;

class ProdiController extends Controller
{
    public function index(Request $request)
    {
        $dataProdi = Prodi::leftJoin('periodes','periodes.id','=','prodis.id_periode')
            ->leftJoin('fakultas','fakultas.id','=','prodis.id_fakultas')
            ->select('prodis.id AS id','prodis.*','periodes.nama_periode','fakultas.nama_id AS nama_fakultas')
            ->where('prodis.is_archived','=',0)
            ->get();
                
        if($request->ajax()){
            return datatables()->of($dataProdi)
                ->addColumn('action', function($data){
                        $button = '<a href="javascript:void(0)" name="archive-prodi" data-toggle="tooltip" data-placement="bottom" title="Archive" onclick="archiveProdi('.$data->id.','.$data->is_archived.')" data-id="'.$data->id.'" data-placement="bottom" data-original-title="archiveprodi" class="archiveprodi btn btn-warning btn-xs archive-post"><i class="bx bx-xs bx-archive"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Edit" data-original-title="Edit" class="edit btn btn-success btn-xs edit-post"><i class="bx bx-xs bx-edit"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Delete" class="delete btn btn-danger btn-xs"><i class="bx bx-xs bx-trash"></i></button>';
                        return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn(true)
                ->make(true);
        }
        $getFaculty = Fakultas::where('is_archived','=',0)->get();
        $getPeriode = Periode::where('is_active','=',1)->get();
        return view('administrator.prodi.index', compact('getFaculty','getPeriode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_prodi'    => 'required',
            'kode_dikti'    => 'required|numeric|digits_between:5,5',
            'kode_nim'      => 'required|numeric|digits_between:3,3',
            'id_fakultas'   => 'required',
            'id_periode'    => 'required',
            'nama_id'       => 'required',
        ],[
            'kode_prodi.required'          => 'Anda belum menginputkan kode prodi',
            'kode_dikti.required'          => 'Anda belum menginputkan kode dikti',
            'kode_dikti.digits_between'    => 'Kode Dikti harus 5 digit',
            'kode_nim.required'            => 'Anda belum menginputkan kode nim',
            'kode_nim.digits_between'      => 'Kode NIM harus 3 digit',
            'jenjang.required'             => 'Anda belum memilih jenjang',
            'id_fakultas.required'         => 'Anda belum memilih fakultas',
            'id_periode.required'          => 'Anda belum memilih periode',
            'nama_id.required'             => 'Anda belum menginputkan nama'
        ]);

        $post = Prodi::updateOrCreate(['id' => $request->id],
                [
                    'kode_prodi'        => $request->kode_prodi,
                    'kode_dikti'        => $request->kode_dikti,
                    'kode_nim'          => $request->kode_nim,
                    'jenjang'           => $request->jenjang,
                    'id_fakultas'       => $request->id_fakultas,
                    'id_periode'        => $request->id_periode,
                    'nama_id'           => $request->nama_id,
                    'nama_en'           => $request->nama_en,
                    'nama_ch'           => $request->nama_ch,
                    'is_archived'       => 0
                ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = Prodi::where($where)->first();     
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = Prodi::where('id',$id)->delete();     
        return response()->json($post);
    }

    public function archiveProdi(Request $request)
    {
        $req    = $request->is_archived == '1' ? 0 : 1;
        $post   = Prodi::updateOrCreate(['id' => $request->id],['is_archived' => $req],['archived_at' => now()]); 
        return response()->json($post);
    }

    public function show(Request $request)
    {
        if($request->ajax()){
            return datatables()->of(Prodi::getArchivedProdi())
                ->addColumn('action', function($data){
                        return '<a href="javascript:void(0)" name="unarchive-prodi" data-toggle="tooltip" data-placement="bottom" title="Unarchive" onclick="unarchiveProdi('.$data->id.','.$data->is_archived.')" data-id="'.$data->id.'" data-placement="bottom" data-original-title="unarchiveprodi" class="archiveprodi unarchive-post"><i class="bx bx-sm bx-archive-out"></i></a>';
                })
                ->rawColumns(['action'])
                ->addIndexColumn(true)
                ->make(true);
        }
        return view('administrator.prodi.index');
    }

    public function unarchiveProdi(Request $request)
    {
        $req    = $request->is_archived == '1' ? 0 : 1;
        $post   = Prodi::updateOrCreate(['id' => $request->id],['is_archived' => $req]); 
        return response()->json($post);
    }
}
