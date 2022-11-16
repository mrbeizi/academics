<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\JabatanPegawai;
use App\Model\Periode;
use App\Model\Jabatan;
use App\Model\Pegawai;

class JabatanPegawaiController extends Controller
{
    public function index(Request $request)
    {
        $dataJabatanPegawai = JabatanPegawai::leftJoin('jabatans','jabatans.id','=','jabatan_pegawais.id_jabatan')
            ->leftJoin('pegawais','pegawais.id','=','jabatan_pegawais.id_pegawai')
            ->leftJoin('periodes','periodes.id','=','jabatan_pegawais.id_periode')
            ->select('jabatan_pegawais.id AS id','pegawais.nama_in AS nama_pegawai','jabatans.nama_in AS nama_jabatan','periodes.nama_periode')
            ->where('is_archived','=',0)
            ->get();
                
        if($request->ajax()){
            return datatables()->of($dataJabatanPegawai)
                ->addColumn('action', function($data){
                        $button = '<a href="javascript:void(0)" name="archive-jabatan-pegawai" data-toggle="tooltip" data-placement="bottom" title="Archive" onclick="archiveJabatanPegawai('.$data->id.','.$data->is_archived.')" data-id="'.$data->id.'" data-placement="bottom" data-original-title="archivejabatanpegawai" class="archivejabatanpegawai btn btn-warning btn-xs archive-post"><i class="bx bx-xs bx-archive"></i></a>';
                        $button .= '&nbsp;';
                        $button .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Edit" data-original-title="Edit" class="edit btn btn-success btn-xs edit-post"><i class="bx bx-xs bx-edit"></i></a>';
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
        return view('administrator.jabatan-pegawai.index', compact('getPeriode','getJabatan','getPegawai'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_periode' => 'required',
            'id_jabatan' => 'required',
            'id_pegawai' => 'required',
        ],[
            'id_periode.required' => 'Anda belum memilih periode', 
            'id_jabatan.required' => 'Anda belum memilih jabatan',
            'id_pegawai.required' => 'Anda belum memilih nama pegawai'
        ]);

        $post = JabatanPegawai::updateOrCreate(['id' => $request->id],
                [
                    'id_jabatan'  => $request->id_jabatan,
                    'id_periode'  => $request->id_periode,
                    'id_pegawai'  => $request->id_pegawai,
                    'is_archived' => 0
                ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = JabatanPegawai::where($where)->first();
     
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = JabatanPegawai::where('id',$id)->delete();     
        return response()->json($post);
    }

    public function archiveJabatanPegawai(Request $request)
    {
        $req    = $request->is_archived == '1' ? 0 : 1;
        $post   = JabatanPegawai::updateOrCreate(['id' => $request->id],['is_archived' => $req],['archived_at' => now()]); 
        return response()->json($post);
    }

    public function show(Request $request)
    {       
        if($request->ajax()){
            return datatables()->of(JabatanPegawai::getArchivedJabatanPegawai())
                ->addColumn('action', function($data){
                        return '<a href="javascript:void(0)" name="unarchive-jabatan-pegawai" data-toggle="tooltip" data-placement="bottom" title="Unarchive" onclick="unarchiveJabatanPegawai('.$data->id.','.$data->is_archived.')" data-id="'.$data->id.'" data-placement="bottom" data-original-title="unarchivejabatanpegawai" class="archivejabatanpegawai unarchive-post"><i class="bx bx-sm bx-archive-out"></i></a>';
                })
                ->rawColumns(['action'])
                ->addIndexColumn(true)
                ->make(true);
        }
        return view('administrator.jabatan-pegawai.index');
    }

    public function unarchiveJabatanPegawai(Request $request)
    {
        $req    = $request->is_archived == '1' ? 0 : 1;
        $post   = JabatanPegawai::updateOrCreate(['id' => $request->id],['is_archived' => $req]); 
        return response()->json($post);
    }
}
