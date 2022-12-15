<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\StatusMahasiswa;
use App\Model\Periode;

class StatusMahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $dataStatusMahasiswa = StatusMahasiswa::where('is_archived','!=',1)->get();

        if($request->ajax()){
            return datatables()->of($dataStatusMahasiswa)
                ->addColumn('action', function($data){
                        $button = '<a href="javascript:void(0)" name="archive-status-mahasiswa" data-toggle="tooltip" data-placement="bottom" title="Archive" onclick="archiveStatusMahasiswa('.$data->id.','.$data->is_archived.')" data-id="'.$data->id.'" data-placement="bottom" data-original-title="archivestatusmahasiswa" class="archivestatusmahasiswa btn btn-warning btn-xs archive-post"><i class="bx bx-xs bx-archive"></i></a>';
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
        $getPeriode = Periode::where('is_active','=',1)->get();
        return view('administrator.status-mahasiswa.index', compact('getPeriode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_status'   => 'required',
            'id_periode'    => 'required',
        ],[
            'nama_status.required'         => 'Anda belum menginputkan nama status',
            'id_periode.required'          => 'Anda belum memilih periode'
        ]);

        $post = StatusMahasiswa::updateOrCreate(['id' => $request->id],
                [
                    'nama_status'       => $request->nama_status,
                    'keterangan'        => $request->keterangan,
                    'id_periode'        => $request->id_periode,
                    'is_archived'       => 0
                ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = StatusMahasiswa::where($where)->first();     
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = StatusMahasiswa::where('id',$id)->delete();     
        return response()->json($post);
    }

    public function archiveStatusMahasiswa(Request $request)
    {
        $req    = $request->is_archived == '1' ? 0 : 1;
        $post   = StatusMahasiswa::updateOrCreate(['id' => $request->id],['is_archived' => $req],['archived_at' => now()]); 
        return response()->json($post);
    }

    public function show(Request $request)
    {
        if($request->ajax()){
            return datatables()->of(StatusMahasiswa::getArchivedStatusMahasiswa())
                ->addColumn('action', function($data){
                        return '<a href="javascript:void(0)" name="unarchive-status-mahasiswa" data-toggle="tooltip" data-placement="bottom" title="Unarchive" onclick="unarchiveStatusMahasiswa('.$data->id.','.$data->is_archived.')" data-id="'.$data->id.'" data-placement="bottom" data-original-title="unarchivestatusmahasiswa" class="archivestatusmahasiswa unarchive-post"><i class="bx bx-sm bx-archive-out"></i></a>';
                })
                ->rawColumns(['action'])
                ->addIndexColumn(true)
                ->make(true);
        }
        return view('administrator.status-mahasiswa.index');
    }

    public function unarchiveStatusMahasiswa(Request $request)
    {
        $req    = $request->is_archived == '1' ? 0 : 1;
        $post   = StatusMahasiswa::updateOrCreate(['id' => $request->id],['is_archived' => $req]); 
        return response()->json($post);
    }
}
